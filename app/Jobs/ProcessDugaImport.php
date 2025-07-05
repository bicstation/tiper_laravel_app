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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception; // Exceptionクラスのuseを追加

class ProcessDugaImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $limit;
    protected int $batchSize;
    protected ?int $maxItems;

    const DUGA_API_VERSION = '1.2';
    const DUGA_AGENT_ID = '48043';
    const DUGA_BANNER_ID = '01';
    const DUGA_FORMAT = 'json';
    const DUGA_ADULT = 1;
    const DUGA_SORT = 'favorite';

    public function __construct(int $limit = 100, int $batchSize = 500, ?int $maxItems = null)
    {
        $this->limit = min($limit, 100); 
        $this->batchSize = $batchSize;
        $this->maxItems = $maxItems;
    }

    public function handle(): void
    {
        Log::info('Starting DUGA product import job...');

        $baseUrl = env('DUGA_API_URL');
        $apiKey = env('DUGA_API_KEY');

        if (!$baseUrl || !$apiKey) {
            Log::error('DUGA_API_URL or DUGA_API_KEY is not set in .env file. Job aborted.');
            return;
        }

        $limit = $this->limit;
        $batchSize = $this->batchSize;
        $maxItems = $this->maxItems;

        $offset = 1;
        $totalProductsFetched = 0;
        $totalProductsSaved = 0;
        $totalApiRequests = 0;

        $rawProductsBuffer = [];
        $processedProductsBuffer = [];
        $categoriesToProcess = [];
        $productCategoriesToProcess = [];

        do {
            if ($maxItems !== null && $totalProductsFetched >= $maxItems) {
                Log::info("Max items limit ({$maxItems}) reached. Finishing current batch and stopping.");
                break;
            }

            try {
                $totalApiRequests++;
                
                $remainingItems = ($maxItems !== null) ? ($maxItems - $totalProductsFetched) : PHP_INT_MAX;
                $currentRequestLimit = min($limit, $remainingItems);

                if ($currentRequestLimit <= 0) {
                    Log::info("No more items to fetch based on --max-items limit. Breaking loop.");
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

                Log::info("Fetching from DUGA API (Offset: {$offset}, Hits: {$currentRequestLimit}). Request #{$totalApiRequests}");
                
                $response = Http::timeout(60)->get($baseUrl, $params);
                
                Log::debug('DUGA API Full Request URL: ' . $response->effectiveUri());
                Log::debug('DUGA API Request Parameters sent: ' . json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                Log::debug('DUGA API Response Status: ' . $response->status()); 
                
                // ★追加: レスポンスの生の内容をログに出力★
                Log::debug('DUGA API Raw Response Body: ' . $response->body());

                if ($response->successful()) {
                    $responseData = $response->json();
                    
                    // ★追加: JSONデコードのエラーを確認する★
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $errorMsg = json_last_error_msg();
                        Log::error("JSON Decode Error: {$errorMsg}. Raw Response: " . $response->body());
                        // エラーが発生した場合は、このバッチの処理をスキップし、ループを抜ける
                        break; 
                    }

                    Log::debug('DUGA API Response Decoded (json_encode): ' . json_encode($responseData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                    // var_exportも追加。より詳細な構造をログ出力したい場合
                    // Log::debug('DUGA API Response Decoded (var_export): ' . var_export($responseData, true));

                    $rawItems = $responseData['items'] ?? [];
                    $items = [];
                    if (is_array($rawItems)) {
                        foreach ($rawItems as $rawItem) {
                            if (isset($rawItem['item'])) {
                                $items[] = $rawItem['item'];
                            }
                        }
                    }

                    $currentBatchCount = count($items);
                    if ($currentBatchCount === 0) {
                        Log::info('No more products found from API or "items" array is empty. Finishing import.');
                        break;
                    }

                    foreach ($items as $productItem) {
                        if ($maxItems !== null && $totalProductsFetched >= $maxItems) {
                            Log::info("Max items limit ({$maxItems}) reached within current batch. Processing current batch and stopping.");
                            break 2;
                        }

                        $productId = $productItem['productid'] ?? null;

                        if (!$productId) {
                            Log::warning('Skipping DUGA product with no productid: ' . json_encode($productItem, JSON_UNESCAPED_UNICODE));
                            continue;
                        }

                        $rawProductsBuffer[] = [
                            'api_source' => 'DUGA',
                            'external_id' => (string)$productId,
                            'raw_json_data' => json_encode($productItem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                            'fetched_at' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];

                        $priceText = $productItem['price'] ?? null;
                        $priceMin = null;
                        $priceMax = null;
                        if ($priceText) {
                            if (preg_match('/^(\d+)\s*円(?:～(\d+)\s*円)?$/u', $priceText, $matches)) {
                                $priceMin = (int)$matches[1];
                                $priceMax = isset($matches[2]) ? (int)$matches[2] : $priceMin;
                            } else {
                                $numericPrice = (int)preg_replace('/[^0-9]/', '', $priceText);
                                $priceMin = $numericPrice;
                                $priceMax = $numericPrice;
                            }
                        }

                        // --- 画像URLの抽出ロジックの修正ここから ---
                        $posterImageUrl = null;
                        if (isset($productItem['posterimage']) && is_array($productItem['posterimage']) && !empty($productItem['posterimage'][0])) {
                            $firstPoster = $productItem['posterimage'][0];
                            $posterImageUrl = $firstPoster['large'] ?? $firstPoster['midium'] ?? $firstPoster['small'] ?? null;
                        }

                        $jacketImageUrl = null;
                        if (isset($productItem['jacketimage']) && is_array($productItem['jacketimage']) && !empty($productItem['jacketimage'][0])) {
                            $firstJacket = $productItem['jacketimage'][0];
                            $jacketImageUrl = $firstJacket['large'] ?? $firstJacket['midium'] ?? $firstJacket['small'] ?? null;
                        }

                        $thumbnailMainUrl = null;
                        if (isset($productItem['thumbnail']) && is_array($productItem['thumbnail']) && !empty($productItem['thumbnail'][0])) {
                            $firstThumbnail = $productItem['thumbnail'][0];
                            $thumbnailMainUrl = $firstThumbnail['image'] ?? null; // thumbnailは'image'キー
                        }

                        // samplemovie の抽出も修正
                        $sampleMovieUrl = null;
                        $sampleMovieCapture = null;
                        if (isset($productItem['samplemovie']) && is_array($productItem['samplemovie']) && !empty($productItem['samplemovie'][0]) && isset($productItem['samplemovie'][0]['midium'])) {
                            $sampleMovieData = $productItem['samplemovie'][0]['midium'];
                            $sampleMovieUrl = $sampleMovieData['movie'] ?? null;
                            $sampleMovieCapture = $sampleMovieData['capture'] ?? null;
                        }
                        // --- 画像URLの抽出ロジックの修正ここまで ---
                        
                        $labelId = $productItem['label'][0]['id'] ?? null; // labelも配列になっている可能性を考慮
                        $labelName = $productItem['label'][0]['name'] ?? null; // labelも配列になっている可能性を考慮

                        $seriesId = $productItem['series'][0]['id'] ?? null; // seriesも配列になっている可能性を考慮
                        $seriesName = $productItem['series'][0]['name'] ?? null; // seriesも配列になっている可能性を考慮

                        $rankingTotal = $productItem['ranking'][0]['total'] ?? null; // rankingも配列になっている可能性を考慮

                        // reviewはJSON例にないので、そのままにしておきますが、もしreviewも配列だったら同様の修正が必要
                        $reviewRating = $productItem['review']['average'] ?? null;
                        $reviewCount = $productItem['review']['count'] ?? null;

                        $mylistTotal = $productItem['mylist'][0]['total'] ?? null; // mylistも配列になっている可能性を考慮

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
                            'price_text' => $priceText,
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
                            'series_id' => $seriesId,
                            'series_name' => $seriesName,
                            'ranking_total' => $rankingTotal,
                            'review_rating' => $reviewRating,
                            'review_count' => $reviewCount,
                            'mylist_total' => $mylistTotal,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];

                        if (isset($productItem['category']['data'])) {
                            $categoriesData = $productItem['category']['data'];
                            // category.data が単一オブジェクトの場合も配列として扱えるようにする
                            if (!isset($categoriesData[0]) && is_array($categoriesData)) {
                                $categoriesData = [$categoriesData];
                            }
                            
                            foreach ($categoriesData as $categoryData) {
                                if (isset($categoryData['id']) && isset($categoryData['name'])) {
                                    $categoryId = (string)$categoryData['id'];
                                    $categoriesToProcess[$categoryId] = [
                                        'id' => $categoryId,
                                        'name' => $categoryData['name'],
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
                                } else {
                                    Log::warning('Skipping category with missing id or name: ' . json_encode($categoryData, JSON_UNESCAPED_UNICODE));
                                }
                            }
                        }

                        $totalProductsFetched++;

                        if (count($processedProductsBuffer) >= $batchSize) {
                            $categoriesToSave = array_values($categoriesToProcess);
                            $this->saveBuffers($rawProductsBuffer, $processedProductsBuffer, $categoriesToSave, $productCategoriesToProcess, $batchSize);
                            $totalProductsSaved += count($rawProductsBuffer);
                            $rawProductsBuffer = [];
                            $processedProductsBuffer = [];
                            $categoriesToProcess = [];
                            $productCategoriesToProcess = [];
                        }
                    }

                    $offset += $currentBatchCount;
                    Log::info("Fetched {$currentBatchCount} items. Total fetched so far: {$totalProductsFetched}.");

                } else {
                    Log::error('Failed to fetch data from DUGA API. Status code was not successful.', [
                        'status' => $response->status(), 
                        'body' => $response->body(), 
                        'offset' => $offset, 
                        'limit' => $currentRequestLimit, 
                        'params' => $params
                    ]);
                    break;
                }
            } catch (\Illuminate\Http\Client\RequestException $e) {
                Log::error('HTTP Request error during DUGA API import: ' . $e->getMessage(), [
                    'offset' => $offset, 
                    'limit' => $limit, 
                    'api_url' => $baseUrl, 
                    'params' => $params, 
                    'response_body' => $e->response ? $e->response->body() : 'N/A',
                    'trace' => $e->getTraceAsString()
                ]);
                break;
            } catch (Exception $e) {
                Log::error('An unexpected error occurred during DUGA API import job: ' . $e->getMessage(), [
                    'offset' => $offset, 
                    'limit' => $limit, 
                    'api_url' => $baseUrl, 
                    'params' => $params, 
                    'trace' => $e->getTraceAsString()
                ]);
                break;
            }
        } while ($currentBatchCount > 0);

        if (!empty($rawProductsBuffer)) {
            Log::info("Saving remaining buffer items (count: " . count($rawProductsBuffer) . ") to MySQL.");
            $categoriesToSave = array_values($categoriesToProcess);
            $this->saveBuffers($rawProductsBuffer, $processedProductsBuffer, $categoriesToSave, $productCategoriesToProcess, count($rawProductsBuffer));
            $totalProductsSaved += count($rawProductsBuffer);
        }

        Log::info("DUGA product import job completed. Total API requests: {$totalApiRequests}. Total products fetched: {$totalProductsFetched}. Total products saved/updated: {$totalProductsSaved}.");
    }

    private function saveBuffers(
        array &$rawBuffer, 
        array &$processedBuffer, 
        array &$categoriesBuffer,
        array &$productCategoriesBuffer, 
        int $count
    ): void {
        if (empty($rawBuffer) && empty($processedBuffer) && empty($categoriesBuffer) && empty($productCategoriesBuffer)) {
            Log::warning("Attempted to save empty buffers. Skipping batch save.");
            return;
        }

        DB::transaction(function () use (&$rawBuffer, &$processedBuffer, &$categoriesBuffer, &$productCategoriesBuffer, $count) {
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
                            'label_id', 'label_name', 'series_id', 'series_name',
                            'ranking_total', 'review_rating', 'review_count', 'mylist_total',
                            'updated_at'
                        ]
                    );
                }

                if (!empty($categoriesBuffer)) {
                    Category::upsert(
                        $categoriesBuffer,
                        ['id'],
                        ['name', 'updated_at']
                    );
                }

                if (!empty($productCategoriesBuffer)) {
                    ProductCategory::upsert(
                        $productCategoriesBuffer,
                        ['product_external_id', 'category_external_id'],
                        ['source_asp', 'updated_at']
                    );
                }
                Log::info("Saved {$count} items and related data to MySQL in a batch successfully.");
            } catch (Exception $e) {
                Log::error("Batch save to MySQL failed: " . $e->getMessage(), [
                    'raw_buffer_count' => count($rawBuffer),
                    'processed_buffer_count' => count($processedBuffer),
                    'categories_buffer_count' => count($categoriesBuffer),
                    'product_categories_buffer_count' => count($productCategoriesBuffer),
                    'exception_trace' => $e->getTraceAsString()
                ]);
                throw new \RuntimeException("Failed to save batch to MySQL within transaction: " . $e->getMessage(), 0, $e);
            }
        });
    }
}