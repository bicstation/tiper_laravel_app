<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Filament\Models\Contracts\FilamentUser; // ★変更なし
// use App\Providers\RouteServiceProvider; // ★この行は不要になったので削除またはコメントアウトします

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // ユーザーが FilamentUser インターフェースを実装しており、
        // かつ canAccessFilament() が true を返す場合、/admin にリダイレクト
        if ($user instanceof FilamentUser && $user->canAccessFilament()) {
            return redirect()->intended('/admin'); // Filamentの管理パネルへ
        }

        // それ以外のユーザーは、直接 '/dashboard' にリダイレクト
        // RouteServiceProvider::HOME 定数が存在しないため、直接パスを指定します。
        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}