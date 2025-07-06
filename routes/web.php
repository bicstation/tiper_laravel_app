<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Authファサードを使用
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\MakerController; // ★追加: MakerControllerを使用
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ProductFeedController;

// --- 公開ページのメインルート ---

// ルートディレクトリへのアクセスで商品一覧を表示
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// 個別商品詳細ページへのルート
// 例: /products/487 のようなURLでアクセスできるようになります
// {product} の部分を {product:productid} に変更して、LaravelがProductモデルをproductidカラムで検索するように指示します。
Route::get('/products/{product:productid}', [ProductController::class, 'show'])->name('products.show');

// ★★★ カテゴリ関連のルート ★★★
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}/products', [CategoryController::class, 'showProducts'])->name('categories.products');

// ★★★ シリーズ関連のルート ★★★
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{series}/products', [SeriesController::class, 'showProducts'])->name('series.products');

// --- メーカー関連のルート ★★★ここから追加★★★ ---
// 全メーカー一覧ページへのルート
Route::get('/makers', [MakerController::class, 'index'])->name('makers.index');
// 特定のメーカーの商品一覧ページへのルート
// 例: /makers/1/products (MakerのIDが1の場合)
// {maker} の部分を Maker モデルにバインドし、そのメーカーの商品を表示します。
Route::get('/makers/{maker}/products', [MakerController::class, 'productsByMaker'])->name('makers.products');
// --- メーカー関連のルート ★★★ここまで追加★★★ ---


// --- その他の公開ページ ---

// サイトマップのルート
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');

// ダッシュボードページ
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// その他の一般的なページ
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/help', function () {
    return view('help');
})->name('help');

// --- 認証関連のルート ---

// Laravel Breezeの認証ルートを読み込む場合
// require __DIR__.'/auth.php';

// 仮の認証ルート
Route::middleware('guest')->group(function () {
    Route::get('login', function () { return view('auth.login'); })->name('login');
    Route::get('register', function () { return view('auth.register'); })->name('register');
});
Route::post('logout', function () { Auth::logout(); return redirect('/'); })->name('logout');

// プロフィール関連のルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () { return view('profile.edit'); })->name('profile.edit');
});

// ★管理画面用のMakerリソースルートは、公開用ルートと重複を避けるため、
// 必要であれば以下のように調整して、より具体的なパスで定義することも検討してください。
// 例えば、`/admin/makers` のように。
// 今回の指示では公開ルートへの追加がメインなので、このファイルには含めません。
// もしMakerControllerに管理画面用のindex以外のメソッド（create, store, edit, update, destroy）がある場合は、
// 別途ルート定義が必要です。