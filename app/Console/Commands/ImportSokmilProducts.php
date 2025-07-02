<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product; // Productモデルを使用
// use App\Models\RowApiData; // もしrow_api_dataテーブルを使うならこの行も追加

class ImportSokmilProducts extends Command
{
    protected $signature = 'import:sokmil-products';
    protected $description = 'Import products from the SOKMIL API.';

    public function handle()
    {
        $this->info('Starting SOKMIL product import...');

        // .envファイルからAPI情報を取得
        $baseApiUrl = env('SOKMIL_BASE_API_URL');
        $affiliateId = env('SOKMIL_AFFILIATE_ID');
        $apiKey = env('SOKMIL_API_KEY');

        if (!$baseApiUrl || !$affiliateId || !$apiKey) {
            $this->error('SOKMIL_BASE_API_URL, SOKMIL_AFFILIATE_ID, or SOKMIL_API_KEY is not set in .env file.');
            $this->error('Please check your .env file and ensure these variables are configured correctly.');
            return;
        }

        try {
            // APIリクエストを実行
            $response = Http::timeout(60)->get($baseApiUrl, [ // タイムアウトを60秒に設定（任意）
                'affiliate_id' => $affiliateId,
                'api_key' => $apiKey,
                'output' => 'json',
                // 必要であれば、ここにページングやカテゴリ指定などの追加パラメータを含めます
                // 例: 'per_page' => 100, // 1ページあたりの取得件数
                // 例: 'page' => 1,     // 取得するページ番号
            ]);

            if ($response->successful()) {
                $sokmilData = $response->json();

                // レスポンスのトップレベルが商品の配列なので、そのまま使用
                $productsData = $sokmilData; 

                if (is_array($productsData) && !empty($productsData)) {
                    $importedCount = 0;
                    foreach ($productsData as $productItem) {
                        // 商品IDの取得
                        $externalId = $productItem['id'] ?? null;

                        if (!$externalId) {
                            $this->warn('Skipping SOKMIL product with no external ID: ' . json_encode($productItem));
                            continue;
                        }

                        // 価格の取得: 複数の配信形式があるため、最も安い価格を取得するか、特定のタイプを選択するか
                        $price = null;
                        if (isset($productItem['prices']['deliveries']['delivery']) && is_array($productItem['prices']['deliveries']['delivery'])) {
                            // 例: 最も安い価格（数値）を取得するロジック
                            $minPrice = PHP_INT_MAX;
                            foreach ($productItem['prices']['deliveries']['delivery'] as $delivery) {
                                if (isset($delivery['price']) && is_numeric($delivery['price'])) {
                                    $minPrice = min($minPrice, (int)$delivery['price']);
                                }
                            }
                            if ($minPrice !== PHP_INT_MAX) {
                                $price = $minPrice;
                            }
                        } else {
                            // もし deliveries がなく、prices.price が "100~" のような形式ならそのまま文字列で保存
                            $price = $productItem['prices']['price'] ?? null;
                        }

                        // 商品説明として 'volume' を使用するか、別の情報を結合するか検討
                        $description = $productItem['volume'] ?? null; // 例: 再生時間
                        // もし詳細な説明が欲しければ、iteminfoから取得する
                        // $description .= (isset($productItem['iteminfo']['genre'][0]['name']) ? ' ジャンル: ' . $productItem['iteminfo']['genre'][0]['name'] : '');
                        // $description .= (isset($productItem['iteminfo']['actor'][0]['name']) ? ' 出演: ' . $productItem['iteminfo']['actor'][0]['name'] : '');


                        // Productモデルにデータを保存または更新
                        $product = Product::updateOrCreate(
                            ['external_id' => 'sokmil_' . $externalId], // SOKMIL由来のIDであることを明示
                            [
                                'name' => $productItem['title'] ?? 'No Name',
                                'description' => $description,
                                'price' => $price,
                                'image_url' => $productItem['imageURL']['large'] ?? null, // large画像を使用
                                'affiliate_url' => $productItem['affiliateURL'] ?? null, // アフィリエイトURLも保存
                                'source_asp' => 'SOKMIL', // どのASPからのデータか
                                'released_at' => isset($productItem['date']) ? \Carbon\Carbon::parse($productItem['date'])->toDateTimeString() : null, // リリース日
                                // ★必要に応じて、追加で保存したいカラムがあればここにマッピングを追加
                                // 例: 'maker_name' => $productItem['iteminfo']['maker'][0]['name'] ?? null,
                                // 例: 'volume_text' => $productItem['volume'] ?? null,
                            ]
                        );
                        $this->info("SOKMIL Product '{$product->name}' (External ID: {$externalId}) imported/updated.");
                        $importedCount++;
                    }
                    $this->info("SOKMIL product import completed successfully. Total {$importedCount} products processed.");
                } else {
                    $this->warn('SOKMIL API returned an empty or invalid array of products. Response: ' . $response->body());
                }
            } else {
                $this->error('Failed to fetch data from SOKMIL API. Status: ' . $response->status());
                $this->error('Response body: ' . $response->body());
                \Log::error('SOKMIL API Error', ['status' => $response->status(), 'response' => $response->body()]);
            }
        } catch (\Exception $e) {
            $this->error('An error occurred during SOKMIL API import: ' . $e->getMessage());
            \Log::error('SOKMIL API Import Exception', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }
}