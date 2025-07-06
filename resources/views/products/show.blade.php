{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')
@php
    use Illuminate\Support\Str;
@endphp

@section('title', $product->title . ' | Tiper.Live')
@section('description', Str::limit($product->caption ?? '作品概要は提供されていません。', 160))
@section('canonical', url('/products/' . $product->productid))
@section('og:title', $product->title)
@section('og:image', $product->jacketimage_large ?? $product->thumbnail_main ?? asset('img/default_og_image.jpg'))
@section('og:type', 'article')
@section('og:url', url('/products/' . $product->productid))
@section('og:image:alt', $product->title)
@section('twitter:title', $product->title)
@section('twitter:description', Str::limit($product->caption ?? '作品概要は提供されていません。', 160))
@section('twitter:image:alt', $product->title)

@push('styles')
    <style>
        /* このページ固有のCSSがあればここに記述できます */
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">{{ $product->title }}</h1>

            <div class="flex flex-col md:flex-row gap-6 mb-6">
                <div class="md:w-1/2 flex-shrink-0">
                    @if ($product->jacketimage_large)
                        <img src="{{ $product->jacketimage_large }}" alt="{{ $product->title }}" class="w-full h-auto object-contain rounded-lg shadow-md">
                    @elseif ($product->thumbnail_main)
                        <img src="{{ $product->thumbnail_main }}" alt="{{ $product->title }}" class="w-full h-auto object-contain rounded-lg shadow-md">
                    @else
                        <img src="https://via.placeholder.com/400x300/cccccc/ffffff?text=No+Image" alt="No Image" class="w-full h-auto object-contain rounded-lg shadow-md">
                    @endif
                </div>
                
                <div class="md:w-1/2">
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>メーカー:</strong> {{ $product->makername ?? '不明' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>発売日:</strong> {{ $product->releasedate ? $product->releasedate->format('Y年m月d日') : '不明' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>公開日:</strong> {{ $product->opendate ? $product->opendate->format('Y年m月d日') : '不明' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4 text-2xl font-bold"><strong>価格:</strong> {{ $product->price_text ?? '不明' }}</p>
                    
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">作品概要</h2>
                    <p class="text-gray-800 dark:text-gray-200 leading-relaxed mb-6">{{ $product->caption ?? '作品概要は提供されていません。' }}</p>

                    <div class="flex flex-wrap gap-4 mb-8">
                        @if ($product->affiliateurl)
                            <a href="{{ $product->affiliateurl }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                公式サイトで詳細を見る <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        @elseif ($product->url)
                            <a href="{{ $product->url }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                公式サイトで詳細を見る <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                @if ($previousProduct)
                    <a href="{{ route('products.show', $previousProduct->productid) }}" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center group">
                        <i class="fas fa-chevron-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i>
                        <span>前の作品: {{ Str::limit($previousProduct->title, 30) }}</span>
                    </a>
                @else
                    <div></div>
                @endif

                @if ($nextProduct)
                    <a href="{{ route('products.show', $nextProduct->productid) }}" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center group">
                        <span>次の作品: {{ Str::limit($nextProduct->title, 30) }}</span>
                        <i class="fas fa-chevron-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                @else
                    <div></div>
                @endif
            </div>

            @if ($relatedProductsByCategory->isNotEmpty())
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">このカテゴリの関連作品</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProductsByCategory as $relatedProduct)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300">
                                <a href="{{ route('products.show', $relatedProduct->productid) }}">
                                    @if ($relatedProduct->jacketimage_large)
                                        <img src="{{ $relatedProduct->jacketimage_large }}" alt="{{ $relatedProduct->title }}" class="w-full h-48 object-cover">
                                    @elseif ($relatedProduct->thumbnail_main)
                                        <img src="{{ $relatedProduct->thumbnail_main }}" alt="{{ $relatedProduct->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <img src="https://via.placeholder.com/200x150/cccccc/ffffff?text=No+Image" alt="No Image" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 truncate">{{ $relatedProduct->title }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $relatedProduct->makername ?? '不明' }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $relatedProduct->releasedate ? $relatedProduct->releasedate->format('Y/m/d') : '不明' }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($relatedProductsBySeries->isNotEmpty())
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">このシリーズの関連作品</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProductsBySeries as $relatedProduct)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300">
                                <a href="{{ route('products.show', $relatedProduct->productid) }}">
                                    @if ($relatedProduct->jacketimage_large)
                                        <img src="{{ $relatedProduct->jacketimage_large }}" alt="{{ $relatedProduct->title }}" class="w-full h-48 object-cover">
                                    @elseif ($relatedProduct->thumbnail_main)
                                        <img src="{{ $relatedProduct->thumbnail_main }}" alt="{{ $relatedProduct->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <img src="https://via.placeholder.com/200x150/cccccc/ffffff?text=No+Image" alt="No Image" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 truncate">{{ $relatedProduct->title }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $relatedProduct->makername ?? '不明' }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $relatedProduct->releasedate ? $relatedProduct->releasedate->format('Y/m/d') : '不明' }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('products.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-lg">
                    &larr; 商品一覧に戻る
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- このページ固有のJavaScriptがあればここに記述できます --}}
@endpush