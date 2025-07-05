{{-- resources/views/products/show.blade.php --}}

@extends('layouts.app') 

@push('styles')
    <style>
        /* このページ固有のCSSがあればここに記述できます */
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            {{-- 商品タイトル --}}
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">{{ $product->title }}</h1>

            <div class="flex flex-col md:flex-row gap-6 mb-6">
                {{-- 商品画像 --}}
                <div class="md:w-1/2 flex-shrink-0">
                    {{-- jacketimage_large があればそれを使用、なければ thumbnail_main、それもなければプレースホルダー --}}
                    @if ($product->jacketimage_large)
                        <img src="{{ $product->jacketimage_large }}" alt="{{ $product->title }}" class="w-full h-auto object-contain rounded-lg shadow-md">
                    @elseif ($product->thumbnail_main)
                        <img src="{{ $product->thumbnail_main }}" alt="{{ $product->title }}" class="w-full h-auto object-contain rounded-lg shadow-md">
                    @else
                        <img src="https://via.placeholder.com/400x300/cccccc/ffffff?text=No+Image" alt="No Image" class="w-full h-auto object-contain rounded-lg shadow-md">
                    @endif
                </div>
                
                {{-- 商品詳細情報 --}}
                <div class="md:w-1/2">
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>メーカー:</strong> {{ $product->makername ?? '不明' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>発売日:</strong> {{ $product->releasedate ? $product->releasedate->format('Y年m月d日') : '不明' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>公開日:</strong> {{ $product->opendate ? $product->opendate->format('Y年m月d日') : '不明' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4 text-2xl font-bold"><strong>価格:</strong> {{ $product->price_text ?? '不明' }}</p>
                    
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">作品概要</h2>
                    <p class="text-gray-800 dark:text-gray-200 leading-relaxed mb-6">{{ $product->caption ?? '作品概要は提供されていません。' }}</p>

                    {{-- 公式サイトへのリンクをアフィリエイトリンクにする --}}
                    {{-- ★★★ ここから変更 ★★★ --}}
                    <div class="flex flex-wrap gap-4 mb-8">
                        @if ($product->affiliateurl)
                            {{-- affiliateurl があればそれを使用 --}}
                            <a href="{{ $product->affiliateurl }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                公式サイトで詳細を見る <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        @elseif ($product->url)
                            {{-- affiliateurl がなく、通常のurlがあればそれを使用 --}}
                            <a href="{{ $product->url }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                公式サイトで詳細を見る <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        @endif
                        {{-- 「購入サイトへ移動」ボタンは削除しました --}}
                    </div>
                    {{-- ★★★ ここまで変更 ★★★ --}}

                    {{-- 商品一覧に戻るリンク --}}
                    <div class="mt-8 text-center">
                        <a href="{{ route('products.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-lg">
                            &larr; 商品一覧に戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- このページ固有のJavaScriptがあればここに記述できます --}}
@endpush