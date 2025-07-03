<?php

use App\Http\Controllers\ProfileController; // ★★★ この行は必要です！コメントアウトを解除または追加 ★★★
use Illuminate\Support\Facades\Route;

// あなたの自作のテンプレートを表示するルートを一番上に置く
// メインページ（ルート / ）は welcome_content.blade.php を表示する
Route::get('/', function () {
    return view('welcome_content');
});

// 通常のダッシュボードルート (Laravel Breezeのデフォルト)
// 認証済みかつメール認証済みのユーザーがアクセスできる
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ★★★ ここにプロフィール関連のルート定義を再度追加します (コメントアウトを解除) ★★★
// layouts/navi.blade.php から参照される profile.edit ルートなどを定義
// このセクションは、auth.php に頼らず確実にプロフィールルートを定義するために必要です。
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Laravel Breezeの認証関連ルートを読み込む
// これが login, register, logout など他の認証ルートを含みます。
// ★★★ この require 文は通常、ファイルの最後に配置されます ★★★
require __DIR__.'/auth.php';