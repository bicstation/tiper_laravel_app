<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessLog; // AccessLogモデルをuseする
use Illuminate\Support\Facades\DB; // DBファサードをuseする
use Carbon\Carbon; // 日付操作に便利なCarbonをuseする

class AnalyticsController extends Controller
{
    public function index()
    {
        // --- 全体サマリー ---
        // 全ページビュー数
        $totalPageViews = AccessLog::count();
        // 全ユニーク訪問者数 (IPアドレスで識別)
        $uniqueVisitors = AccessLog::distinct('ip_address')->count();

        // --- 直近24時間のデータ ---
        $past24Hours = Carbon::now()->subHours(24);
        // 直近24時間のページビュー数
        $viewsLast24Hours = AccessLog::where('created_at', '>=', $past24Hours)->count();
        // 直近24時間のユニーク訪問者数
        $uniqueVisitorsLast24Hours = AccessLog::where('created_at', '>=', $past24Hours)
                                                ->distinct('ip_address')
                                                ->count();

        // --- 直近30日間の日別PV推移 ---
        $dailyPageViews = AccessLog::select(
                                DB::raw('DATE(created_at) as date'), // created_atから日付のみ取得
                                DB::raw('COUNT(*) as views') // 日付ごとのPV数をカウント
                            )
                            ->where('created_at', '>=', Carbon::now()->subDays(30)) // 直近30日間に限定
                            ->groupBy('date') // 日付でグループ化
                            ->orderBy('date', 'asc') // 日付昇順で並べ替え
                            ->get();

        // --- アクセスが多いページ (Top 10) ---
        $topPages = AccessLog::select('url', DB::raw('COUNT(*) as views'))
                            ->groupBy('url') // URLでグループ化
                            ->orderBy('views', 'desc') // PV数が多い順
                            ->limit(10) // 上位10件
                            ->get();

        // --- IPアドレス別のアクセス数 (Top 10) ---
        $topIps = AccessLog::select('ip_address', DB::raw('COUNT(*) as views'))
                            ->groupBy('ip_address') // IPアドレスでグループ化
                            ->orderBy('views', 'desc') // アクセス数が多い順
                            ->limit(10) // 上位10件
                            ->get();


        // ビューにデータを渡す
        return view('analytics.index', compact(
            'totalPageViews',
            'uniqueVisitors',
            'viewsLast24Hours',
            'uniqueVisitorsLast24Hours',
            'dailyPageViews',
            'topPages',
            'topIps'
        ));
    }
}