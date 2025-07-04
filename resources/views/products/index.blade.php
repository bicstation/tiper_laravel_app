{{-- resources/views/products/index.blade.php --}}

@extends('layouts.app') {{-- layouts/app.blade.php を継承 --}}

{{-- headセクションに追加するスタイルがあればここに記述。今回は直接HTMLにTailwindクラスを適用するため不要。
     もし特定のスタイルを追加したい場合は、@section('styles')を使用できますが、
     @push('styles') が layouts/app.blade.php にあるのでそちらを使います。 --}}
@push('styles')
    <style>
        /* ここにproducts/index.blade.php固有のCSSを記述します */
        /* Tailwind CSSを主に使用するため、カスタムCSSは最小限に */
        .product-item h3 {
            /* タイトルの高さを固定してレイアウト崩れを防ぐ */
            height: 3em; /* 例えば3行分の高さ */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* 2行まで表示 */
            -webkit-box-orient: vertical;
        }
    </style>
@endpush

@section('content') {{-- layouts/app.blade.php の @yield('content') にコンテンツを挿入 --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8"> {{-- Tailwindのコンテナとパディング --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6"> {{-- ダッシュボードのようなカードスタイル --}}
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">商品一覧</h1>

            {{-- 商品リストのコンテナ --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="bg-gray-100 dark:bg-gray-700 shadow-md rounded-lg p-4 flex flex-col items-center text-center">
                        {{-- 画像表示の優先順位: jacketimage_large > thumbnail_main > プレースホルダー --}}
                        @if ($product->jacketimage_large)
                            <img src="{{ $product->jacketimage_large }}" alt="{{ $product->title }}" class="w-full h-48 object-contain mb-4 rounded">
                        @elseif ($product->thumbnail_main)
                            <img src="{{ $product->thumbnail_main }}" alt="{{ $product->title }}" class="w-full h-48 object-contain mb-4 rounded">
                        @else
                            <img src="https://via.placeholder.com/200x200/cccccc/ffffff?text=No+Image" alt="No Image" class="w-full h-48 object-contain mb-4 rounded">
                        @endif
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 overflow-hidden overflow-ellipsis" style="-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical;">{{ $product->title }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">メーカー: {{ $product->makername ?? '不明' }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">発売日: {{ $product->releasedate ? $product->releasedate->format('Y/m/d') : '不明' }}</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200 mb-4">価格: {{ $product->price_text ?? '不明' }}</p>
                        
                        <div class="mt-auto flex flex-wrap justify-center gap-2"> {{-- ボタンを横並びにするためのコンテナ --}}
                            {{-- ★★★ この部分を変更しました ★★★ --}}
                            {{-- 「公式サイトを見る」ボタンをアフィリエイトリンクに。affiliateurlがなければurlをフォールバック。 --}}
                            @if ($product->affiliateurl)
                                <a href="{{ $product->affiliateurl }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 text-sm">
                                    公式サイトを見る
                                </a>
                            @elseif ($product->url) {{-- affiliateurlがない場合にurlを使用 --}}
                                <a href="{{ $product->url }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 text-sm">
                                    公式サイトを見る
                                </a>
                            @endif

                            {{-- 「個別ページ」ボタンは変更なし --}}
                            <a href="{{ route('products.show', ['productid' => $product->productid]) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 text-sm">
                                個別ページ
                            </a>
                        </div>
                        {{-- ★★★ 変更ここまで ★★★ --}}

                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-300 text-center col-span-full">商品が見つかりませんでした。</p>
                @endforelse
            </div>

            {{-- ページネーションリンク --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- もしproducts/index.blade.php固有のJavaScriptがあればここに記述します --}}
@endpush