<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * カテゴリ一覧を表示
     */
    public function index()
    {
        $categories = Category::all(); // 全てのカテゴリを取得
        return view('categories.index', compact('categories'));
    }

    /**
     * 特定のカテゴリに属する商品一覧を表示
     */
    public function showProducts(Category $category) // ルートモデルバインディングでCategoryモデルが自動的に取得されます
    {
        // Categoryモデルにproducts()リレーションが定義されていることを前提とします
        $products = $category->products()->paginate(10); // ページネーションを適用
        return view('categories.products', compact('category', 'products'));
    }
}