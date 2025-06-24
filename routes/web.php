<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DugaController; // ★この行はそのまま

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ★★★ ここから移動/追加 ★★★
// Subdomain routing for duga.tipers.live を他のルートよりも一番上に配置
Route::domain('duga.tipers.live')->group(function () {
    Route::get('/', [DugaController::class, 'index']);
    // duga.tipers.live の他のルートもここに追加できます
});
// ★★★ ここまで移動/追加 ★★★

Route::get('/', function () {
    return view('main.index'); // ★ここが変更されました
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 既存の追加部分
    Route::get('/my-template', function () {
        return view('my-template-page');
    })->name('my-template');

    // 既存の追加部分
    Route::get('/my_combined_page', function () {
        return view('my_combined_page');
    })->name('my_combined_page');
});

require __DIR__.'/auth.php';