{{-- resources/views/series/index.blade.php --}}
@extends('layouts.app') {{-- layouts/app.blade.php を継承 --}}

@section('content') {{-- app.blade.php の @yield('content') に挿入される --}}
    <div class="container mx-auto p-4"> {{-- app.blade.php がすでにコンテナを持っている場合は調整 --}}
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">
            <i class="fas fa-boxes mr-3"></i>シリーズ一覧
        </h1>

        @if($series->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">シリーズはまだ登録されていません。</p>
        @else
            <ul class="space-y-4">
                @foreach($series as $s) {{-- 変数名 $s は既存のコードに合わせています --}}
                    <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                        <a href="{{ route('series.products', $s->id) }}" {{-- ★ $s->id を使用 --}}
                           class="text-blue-600 dark:text-blue-400 hover:underline text-xl font-semibold flex items-center">
                            <i class="fas fa-box-open w-5 h-5 mr-3 text-blue-500 dark:text-blue-300"></i> {{-- シリーズアイコンを追加 --}}
                            {{ $s->name }}
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