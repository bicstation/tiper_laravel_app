<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product; // Productモデルをインポート

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create(config('app.url'));

        // トップページを追加
        $sitemap->add(Url::create('/'));

        // 各商品ページをサイトマップに追加
        Product::all()->each(function (Product $product) use ($sitemap) {
            // productid が設定されているか確認
            if ($product->productid) {
                $sitemap->add(Url::create(route('products.show', ['productid' => $product->productid])));
            }
        });

        // サイトマップをXML形式でレスポンスとして返す
        // ★★★ この部分を修正します：toXml() を render() に変更 ★★★
        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml; charset=utf-8' // 文字コードも明示するとより良い
        ]);
    }
}