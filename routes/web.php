<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DugaController; // ★この行を追加★

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ★★★ ここから追加 ★★★
    Route::get('/my-template', function () {
        return view('my-template-page'); // 'my-template-page' は表示したいBladeファイル名
    })->name('my-template');
    // ★★★ ここまで追加 ★★★
    // ★★★ ここから追加 ★★★
    Route::get('/my_combined_page', function () {
        return view('my_combined_page'); // 'my_combined_page' は表示したいBladeファイル名
    })->name('my_combined_page');
    // ★★★ ここまで追加 ★★★   
});

// Subdomain routing for duga.tiper.live
// ★このブロックを既存のルートの下、require __DIR__.'/auth.php'; の上に追加★
Route::domain('duga.tiper.live')->group(function () {
    Route::get('/', [DugaController::class, 'index']);
    // duga.tiper.live の他のルートもここに追加
    // 例: Route::get('/products', [DugaController::class, 'products']);
});

require __DIR__.'/auth.php';