{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app') {{-- layouts/app.blade.php を継承 --}}

@section('content') {{-- app.blade.php の @yield('content') に挿入される --}}
    <div class="container mx-auto p-4"> {{-- app.blade.php がすでにコンテナを持っている場合は調整 --}}
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">カテゴリ一覧</h1>

        @if($categories->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">カテゴリはまだ登録されていません。</p>
        @else
            <ul class="space-y-4">
                @foreach($categories as $category)
                    <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                        <a href="{{ route('categories.products', $category) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-xl font-semibold flex items-center">
                            <i class="fas fa-folder w-5 h-5 mr-3 text-blue-500"></i> {{-- カテゴリアイコンを追加 --}}
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-8">
            <a href="{{ route('products.index') }}" class="text-blue-500 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-arrow-left w-4 h-4 mr-2"></i> {{-- 戻るアイコンを追加 --}}
                全商品一覧へ
            </a>
        </div>
    </div>
@endsection