<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\RawApiData;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Series; // 追加
use App\Models\ProductSeries; // 追加
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessDugaImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $limit;
    protected int $batchSize;
    protected ?int $maxItems;

    // DUGA APIの定数
    const DUGA_API_VERSION = '1.2';
    const DUGA_AGENT_ID = '48043';
    const DUGA_BANNER_ID = '01';
    const DUGA_FORMAT = 'json';
    const DUGA_ADULT = 1;
    const DUGA_SORT = 'favorite';
    const DUGA_API_PATH = '/product/search';

    /**
     * コンストラクタ
     *
     * @param int $limit 1回のAPIリクエストで取得するアイテム数（DUGA APIのhitsパラメータに相当）
     * @param int $batchSize データベースに一括保存する際のバッチサイズ
     * @param int|null $maxItems 全体で取得する最大アイテム数 (nullの場合は制限なし)
     */
    public function __construct(int $limit = 100, int $batchSize = 500, ?int $maxItems = null)
    {
        $this->limit = $limit; 
        $this->batchSize = $batchSize;
        $this->maxItems = $maxItems;
    }

    /**
     * ジョブの実行ハンドル
     * APIからデータを取得し、データベースに保存する
     */
    public function handle(): void
    {
        Log::info('DUGA製品インポートジョブを開始します...');

        $baseUrl = env('DUGA_API_URL');
        $apiKey = env('DUGA_API_KEY');

        if (!$baseUrl || !$apiKey) {
            Log::error('DUGA_API_URL または DUGA_API_KEY が .env ファイルに設定されていません。ジョブを中断します。');
            return;
        }

        $limit = $this->limit;
        $batchSize = $this->batchSize;
        $maxItems = $this->maxItems;

        $offset = 1;
        $totalProductsFetched = 0;
        $totalProductsSaved = 0;
        $totalApiRequests = 0;

        // バッファを初期化
        $rawProductsBuffer = []; // RawApiData用
        $processedProductsBuffer = []; // Product用
        $categoriesToProcess = []; // Category用 (重複を避けるためにキーで管理)
        $productCategoriesToProcess = []; // ProductCategory用
        $seriesToProcess = []; // Series用 (重複を避けるためにキーで管理) // ★追加
        $productSeriesToProcess = []; // ProductSeries用 // ★追加

        do {
            // maxItems制限に達した場合、現在のバッチ処理を終えて停止
            if ($maxItems !== null && $totalProductsFetched >= $maxItems) {
                Log::info("maxItems制限 ({$maxItems}件) に達しました。現在のバッチを処理後、停止します。");
                break;
            }

            try {
                $totalApiRequests++;
                
                // 残りの取得すべきアイテム数を計算し、現在のリクエストのhitsを調整
                $remainingItems = ($maxItems !== null) ? ($maxItems - $totalProductsFetched) : PHP_INT_MAX;
                $currentRequestLimit = min($limit, $remainingItems);

                // 取得すべきアイテムが0以下になったらループを終了
                if ($currentRequestLimit <= 0) {
                    Log::info("maxItems制限に基づき、これ以上取得するアイテムがありません。ループを終了します。");
                    break;
                }

                $params = [
                    'version' => self::DUGA_API_VERSION,
                    'appid' => $apiKey,
                    'agentid' => self::DUGA_AGENT_ID,
                    'bannerid' => self::DUGA_BANNER_ID,
                    'format' => self::DUGA_FORMAT,
                    'adult' => self::DUGA_ADULT,
                    'sort' => self::DUGA_SORT,
                    'hits' => $currentRequestLimit,
                    'offset' => $offset,
                ];

                $requestUrl = $baseUrl . self::DUGA_API_PATH;
                Log::info("DUGA APIからデータを取得中 (オフセット: {$offset}, ヒット数: {$currentRequestLimit})。リクエスト #{$totalApiRequests}");
                
                $response = Http::timeout(60)->get($requestUrl, $params);
                
                // デバッグログの詳細化
                Log::debug('DUGA API 完全なリクエストURL: ' . $response->effectiveUri());
                Log::debug('DUGA API 送信パラメータ: ' . json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                Log::debug('DUGA API レスポンスステータス: ' . $response->status()); 
                Log::debug('DUGA API 生のレスポンスボディ: ' . $response->body());

                if ($response->successful()) {
                    $responseData = $response->json();
                    
                    // JSONデコードのエラーチェック
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $errorMsg = json_last_error_msg();
                        Log::error("JSONデコードエラー: {$errorMsg}。生のレスポンス: " . $response->body());
                        // エラーが発生した場合はこのバッチの処理をスキップし、ループを抜ける
                        break; 
                    }

                    Log::debug('DUGA API デコードされたレスポンス (json_encode): ' . json_encode($responseData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

                    $rawItems = $responseData['items'] ?? [];
                    $items = [];
                    // DUGA APIのレスポンス構造 'items': [{'item': {...}}, {'item': {...}}] を考慮
                    if (is_array($rawItems)) {
                        foreach ($rawItems as $rawItem) {
                            if (isset($rawItem['item'])) {
                                $items[] = $rawItem['item'];
                            }
                        }
                    }

                    $currentBatchCount = count($items);
                    if ($currentBatchCount === 0) {
                        Log::info('APIからの製品が見つからないか、"items"配列が空です。インポートを終了します。');
                        break;
                    }

                    foreach ($items as $productItem) {
                        // ループ中にmaxItems制限に達した場合の追加チェック
                        if ($maxItems !== null && $totalProductsFetched >= $maxItems) {
                            Log::info("maxItems制限 ({$maxItems}件) が現在のバッチ内で達しました。現在のバッチを処理後、停止します。");
                            break 2; // 親のdo-whileループも抜ける
                        }

                        $productId = $productItem['productid'] ?? null;

                        if (!$productId) {
                            Log::warning('productid がないDUGA製品をスキップします: ' . json_encode($productItem, JSON_UNESCAPED_UNICODE));
                            continue;
                        }

                        // RawApiDataのバッファに追加
                        $rawProductsBuffer[] = [
                            'api_source' => 'DUGA',
                            'external_id' => (string)$productId,
                            'raw_json_data' => json_encode($productItem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                            'fetched_at' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];

                        // 価格のパース
                        [$priceMin, $priceMax] = $this->parsePrice($productItem['price'] ?? null);

                        // 画像URLの抽出
                        $posterImageUrl = $this->extractImageUrl($productItem, 'posterimage');
                        $jacketImageUrl = $this->extractImageUrl($productItem, 'jacketimage');
                        $thumbnailMainUrl = $this->extractThumbnailUrl($productItem);

                        // サンプル動画URLの抽出
                        [$sampleMovieUrl, $sampleMovieCapture] = $this->extractSampleMovieUrl($productItem);
                        
                        // その他のデータ抽出（配列になっている可能性を考慮）
                        $labelId = $productItem['label'][0]['id'] ?? null;
                        $labelName = $productItem['label'][0]['name'] ?? null;
                        // シリーズIDとシリーズ名はこの後、専用のバッファで処理するため、Productデータからは除外
                        $rankingTotal = $productItem['ranking'][0]['total'] ?? null;
                        
                        $reviewRating = $productItem['review']['average'] ?? null;
                        $reviewCount = $productItem['review']['count'] ?? null;

                        $mylistTotal = $productItem['mylist'][0]['total'] ?? null;

                        // Productデータのバッファに追加
                        $processedProductsBuffer[] = [
                            'productid' => (string)$productId,
                            'title' => $productItem['title'] ?? 'タイトルなし',
                            'caption' => $productItem['caption'] ?? null,
                            'makername' => $productItem['makername'] ?? null,
                            'url' => $productItem['url'] ?? null,
                            'affiliateurl' => $productItem['affiliateurl'] ?? null,
                            'opendate' => isset($productItem['opendate']) ? Carbon::parse($productItem['opendate'])->toDateString() : null,
                            'releasedate' => isset($productItem['releasedate']) ? Carbon::parse($productItem['releasedate'])->toDateString() : null,
                            'itemno' => $productItem['itemno'] ?? null,
                            'price_text' => $productItem['price'] ?? null,
                            'price_min' => $priceMin,
                            'price_max' => $priceMax,
                            'volume' => $productItem['volume'] ?? null,
                            'posterimage_large' => $posterImageUrl,
                            'jacketimage_large' => $jacketImageUrl,
                            'thumbnail_main' => $thumbnailMainUrl,
                            'samplemovie_url' => $sampleMovieUrl,
                            'samplemovie_capture' => $sampleMovieCapture,
                            'label_id' => $labelId,
                            'label_name' => $labelName,
                            // 'series_id' と 'series_name' は Product テーブルから削除し、関連テーブルで管理するためここから削除 // ★修正
                            'ranking_total' => $rankingTotal,
                            'review_rating' => $reviewRating,
                            'review_count' => $reviewCount,
                            'mylist_total' => $mylistTotal,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];

                        // カテゴリデータの処理
                        if (isset($productItem['category']) && is_array($productItem['category'])) {
                            Log::debug("Found 'category' array for product: {$productId}.");

                            if (!empty($productItem['category'])) {
                                foreach ($productItem['category'] as $categoryEntry) {
                                    if (isset($categoryEntry['data']) && is_array($categoryEntry['data'])) {
                                        $categoryData = $categoryEntry['data'];

                                        if (isset($categoryData['id']) && isset($categoryData['name'])) {
                                            $categoryId = (string)$categoryData['id'];
                                            $categoryName = $categoryData['name'];

                                            Log::debug("Adding category to buffer: ID={$categoryId}, Name='{$categoryName}' for product {$productId}.");

                                            $categoriesToProcess[$categoryId] = [
                                                'id' => $categoryId,
                                                'name' => $categoryName,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                                            $productCategoriesToProcess[] = [
                                                'product_external_id' => (string)$productId,
                                                'category_external_id' => $categoryId,
                                                'source_asp' => 'DUGA',
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                                            Log::debug("Added product-category link to buffer: ProductID={$productId}, CategoryID={$categoryId}.");
                                        } else {
                                            Log::warning("Category data for product {$productId} is missing 'id' or 'name' keys.", ['categoryData' => $categoryData]);
                                        }
                                    } else {
                                        Log::warning("Category entry for product {$productId} is missing 'data' key or 'data' is not an array.", ['categoryEntry' => $categoryEntry]);
                                    }
                                }
                            } else {
                                Log::info("Category array is empty for product: {$productId}.");
                            }
                        } else {
                            Log::info("No 'category' array found for product: {$productId}.");
                        }

                        // シリーズデータの処理 // ★追加
                        if (isset($productItem['series']) && is_array($productItem['series'])) {
                            Log::debug("Found 'series' array for product: {$productId}.");
                            foreach ($productItem['series'] as $seriesEntry) {
                                if (isset($seriesEntry['id']) && isset($seriesEntry['name'])) {
                                    $seriesId = (string)$seriesEntry['id'];
                                    $seriesName = $seriesEntry['name'];

                                    Log::debug("Adding series to buffer: ID={$seriesId}, Name='{$seriesName}' for product {$productId}.");

                                    $seriesToProcess[$seriesId] = [
                                        'id' => $seriesId,
                                        'name' => $seriesName,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                                    $productSeriesToProcess[] = [
                                        'product_external_id' => (string)$productId,
                                        'series_external_id' => $seriesId,
                                        'source_asp' => 'DUGA',
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                                    Log::debug("Added product-series link to buffer: ProductID={$productId}, SeriesID={$seriesId}.");
                                } else {
                                    Log::warning("Series entry for product {$productId} is missing 'id' or 'name' keys.", ['seriesEntry' => $seriesEntry]);
                                }
                            }
                        } else {
                            Log::info("No 'series' array found for product: {$productId}.");
                        }


                        $totalProductsFetched++;

                        // バッチサイズに達したらデータを保存
                        if (count($processedProductsBuffer) >= $batchSize) {
                            $categoriesToSave = array_values($categoriesToProcess); // キーをリセットしてupsert用に整形
                            $seriesToSave = array_values($seriesToProcess); // キーをリセットしてupsert用に整形 // ★追加
                            $this->saveBuffers(
                                $rawProductsBuffer,
                                $processedProductsBuffer,
                                $categoriesToSave,
                                $productCategoriesToProcess,
                                $seriesToSave, // ★追加
                                $productSeriesToProcess, // ★追加
                                $batchSize
                            );
                            $totalProductsSaved += count($rawProductsBuffer);
                            // バッファをクリア
                            $rawProductsBuffer = [];
                            $processedProductsBuffer = [];
                            $categoriesToProcess = [];
                            $productCategoriesToProcess = [];
                            $seriesToProcess = []; // ★クリア
                            $productSeriesToProcess = []; // ★クリア
                        }
                    }

                    $offset += $currentBatchCount;
                    Log::info("{$currentBatchCount}件のアイテムを取得しました。これまでに合計: {$totalProductsFetched}件。");

                } else {
                    // APIが成功しなかった場合
                    Log::error('DUGA APIからのデータ取得に失敗しました。ステータスコードが成功ではありませんでした。', [
                        'status' => $response->status(), 
                        'body' => $response->body(), 
                        'offset' => $offset, 
                        'limit' => $currentRequestLimit, 
                        'params' => $params
                    ]);
                    break;
                }
            } catch (RequestException $e) {
                // HTTPクライアントのエラー (例: タイムアウト、4xx/5xxレスポンス)
                Log::error('DUGA APIインポート中にHTTPリクエストエラーが発生しました: ' . $e->getMessage(), [
                    'offset' => $offset, 
                    'limit' => $limit, 
                    'api_url' => $baseUrl . self::DUGA_API_PATH, 
                    'params' => $params, 
                    'response_body' => $e->response ? $e->response->body() : 'N/A',
                    'trace' => $e->getTraceAsString()
                ]);
                break;
            } catch (Exception $e) {
                // その他の予期せぬエラー
                Log::error('DUGA APIインポートジョブ中に予期せぬエラーが発生しました: ' . $e->getMessage(), [
                    'offset' => $offset, 
                    'limit' => $limit, 
                    'api_url' => $baseUrl . self::DUGA_API_PATH, 
                    'params' => $params, 
                    'trace' => $e->getTraceAsString()
                ]);
                break;
            }
        } while ($currentBatchCount > 0); // 取得件数が0になるまでループ

        // 残りのバッファデータを保存
        // ★条件追加
        if (!empty($rawProductsBuffer) || !empty($processedProductsBuffer) || !empty($categoriesToProcess) || !empty($productCategoriesToProcess) || !empty($seriesToProcess) || !empty($productSeriesToProcess)) {
            Log::info("残りのバッファアイテム (件数: " . count($rawProductsBuffer) . ") をMySQLに保存します。");
            $categoriesToSave = array_values($categoriesToProcess);
            $seriesToSave = array_values($seriesToProcess); // ★追加
            $this->saveBuffers(
                $rawProductsBuffer,
                $processedProductsBuffer,
                $categoriesToSave,
                $productCategoriesToProcess,
                $seriesToSave, // ★追加
                $productSeriesToProcess, // ★追加
                count($rawProductsBuffer)
            );
            $totalProductsSaved += count($rawProductsBuffer);
        }

        Log::info("DUGA製品インポートジョブが完了しました。総APIリクエスト数: {$totalApiRequests}件。取得した製品総数: {$totalProductsFetched}件。保存/更新された製品総数: {$totalProductsSaved}件。");
    }

    /**
     * 各バッファに溜まったデータをデータベースに一括保存する
     *
     * @param array<int, array<string, mixed>> $rawBuffer 生APIデータのバッファ
     * @param array<int, array<string, mixed>> $processedBuffer 処理済み製品データのバッファ
     * @param array<int, array<string, mixed>> $categoriesBuffer カテゴリデータのバッファ
     * @param array<int, array<string, mixed>> $productCategoriesBuffer 製品カテゴリ関連データのバッファ
     * @param array<int, array<string, mixed>> $seriesBuffer シリーズデータのバッファ // ★追加
     * @param array<int, array<string, mixed>> $productSeriesBuffer 製品シリーズ関連データのバッファ // ★追加
     * @param int $count 保存されるアイテムの総数（ログ出力用）
     * @throws \RuntimeException データベース保存に失敗した場合
     */
    private function saveBuffers(
        array &$rawBuffer, 
        array &$processedBuffer, 
        array &$categoriesBuffer,
        array &$productCategoriesBuffer, 
        array &$seriesBuffer, // ★追加
        array &$productSeriesBuffer, // ★追加
        int $count
    ): void {
        // 全てのバッファが空の場合は警告してスキップ // ★条件追加
        if (empty($rawBuffer) && empty($processedBuffer) && empty($categoriesBuffer) && empty($productCategoriesBuffer) && empty($seriesBuffer) && empty($productSeriesBuffer)) {
            Log::warning("空のバッファを保存しようとしました。バッチ保存をスキップします。");
            return;
        }

        DB::transaction(function () use (&$rawBuffer, &$processedBuffer, &$categoriesBuffer, &$productCategoriesBuffer, &$seriesBuffer, &$productSeriesBuffer, $count) { // ★useに追加
            try {
                if (!empty($rawBuffer)) {
                    RawApiData::upsert(
                        $rawBuffer,
                        ['external_id'],
                        ['raw_json_data', 'fetched_at', 'updated_at']
                    );
                }

                if (!empty($processedBuffer)) {
                    Product::upsert(
                        $processedBuffer,
                        ['productid'],
                        [
                            'title', 'caption', 'makername', 'url', 'affiliateurl', 'releasedate', 'opendate', 'itemno',
                            'price_text', 'price_min', 'price_max', 'volume',
                            'posterimage_large', 'jacketimage_large', 'thumbnail_main',
                            'samplemovie_url', 'samplemovie_capture',
                            'label_id', 'label_name', 
                            // 'series_id', 'series_name', // ★Productテーブルから削除し、関連テーブルで管理するため削除
                            'ranking_total', 'review_rating', 'review_count', 'mylist_total',
                            'updated_at'
                        ]
                    );
                }

                if (!empty($categoriesBuffer)) {
                    Category::upsert(
                        $categoriesBuffer,
                        ['id'], // カテゴリIDがユニークキー
                        ['name', 'updated_at']
                    );
                }

                if (!empty($productCategoriesBuffer)) {
                    ProductCategory::upsert(
                        $productCategoriesBuffer,
                        ['product_external_id', 'category_external_id'], // product_external_id と category_external_id の組み合わせがユニークキー
                        ['source_asp', 'updated_at']
                    );
                }

                // シリーズのupsert // ★追加
                if (!empty($seriesBuffer)) {
                    Series::upsert(
                        $seriesBuffer,
                        ['id'], // シリーズIDがユニークキー
                        ['name', 'updated_at']
                    );
                }

                // 製品-シリーズ関連のupsert // ★追加
                if (!empty($productSeriesBuffer)) {
                    ProductSeries::upsert(
                        $productSeriesBuffer,
                        ['product_external_id', 'series_external_id'], // 複合ユニークキー
                        ['source_asp', 'updated_at']
                    );
                }

                Log::info("{$count}件のアイテムと関連データをバッチでMySQLに保存しました。");
            } catch (Exception $e) {
                Log::error("MySQLへのバッチ保存に失敗しました: " . $e->getMessage(), [
                    'raw_buffer_count' => count($rawBuffer),
                    'processed_buffer_count' => count($processedBuffer),
                    'categories_buffer_count' => count($categoriesBuffer),
                    'product_categories_buffer_count' => count($productCategoriesBuffer),
                    'series_buffer_count' => count($seriesBuffer), // ★追加
                    'product_series_buffer_count' => count($productSeriesBuffer), // ★追加
                    'exception_trace' => $e->getTraceAsString()
                ]);
                // トランザクションをロールバックさせるため、例外を再スロー
                throw new \RuntimeException("トランザクション内でMySQLへのバッチ保存に失敗しました: " . $e->getMessage(), 0, $e);
            }
        });
    }

    /**
     * 価格文字列をパースして最小価格と最大価格を抽出する
     *
     * @param string|null $priceText
     * @return array{int|null, int|null} [price_min, price_max]
     */
    private function parsePrice(?string $priceText): array
    {
        $priceMin = null;
        $priceMax = null;
        if ($priceText) {
            if (preg_match('/^(\d+)\s*円(?:～(\d+)\s*円)?$/u', $priceText, $matches)) {
                $priceMin = (int)$matches[1];
                $priceMax = isset($matches[2]) ? (int)$matches[2] : $priceMin;
            } else {
                // 「円」が含まれないなど、上記パターンにマッチしない場合、数値だけを抽出
                $numericPrice = (int)preg_replace('/[^0-9]/', '', $priceText);
                $priceMin = $numericPrice;
                $priceMax = $numericPrice;
            }
        }
        return [$priceMin, $priceMax];
    }

    /**
     * ポスター画像やジャケット画像からURLを抽出する
     *
     * @param array $productItem 製品アイテムデータ
     * @param string $imageKey 'posterimage' または 'jacketimage'
     * @return string|null 抽出されたURL
     */
    private function extractImageUrl(array $productItem, string $imageKey): ?string
    {
        if (isset($productItem[$imageKey]) && is_array($productItem[$imageKey]) && !empty($productItem[$imageKey][0])) {
            $firstImage = $productItem[$imageKey][0];
            return $firstImage['large'] ?? $firstImage['midium'] ?? $firstImage['small'] ?? null;
        }
        return null;
    }

    /**
     * サムネイル画像からURLを抽出する
     *
     * @param array $productItem 製品アイテムデータ
     * @return string|null 抽出されたURL
     */
    private function extractThumbnailUrl(array $productItem): ?string
    {
        if (isset($productItem['thumbnail']) && is_array($productItem['thumbnail']) && !empty($productItem['thumbnail'][0])) {
            $firstThumbnail = $productItem['thumbnail'][0];
            return $firstThumbnail['image'] ?? null;
        }
        return null;
    }

    /**
     * サンプル動画のURLとキャプチャURLを抽出する
     *
     * @param array $productItem 製品アイテムデータ
     * @return array{string|null, string|null} [movie_url, capture_url]
     */
    private function extractSampleMovieUrl(array $productItem): array
    {
        $sampleMovieUrl = null;
        $sampleMovieCapture = null;
        if (isset($productItem['samplemovie']) && is_array($productItem['samplemovie']) && !empty($productItem['samplemovie'][0]) && isset($productItem['samplemovie'][0]['midium'])) {
            $sampleMovieData = $productItem['samplemovie'][0]['midium'];
            $sampleMovieUrl = $sampleMovieData['movie'] ?? null;
            $sampleMovieCapture = $sampleMovieData['capture'] ?? null;
        }
        return [$sampleMovieUrl, $sampleMovieCapture];
    }
}