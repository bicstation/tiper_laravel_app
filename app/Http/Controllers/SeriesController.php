<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * シリーズ一覧を表示
     */
    public function index()
    {
        $series = Series::all(); // 全てのシリーズを取得
        return view('series.index', compact('series'));
    }

    /**
     * 特定のシリーズに属する商品一覧を表示
     */
    public function showProducts(Series $series) // ルートモデルバインディングでSeriesモデルが自動的に取得されます
    {
        // Seriesモデルにproducts()リレーションが定義されていることを前提とします
        $products = $series->products()->paginate(10); // ページネーションを適用
        return view('series.products', compact('series', 'products'));
    }
}