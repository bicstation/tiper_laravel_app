<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // ★追加: Authファサードをインポート
use Filament\Models\Contracts\FilamentUser; // ★追加: FilamentUserインターフェースをインポート

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    // public const HOME = '/dashboard'; // ★この行をコメントアウトまたは削除します。
                                     //   代わりにredirectTo()クロージャで動的に決定します。

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // ★追加: 認証後のリダイレクト先を動的に決定するロジック
        $this->redirectTo(function () {
            $user = Auth::user();

            // ユーザーが FilamentUser インターフェースを実装しており、
            // かつ canAccessFilament() が true を返す場合、/admin にリダイレクト
            if ($user instanceof FilamentUser && $user->canAccessFilament()) {
                return '/admin'; // Filamentユーザーは /admin へ
            }

            return '/dashboard'; // それ以外のユーザーは /dashboard へ
        });


        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // ★この行はLaravel Breezeの認証ルートを読み込むもので、Filamentのリダイレクトには直接関係ありませんが、
            //   認証機能に必要なのでこのままで問題ありません。
            //   もしroutes/auth.phpが存在しないプロジェクトなら不要ですが、Breezeなら通常存在します。
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));
        });
    }
}