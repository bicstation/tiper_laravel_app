{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tiper.Live') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Font Awesome CDN (最新版 & SRI対応) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @yield('styles')
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- ★★★ ナビゲーションバー (ヘッダー) ★★★ --}}
        {{-- fixed top-0 w-full はそのまま --}}
        @include('layouts.navi') 

        {{-- ★★★ モバイル用オフキャンバスサイドバー (Alpine.js) ★★★ --}}
        {{-- ここから x-transition を削除 --}}
        <div x-data="{ sidebarOpen: false }" 
             @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
             x-show="sidebarOpen"
             class="fixed top-0 left-0 h-full w-70 bg-gray-800 text-white z-50 md:hidden overflow-y-auto p-4 shadow-lg">
            
            <div class="flex justify-between items-center pb-4 border-b border-gray-700 mb-4">
                <h5 class="text-lg font-bold flex items-center" id="offcanvasLabel">
                    <img src="{{ asset('img/logo.webp') }}" alt="Logo" class="h-6 w-auto mr-2"> Tiper.Live メニュー
                </h5>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div>
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionMobile'])
            </div>
        </div>
        {{-- モバイルサイドバーオーバーレイ --}}
        {{-- ここから x-transition を削除 --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>


        {{-- ★★★ 新しいメインコンテンツとデスクトップサイドバーのラッパー ★★★ --}}
        {{-- flex を使用してサイドバーとメインコンテンツを横に並べる --}}
        {{-- pt-14 はナビゲーションバーの高さ分 --}}
        <div class="flex flex-1 flex-grow pt-14"> 
            {{-- ★★★ デスクトップ用サイドバー ★★★ --}}
            {{-- fixed ではなく、flex コンテナの子として hidden md:block w-70 を適用 --}}
            <aside class="hidden md:block w-70 bg-gray-800 overflow-y-auto z-30 p-4 shadow-xl flex-shrink-0">
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionDesktop'])
            </aside>

            {{-- ★★★ メインコンテンツエリア ★★★ --}}
            {{-- flex-1 で残りのスペースを埋める --}}
            <main class="flex-1 p-4"> 
                @yield('content')
            </main>
        </div>

        {{-- ★★★ フッター ★★★ --}}
        <footer class="bg-gray-800 text-white py-8">
            @include('layouts.footer') 
        </footer>

        @stack('scripts')
        @yield('scripts')
    </body>
</html>