<?php

namespace App\Http\Controllers;

use App\Models\Product; // Product モデルを使用することを宣言
use Illuminate\Http\Request; // Request クラスを使用する場合に必要ですが、今回は必須ではありません

class ProductController extends Controller
{
    /**
     * トップページに商品一覧を表示する
     */
    public function index()
    {
        // 商品データをデータベースから取得
        // 例: ページネーションを使って1ページあたり15件表示し、リリース日で新しい順にソート
        $products = Product::orderBy('releasedate', 'desc')
                           ->paginate(15);

        // 取得した商品をビューに渡して表示
        return view('products.index', compact('products'));
    }

    // ★★★ ここから追加します ★★★
    /**
     * 個別商品詳細ページを表示する
     *
     * @param string $productid DUGAのproductid (URLから渡されるID)
     * @return \Illuminate\View\View
     */
    public function show($productid)
    {
        // データベースから指定されたproductidの商品を取得します。
        // firstOrFail() は、商品が見つからなかった場合に自動的に404エラーページを表示します。
        $product = Product::where('productid', $productid)->firstOrFail();

        // 取得した商品データを 'products.show' ビューに渡して表示します。
        // 'products.show' は resources/views/products/show.blade.php を指します。
        return view('products.show', compact('product'));
    }
    // ★★★ ここまで追加 ★★★
}