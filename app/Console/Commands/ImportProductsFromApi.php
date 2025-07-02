<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http; // ★この行を追加
use App\Models\Product; // ★この行を追加
// use App\Models\RowApiData; // ★もしrow_api_dataテーブルを使うならこの行も追加

class ImportProductsFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products-api'; // コマンド名を短くしました

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from an external API.'; // コマンドの説明を具体的にしました

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting product import from API...');

        // ここにAPIのエンドポイントURLを指定します
        // 例: 'https://api.example.com/products'
        $apiUrl = 'YOUR_API_ENDPOINT_URL'; // ★★★ ここを実際のAPIのURLに置き換えてください ★★★

        // APIキーなど認証が必要な場合は、.envファイルに設定し、ここで取得します
        // 例: $apiKey = env('EXTERNAL_API_KEY');
        // $response = Http::withHeaders(['X-API-Key' => $apiKey])->get($apiUrl);
        // または $response = Http::withToken($apiKey)->get($apiUrl);

        try {
            // LaravelのHTTPクライアントを使ってAPIにリクエストを送信
            $response = Http::get($apiUrl); // 認証が必要な場合は、上記例のように withHeaders や withToken を追加

            // レスポンスが成功したか確認
            if ($response->successful()) {
                $productsData = $response->json(); // JSONレスポンスをPHPの配列に変換

                // 取得したデータが配列であることを確認 (APIが単一のオブジェクトを返す場合は、このチェックとループを調整)
                if (is_array($productsData)) {
                    foreach ($productsData as $productItem) {
                        // ここでAPIからのデータをProductモデルにマッピングして保存します
                        // APIのレスポンス構造に合わせてキー名を調整してください
                        // 例: APIのIDが 'product_id' ではなく 'unique_id' などの場合、変更します
                        $externalId = $productItem['id'] ?? null; // API側での一意なID (通常は 'id' ですが、APIにより異なります)

                        if (!$externalId) {
                            $this->warn('Skipping product with no external ID (API item: ' . json_encode($productItem) . ')');
                            continue;
                        }

                        // external_id を使って既存の商品があるか確認し、あれば更新、なければ新規作成
                        // Product::updateOrCreate は、指定された属性（external_id）に一致するレコードがあれば更新し、なければ新規作成します。
                        $product = Product::updateOrCreate(
                            ['external_id' => $externalId], // 検索条件
                            [
                                'name' => $productItem['name'] ?? 'No Name', // APIのキー名を合わせる
                                'description' => $productItem['description'] ?? null,
                                'price' => $productItem['price'] ?? null,
                                'image_url' => $productItem['image_url'] ?? null,
                                // ★★★★ ここに、Productsテーブルの他のカラムとAPIのデータをマッピングする行を追加してください ★★★★
                                // 例: 'stock' => $productItem['quantity'] ?? 0,
                                // 例: 'category_name' => $productItem['category']['name'] ?? 'Default',
                            ]
                        );

                        // もしraw_api_dataテーブル（ER図にあった）を使う場合、ここに生のJSONデータを保存します
                        // これは、APIのレスポンスをそのまま保存しておきたい場合に便利です。
                        // その場合、RowApiDataモデルを作成し、マイグレーションで 'product_id' と 'raw_data' カラムを定義する必要があります。
                        // RowApiData::updateOrCreate(
                        //     ['product_id' => $product->id],
                        //     ['raw_data' => json_encode($productItem)] // 生のデータをJSON文字列として保存
                        // );

                        $this->info("Product '{$product->name}' (ID: {$product->id}) imported/updated.");
                    }
                    $this->info('Product import completed successfully.');
                } else {
                    $this->error('API response is not a valid array of products or is empty. Response: ' . $response->body());
                }
            } else {
                $this->error('Failed to fetch data from API. Status: ' . $response->status());
                $this->error('Response body: ' . $response->body());
            }
        } catch (\Exception $e) {
            $this->error('An error occurred during API import: ' . $e->getMessage());
            // エラーの詳細なトレースが必要な場合は、ログに出力
            // \Log::error('API Import Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}