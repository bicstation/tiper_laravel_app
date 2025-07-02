<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AccessLog; // AccessLogモデルをuseする

class LogPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // GETリクエストかつ、特定のファイルや解析ページ自体ではない場合のみログを記録
        if ($request->isMethod('GET') &&
            !$request->ajax() && // AJAXリクエストを除外
            !$request->is('analytics*') && // 解析ページ自体は除外 (無限ループ防止)
            !$request->is('test-sokmil-api') && // APIテストルートを除外 (必要であれば)
            !$request->is('*.css') && // CSSファイルを除外
            !$request->is('*.js') &&  // JSファイルを除外
            !$request->is('*.jpg') && // 画像ファイルを除外
            !$request->is('*.png') &&
            !$request->is('*.gif') &&
            !$request->is('*.ico') && // ファビコンなどのアイコンを除外
            !$request->is('*.svg'))   // SVGファイルを除外
        {
            // AccessLogモデルを使ってデータベースにレコードを作成
            AccessLog::create([
                'url' => $request->fullUrl(), // アクセスされた完全なURL
                'ip_address' => $request->ip(), // クライアントのIPアドレス
                'user_agent' => $request->header('User-Agent'), // ユーザーエージェント
                'referrer' => $request->header('Referer'), // 参照元URL (なければnull)
            ]);
        }

        // 次のミドルウェアまたはリクエストハンドラーに処理を渡す
        return $next($request);
    }
}