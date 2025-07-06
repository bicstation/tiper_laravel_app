{{-- resources/views/series/products.blade.php --}}
@extends('layouts.app') {{-- layouts/app.blade.php を継承 --}}

@section('content') {{-- app.blade.php の @yield('content') に挿入される --}}
    <div class="container mx-auto p-4"> {{-- app.blade.php がすでにコンテナを持っている場合は調整 --}}
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">
            <i class="fas fa-boxes mr-3"></i>{{ $series->name }} の商品一覧
        </h1>

        @if($products->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">このシリーズにはまだ商品が登録されていません。</p>
        @else
            <ul class="space-y-6"> {{-- 間隔を少し広げました --}}
                @foreach($products as $product)
                    <li class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700"> {{-- 各商品にカードスタイルを追加 --}}
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $product->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                            <i class="fas fa-barcode mr-2"></i>商品ID: {{ $product->productid }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            <i class="fas fa-industry mr-2"></i>メーカー: {{ $product->makername }}
                        </p>
                        
                        {{-- 商品詳細へのリンク (products.show ルートが定義されている場合) --}}
                        {{-- 以下のコメントを解除して使用する場合、ProductControllerにshowメソッドと対応するルート定義が必要です --}}
                        @if (Route::has('products.show'))
                            <div class="mt-3">
                                <a href="{{ route('products.show', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-info-circle mr-2"></i>詳細を見る
                                </a>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-8"> {{-- ページネーションリンクの間隔を調整 --}}
                {{ $products->links('vendor.pagination.tailwind') }} {{-- Tailwind CSS用のページネーションビューを指定 (AppServiceProviderで設定済みなら不要) --}}
            </div>
        @endif

        <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700"> {{-- 戻るリンクの上に罫線を追加 --}}
            <a href="{{ route('series.index') }}" class="text-blue-500 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-arrow-left w-4 h-4 mr-2"></i> シリーズ一覧へ戻る
            </a>
        </div>
    </div>
@endsection