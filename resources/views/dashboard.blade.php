{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 lg:p-8">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-6">
            <i class="fas fa-tachometer-alt text-blue-600 mr-3"></i>ダッシュボード
        </h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
            ようこそ、{{ Auth::user()->name ?? 'ゲスト' }}さん！
            ここは新しいTailwind CSSテンプレートのダッシュボードページです。
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- カード 1 --}}
            <div class="bg-blue-500 text-white rounded-lg p-6 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-200">
                <div class="flex items-center mb-4">
                    <i class="fas fa-users text-4xl opacity-75 mr-4"></i>
                    <div>
                        <p class="text-xl font-bold">ユーザー数</p>
                        <p class="text-3xl font-extrabold">1,234</p>
                    </div>
                </div>
                <p class="text-sm opacity-90">今月の新規ユーザー</p>
            </div>

            {{-- カード 2 --}}
            <div class="bg-green-500 text-white rounded-lg p-6 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-200">
                <div class="flex items-center mb-4">
                    <i class="fas fa-dollar-sign text-4xl opacity-75 mr-4"></i>
                    <div>
                        <p class="text-xl font-bold">総売上</p>
                        <p class="text-3xl font-extrabold">¥5,678,900</p>
                    </div>
                </div>
                <p class="text-sm opacity-90">前月比 +15%</p>
            </div>

            {{-- カード 3 --}}
            <div class="bg-purple-500 text-white rounded-lg p-6 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-200">
                <div class="flex items-center mb-4">
                    <i class="fas fa-chart-bar text-4xl opacity-75 mr-4"></i>
                    <div>
                        <p class="text-xl font-bold">アクティブセッション</p>
                        <p class="text-3xl font-extrabold">456</p>
                    </div>
                </div>
                <p class="text-sm opacity-90">リアルタイムデータ</p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                <i class="fas fa-chart-line mr-2"></i>詳細レポートを見る
            </a>
        </div>
    </div>
</div>
@endsection