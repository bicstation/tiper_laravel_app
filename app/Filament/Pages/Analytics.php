<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\AccessLog; // AccessLogモデルをuseする
use Illuminate\Support\Facades\DB; // DBファサードをuseする
use Carbon\Carbon; // 日付操作に便利なCarbonをuseする

class Analytics extends Page
{
    // このページのURLパスを定義 (例: /admin/analytics)
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar'; // ナビゲーションアイコン
    protected static ?string $navigationGroup = '管理'; // ナビゲーショングループ (任意)
    protected static ?string $navigationLabel = 'アクセス解析'; // ナビゲーションに表示されるラベル
    protected static ?string $title = 'アクセス解析レポート'; // ページのタイトル

    protected static string $view = 'filament.pages.analytics'; // Bladeビューファイルを指定

    // ビューに渡すデータをここで準備
    public array $pageData = [];

    public function mount(): void
    {
        // --- 全体サマリー ---
        $this->pageData['totalPageViews'] = AccessLog::count();
        $this->pageData['uniqueVisitors'] = AccessLog::distinct('ip_address')->count();

        // --- 直近24時間のデータ ---
        $past24Hours = Carbon::now()->subHours(24);
        $this->pageData['viewsLast24Hours'] = AccessLog::where('created_at', '>=', $past24Hours)->count();
        $this->pageData['uniqueVisitorsLast24Hours'] = AccessLog::where('created_at', '>=', $past24Hours)
                                                                 ->distinct('ip_address')
                                                                 ->count();

        // --- 直近30日間の日別PV推移 ---
        $this->pageData['dailyPageViews'] = AccessLog::select(
                                                DB::raw('DATE(created_at) as date'),
                                                DB::raw('COUNT(*) as views')
                                            )
                                            ->where('created_at', '>=', Carbon::now()->subDays(30))
                                            ->groupBy('date')
                                            ->orderBy('date', 'asc')
                                            ->get();

        // --- アクセスが多いページ (Top 10) ---
        $this->pageData['topPages'] = AccessLog::select('url', DB::raw('COUNT(*) as views'))
                                                ->groupBy('url')
                                                ->orderBy('views', 'desc')
                                                ->limit(10)
                                                ->get();

        // --- IPアドレス別のアクセス数 (Top 10) ---
        $this->pageData['topIps'] = AccessLog::select('ip_address', DB::raw('COUNT(*) as views'))
                                              ->groupBy('ip_address')
                                              ->orderBy('views', 'desc')
                                              ->limit(10)
                                              ->get();
    }
}