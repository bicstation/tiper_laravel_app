<?php

use Illuminate\Support\Facades\Route;

// ルートディレクトリへのアクセスでdashboardを表示
Route::get('/', function () {
    // ログイン状態に応じて表示を切り替える例
    if (Auth::check()) {
        return view('dashboard');
    }
    // 未ログインの場合はウェルカムページなど、任意のビューを表示
    // 今回はログインしていなくてもdashboardを表示する例にします
    return view('dashboard');
})->name('home');

// ダッシュボードページ
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// その他のページ（必要に応じて追加）
Route::get('/about', function () {
    return view('about'); // 仮のaboutページ
})->name('about');

Route::get('/contact', function () {
    return view('contact'); // 仮のcontactページ
})->name('contact');

Route::get('/terms', function () {
    return view('terms'); // 仮のtermsページ
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy'); // 仮のprivacyページ
})->name('privacy');

Route::get('/help', function () {
    return view('help'); // 仮のhelpページ
})->name('help');


// Laravel Breezeの認証ルートを読み込む場合 (もし認証機能も使うなら)
require __DIR__.'/auth.php';

// 仮の認証ルート (Breezeをインストールしない場合)
Route::middleware('guest')->group(function () {
    Route::get('login', function () { return view('auth.login'); })->name('login');
    Route::get('register', function () { return view('auth.register'); })->name('register');
});
Route::post('logout', function () { Auth::logout(); return redirect('/'); })->name('logout');


// プロフィール関連のルート (Breezeがない場合のダミー)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () { return view('profile.edit'); })->name('profile.edit');
});

// 各仮ページ用のBladeファイル (routes/web.phpで参照しているもの)
// resources/views/about.blade.php
// resources/views/contact.blade.php
// resources/views/terms.blade.php
// resources/views/privacy.blade.php
// resources/views/help.blade.php
// resources/views/auth/login.blade.php
// resources/views/auth/register.blade.php
// resources/views/profile/edit.blade.php
// これらは必要に応じて中身を作成してください。
// 例えば、resources/views/about.blade.php は以下のようにします。
// @extends('layouts.app')
// @section('content')
// <div class="container mx-auto px-4 py-8">
//     <div class="bg-white shadow-xl rounded-lg p-6 lg:p-8">
//         <h1 class="text-3xl font-bold mb-4">会社概要</h1>
//         <p>このページは会社概要です。</p>
//     </div>
// </div>
// @endsection