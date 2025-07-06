{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- ★★★ ページのタイトル (SEO重要) ★★★ --}}
        {{-- 各ページで @section('title', 'ページタイトル') を定義。なければアプリ名が使われる。 --}}
        <title>@yield('title', config('app.name', 'Tiper.Live'))</title>

        {{-- ★★★ ページのディスクリプション (SEO重要) ★★★ --}}
        {{-- 各ページで @section('description', 'ディスクリプション') を定義。なければデフォルトが使われる。 --}}
        <meta name="description" content="@yield('description', 'Tiper.Live は、日々の生活をより豊かに、より楽しくするためのヒントや情報を発信するブログです。最新のテクノロジー、ライフハック、趣味、健康、学びに関する情報を厳選してお届けします。')">

        {{-- ★★★ robots メタタグ (デフォルトでインデックス・フォローを許可) ★★★ --}}
        {{-- 特定のページをインデックスさせたくない場合は、そのページで @section('robots', 'noindex, nofollow') を使う --}}
        <meta name="robots" content="@yield('robots', 'index, follow')">

        {{-- ★★★ Canonical URL (SEO重要 - 重複コンテンツ対策) ★★★ --}}
        {{-- 各ページで @section('canonical', 'https://example.com/canonical-url') を定義。なければ現在のURLが使われる。 --}}
        <link rel="canonical" href="@yield('canonical', url()->current())">

        {{-- ★★★ Open Graph (OGP) タグ - SNSでの表示に重要 ★★★ --}}
        <meta property="og:site_name" content="{{ config('app.name', 'Tiper.Live') }}">
        <meta property="og:type" content="@yield('og:type', 'website')"> {{-- 記事なら 'article' --}}
        <meta property="og:url" content="@yield('og:url', url()->current())">
        <meta property="og:title" content="@yield('og:title', config('app.name', 'Tiper.Live'))">
        <meta property="og:description" content="@yield('og:description', 'Tiper.Live は、日々の生活をより豊かに、より楽しくするためのヒントや情報を発信するブログです。')">
        {{-- デフォルトのOGP画像。適切なパスに置き換えてください。 --}}
        <meta property="og:image" content="@yield('og:image', asset('img/default_og_image.jpg'))">
        <meta property="og:image:width" content="@yield('og:image:width', '1200')">
        <meta property="og:image:height" content="@yield('og:image:height', '630')">
        {{-- OGP画像のaltテキストは、視覚障碍者向けアクセシビリティにも役立ちます --}}
        <meta property="og:image:alt" content="@yield('og:image:alt', 'Tiper.Live のウェブサイトロゴ')">


        {{-- ★★★ Twitter Cards タグ - X (旧Twitter) での表示に重要 ★★★ --}}
        <meta name="twitter:card" content="@yield('twitter:card', 'summary_large_image')"> {{-- large_image が推奨 --}}
        <meta name="twitter:site" content="@yield('twitter:site', '@your_twitter_handle')"> {{-- あなたのTwitterアカウントがあれば設定 (例: @TiperLive) --}}
        <meta name="twitter:creator" content="@yield('twitter:creator', '@your_twitter_handle')"> {{-- 記事作成者のTwitterアカウントがあれば設定 --}}
        <meta name="twitter:title" content="@yield('twitter:title', config('app.name', 'Tiper.Live'))">
        <meta name="twitter:description" content="@yield('twitter:description', 'Tiper.Live は、日々の生活をより豊かに、より楽しくするためのヒントや情報を発信するブログです。')">
        <meta name="twitter:image" content="@yield('twitter:image', asset('img/default_og_image.jpg'))">
        <meta name="twitter:image:alt" content="@yield('twitter:image:alt', 'Tiper.Live のウェブサイトロゴ')">

        {{-- ★★★ ファビコン ★★★ --}}
        {{-- publicディレクトリに favicon.ico や apple-touch-icon.png を配置してください --}}
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">


        {{-- Google Fonts - Figtree --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Font Awesome CDN --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- ViteによるCSSとJSの読み込み --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- 各ページ固有の追加スタイルシート (必要であれば) --}}
        @yield('styles')
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

        {{-- ★★★ ナビゲーションバー (ヘッダー) ★★★ --}}
        @include('layouts.navi') 

        {{-- ★★★ モバイル用オフキャンバスサイドバー (Alpine.js) ★★★ --}}
        <div x-data="{ sidebarOpen: false }" 
             @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
             x-show="sidebarOpen"
             class="fixed top-0 left-0 h-full w-70 bg-gray-800 text-white dark:bg-gray-950 dark:text-gray-50 z-50 md:hidden overflow-y-auto p-4 shadow-lg"
             x-cloak>
            
            <div class="flex justify-between items-center pb-4 border-b border-gray-700 mb-4 dark:border-gray-600">
                <h5 class="text-lg font-bold flex items-center" id="offcanvasLabel">
                    <img src="{{ asset('img/logo.webp') }}" alt="Logo" class="h-6 w-auto mr-2"> Tiper.Live メニュー
                </h5>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white focus:outline-none focus:text-white dark:text-gray-500 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div>
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionMobile'])
            </div>
        </div>
        {{-- モバイルサイドバーオーバーレイ --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" x-cloak></div>


        {{-- ★★★ 新しいメインコンテンツとデスクトップサイドバーのラッパー ★★★ --}}
        <div class="flex flex-1 flex-grow pt-14"> 
            {{-- ★★★ デスクトップ用サイドバー ★★★ --}}
            <aside class="hidden md:block w-70 bg-gray-800 dark:bg-gray-950 dark:text-gray-50 overflow-y-auto z-30 p-4 shadow-xl flex-shrink-0">
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionDesktop'])
            </aside>

            {{-- ★★★ メインコンテンツエリア ★★★ --}}
            <main class="flex-1 p-4"> 
                @yield('content')
            </main>
        </div>

        {{-- ★★★ フッター ★★★ --}}
        <footer class="bg-gray-800 text-white dark:bg-gray-950 dark:text-gray-50 py-8">
            @include('layouts.footer') 
        </footer>

        @stack('scripts')
        @yield('scripts')
    </body>
</html>