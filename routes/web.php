<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AnalyticsController; // ★★★ これを追加 ★★★

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

// routes/web.php のどこか、他のルート定義の下あたりに追加
Route::get('/test-accordion', function () {
    return view('test_accordion');
});

Route::get('/', function () {
    return view('main.index');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-template', function () {
        return view('my-template-page');
    })->name('my-template');

    Route::get('/my_combined_page', function () {
        return view('my_combined_page');
    })->name('my_combined_page');
});

// --- Sokmil API テスト用のルートをここに追加します ---
Route::get('/test-sokmil-api', function () {
    $apiUrl = env('SOKMIL_BASE_API_URL');
    $apiKey = env('SOKMIL_API_KEY');
    $affiliateId = env('SOKMIL_AFFILIATE_ID');

    if (empty($apiUrl)) {
        return 'Error: SOKMIL_BASE_API_URL is not set in your .env file.';
    }
    if (empty($apiKey)) {
        return 'Error: SOKMIL_API_KEY is not set in your .env file.';
    }

    try {
        $response = Http::get($apiUrl, [
            // ★★★ ここを修正しました！ ★★★
            'api_key'      => $apiKey,      // APIキーのパラメータ名を 'api_key' に修正
            'affiliate_id' => $affiliateId, // アフィリエイトIDのパラメータ名を 'affiliate_id' に修正
            'output'       => 'json',       // output=json を追加
            // 他に必要なパラメータがあればここに追加
            // 例: 'q' => 'テスト商品', // 検索キーワードなど
        ]);

        if ($response->successful()) {
            return response()->json($response->json(), 200, [], JSON_PRETTY_PRINT);
        } else {
            return 'API Request Failed: Status ' . $response->status() . ' - Body: ' . $response->body();
        }
    } catch (\Exception $e) {
        return 'An error occurred: ' . $e->getMessage();
    }
});
// --- Sokmil API テスト用のルートここまで ---

// ★★★ ここに簡易アクセス解析のレポートを表示するルートを追加 ★★★
Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');


require __DIR__.'/auth.php';