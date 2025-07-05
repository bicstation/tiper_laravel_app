<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Feed\FeedItem;
use App\Models\Product; // Productモデルをインポート

class ProductFeedController extends Controller
{
    public function getFeedItems()
    {
        // 最新のN件の商品を取得します
        // ここでは例として最新20件を取得しています。必要に応じて調整してください。
        return Product::latest('opendate') // 'opendate'でソート (公開日)
                        ->whereNotNull('opendate') // opendateがnullでないものに限定
                        ->limit(20) // 最大20件
                        ->get()
                        ->map(function (Product $product) {
                            // 各商品をFeedItemオブジェクトに変換します
                            // ここでRSSフィードの各要素に対応するデータを指定します
                            return FeedItem::create()
                                ->id($product->productid) // ユニークなID
                                ->title($product->title) // タイトル
                                ->summary($product->caption ?? '作品概要は提供されていません。') // 概要 (captionがない場合を考慮)
                                ->updated($product->opendate) // 更新日 (公開日を使用)
                                ->link(route('products.show', ['productid' => $product->productid])) // 個別ページへのリンク
                                ->authorName($product->makername ?? '不明') // 著者名 (メーカー名を使用)
                                ->category($product->category_name ?? '未分類'); // カテゴリ (もしあれば)
                        });
    }
}