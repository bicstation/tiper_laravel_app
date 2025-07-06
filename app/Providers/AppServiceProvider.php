<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View; // Viewファサードを使用
use App\Models\Category; // Categoryモデルを使用
use App\Models\Series;// Seriesモデルを使用
use App\Models\Maker;// ★追加: Makerモデルを使用

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind(); // Tailwind CSSベースのページネーションスタイルを使用

        // layouts.sidebarビューがレンダリングされる際に、カテゴリ、シリーズ、メーカーのデータを共有する
        View::composer('layouts.sidebar', function ($view) {
            // カテゴリとシリーズを名前でソートして取得
            $categories = Category::orderBy('name')->get();
            $series = Series::orderBy('name')->get();
            // ★追加: メーカーを名前でソートして取得 (例として10件に制限)
            $makers = Maker::orderBy('name')->limit(10)->get(); // サイドバーの表示を考慮し、件数を制限するのが一般的です

            // 取得したデータをビューに渡す
            $view->with(compact('categories', 'series', 'makers')); // ★'makers'を追加
        });
    }
}