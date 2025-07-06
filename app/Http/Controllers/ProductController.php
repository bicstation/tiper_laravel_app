<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('releasedate', 'desc')
                            ->paginate(15);
        return view('products.index', compact('products'));
    }

    public function show($productid)
    {
        $product = Product::where('productid', $productid)->firstOrFail();

        // --- 前の作品を取得（メーカー内での前後ナビゲーション） ---
        $previousProduct = Product::where('makerid', $product->makerid)
            ->where(function ($query) use ($product) {
                $query->where('releasedate', '<', $product->releasedate)
                      ->orWhere(function ($query) use ($product) {
                          $query->where('releasedate', $product->releasedate)
                                ->where('productid', '<', $product->productid);
                      });
            })
            ->orderBy('releasedate', 'desc')
            ->orderBy('productid', 'desc')
            ->first();

        // --- 次の作品を取得（メーカー内での前後ナビゲーション） ---
        $nextProduct = Product::where('makerid', $product->makerid)
            ->where(function ($query) use ($product) {
                $query->where('releasedate', '>', $product->releasedate)
                      ->orWhere(function ($query) use ($product) {
                          $query->where('releasedate', $product->releasedate)
                                ->where('productid', '>', $product->productid);
                      });
            })
            ->orderBy('releasedate', 'asc')
            ->orderBy('productid', 'asc')
            ->first();

        // --- 同じカテゴリの関連作品を取得 ---
        $relatedProductsByCategory = collect(); // 初期化
        if ($product->categories->isNotEmpty()) {
            $categoryIds = $product->categories->pluck('id')->toArray();
            $relatedProductsByCategory = Product::whereHas('categories', function ($query) use ($categoryIds) {
                                            $query->whereIn('categories.id', $categoryIds);
                                        })
                                        ->where('id', '!=', $product->id) // 現在の作品を除外
                                        ->inRandomOrder()
                                        ->limit(4)
                                        ->get();
        }

        // --- 同じシリーズの関連作品を取得 ---
        $relatedProductsBySeries = collect(); // 初期化
        // series_id が存在し、かつ NULL や空文字列ではない場合
        if (!empty($product->series_id)) {
            $relatedProductsBySeries = Product::where('series_id', $product->series_id)
                                          ->where('id', '!=', $product->id) // 現在の作品を除外
                                          ->inRandomOrder() // ランダムな順序で取得
                                          ->limit(4) // 4件に限定
                                          ->get();
        }


        // ビューにデータを渡す
        return view('products.show', compact('product', 'previousProduct', 'nextProduct', 'relatedProductsByCategory', 'relatedProductsBySeries'));
    }
}