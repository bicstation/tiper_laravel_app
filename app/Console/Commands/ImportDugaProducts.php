<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
// use App\Models\RowApiData; // もしrow_api_dataテーブルを使うならこの行も追加

class ImportDugaProducts extends Command
{
    protected $signature = 'import:duga-products';
    protected $description = 'Import products from the DUGA API.';

    public function handle()
    {
        $this->info('Starting DUGA product import...');

        $apiUrl = env('DUGA_API_URL'); // .envファイルからURLを取得
        $apiKey = env('DUGA_API_KEY'); // .envファイルからAPIキーを取得 (もし必要なら)

        if (!$apiUrl) {
            $this->error('DUGA_API_URL is not set in .env file.');
            return;
        }

        try {
            $response = Http::withHeaders([
                // DUGAのAPIに合わせたヘッダーや認証情報を追加
                // 例: 'Authorization' => 'Bearer ' . $apiKey,
                // 例: 'X-DUGA-Key' => $apiKey,
            ])->get($apiUrl); // GETリクエスト

            if ($response->successful()) {
                $productsData = $response->json();

                if (is_array($productsData)) {
                    foreach ($productsData as $productItem) {
                        $externalId = $productItem['id'] ?? null; // DUGA APIのレスポンスに合わせてキー名を調整

                        if (!$externalId) {
                            $this->warn('Skipping DUGA product with no external ID: ' . json_encode($productItem));
                            continue;
                        }

                        Product::updateOrCreate(
                            ['external_id' => 'duga_' . $externalId], // 衝突を避けるためプレフィックスを付ける
                            [
                                'name' => $productItem['name'] ?? 'No Name',
                                'description' => $productItem['description'] ?? null,
                                'price' => $productItem['price'] ?? null,
                                'image_url' => $productItem['image_url'] ?? null,
                                // ★DUGAのAPIレスポンスに合わせて他のカラムをマッピング
                                // 例: 'source_asp' => 'DUGA',
                            ]
                        );
                        $this->info("DUGA Product '{$productItem['name']}' (External ID: {$externalId}) imported/updated.");
                    }
                    $this->info('DUGA product import completed successfully.');
                } else {
                    $this->error('DUGA API response is not a valid array of products. Response: ' . $response->body());
                }
            } else {
                $this->error('Failed to fetch data from DUGA API. Status: ' . $response->status());
                $this->error('Response body: ' . $response->body());
            }
        } catch (\Exception $e) {
            $this->error('An error occurred during DUGA API import: ' . $e->getMessage());
        }
    }
}