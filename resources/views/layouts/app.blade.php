<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ページタイトルを動的に設定。デフォルトは config('app.name') --}}
    <title>@yield('title', config('app.name', 'Tiper.Live'))</title> 

    {{-- asset() ヘルパーで public/img/logo.webp を参照 --}}
    <link rel="icon" href="{{ asset('img/logo.webp') }}"> 

    {{-- Font Awesome の CDN 読み込み --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- asset() ヘルパーで public/css/style_v2.css を参照 (カスタムスタイル) --}}
    <link href="{{ asset('css/style_v2.css') }}" rel="stylesheet"> 

    {{-- Viteアセットを読み込むためのディレクティブ (resources/css/app.css と resources/js/app.js を含む) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ここに、追加のインラインスタイルを記述します。 --}}
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #main-content-area {
            display: flex;
            flex-grow: 1; 
            width: 100%; 
        }

        aside.d-md-block {
            flex-shrink: 0; 
            width: 280px;   
            height: 100%; 
            overflow-y: auto; 
        }

        #main-content-wrapper {
            display: flex;
            flex-direction: column;
            flex-grow: 1; 
            /* 幅の計算はFlexboxが自動で行うため、不要な calc() を削除 */
            overflow-x: hidden; 
        }
        
        main {
            flex-grow: 1;
            overflow-y: auto; 
        }

        /* サイドバーの背景色をカスタマイズ（ダークモードに合わせる） */
        .offcanvas.bg-dark, aside.bg-dark {
            background-color: #343a40 !important; 
        }
        /* アコーディオンのヘッダーとボディのテキスト色を調整 */
        .accordion-button.bg-dark,
        .accordion-body .list-unstyled a {
            color: white; 
        }
        /* アクティブなリンクのスタイル */
        .nav-link.active, .accordion-button:not(.collapsed) {
            color: #fff;
            background-color: #0d6efd; 
            border-radius: 0.25rem;
        }
        .accordion-button:focus {
            box-shadow: none; 
        }
        
        /* メインナビとヘッダーナビの表示/非表示制御 */
        /* mdサイズ以上で navi (青) は常に表示、header (黒) は常に表示 */
        /* mdサイズ未満で navi (青) はトグルで表示、header (黒) はトグルで非表示にせず固定ヘッダーとして機能 */
        .navbar-collapse:not(.d-md-none) { /* d-md-none を持たない (つまりデスクトップ表示の) navbar-collapse */
            display: flex !important; /* flex にしてアイテムが横並びになるように */
            flex-grow: 1; /* スペースを占有 */
        }
        .navbar-toggler:not(.d-md-none) { /* d-md-none を持たない navbar-toggler */
            display: none !important; /* デスクトップでは非表示 */
        }
        @media (max-width: 767.98px) { /* md未満の画面サイズ (モバイル) */
            .navbar-collapse:not(.d-md-none) {
                display: none !important; /* モバイルではデフォルトで非表示 */
            }
            .navbar-toggler:not(.d-md-none) {
                display: block !important; /* モバイルでは表示 */
            }
            /* デスクトップ用の固定サイドバーをモバイルで非表示 */
            aside.d-md-block {
                display: none !important; 
            }
            /* メインコンテンツエリアのflex-directionをcolumnにして縦積みに変更 */
            #main-content-area {
                flex-direction: column;
            }
            /* メインコンテンツラッパーも幅100%に */
            #main-content-wrapper {
                width: 100%;
            }
        }
    </style>

    {{-- 各ページ固有のスタイルを挿入するためのプレースホルダー --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">
    {{-- メインナビゲーション (ページの最上部) --}}
    @include('layouts.navi')

    {{-- ヘッダーナビゲーション (その下) --}}
    @include('layouts.header')

    {{-- メインコンテンツ領域（サイドバーと、その隣にコンテンツ） --}}
    <div id="main-content-area">
        {{-- デスクトップ用固定サイドバー (mdサイズ以上でのみ表示) --}}
        <aside class="bg-dark text-white d-none d-md-block">
            <div class="p-3 border-bottom border-secondary">
                <h5 class="text-white">サイドメニュー</h5>
            </div>
            <div class="accordion accordion-flush w-100" id="sidebarAccordionDesktop">
                {{-- サイドバーコンテンツをインクルードし、アコーディオンIDを渡す --}}
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionDesktop'])
            </div>
        </aside>

        {{-- サイドバーの隣に配置されるメインコンテンツラッパー --}}
        <div id="main-content-wrapper">
            <main class="p-3"> {{-- メインコンテンツにパディングを追加 --}}
                {{-- 各ページ固有のコンテンツがここに挿入されます --}}
                @yield('content')
            </main>
        </div>
    </div>

    {{-- フッター (常に全幅) --}}
    @include('layouts.footer')

    {{-- モバイル用オフキャンバス サイドバー (mdサイズ未満でのみ表示) --}}
    <div class="offcanvas offcanvas-start bg-dark text-white d-md-none" tabindex="-1" id="myCustomSidebar" aria-labelledby="myCustomSidebarLabel">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title" id="myCustomSidebarLabel">サイドメニュー</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-0">
            <div class="accordion accordion-flush w-100" id="sidebarAccordionMobile">
                {{-- サイドバーコンテンツをインクルードし、アコーディオンIDを渡す --}}
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionMobile'])
            </div>
        </div>
    </div>

    {{-- 各ページ固有のスクリプトを挿入するためのプレースホルダー --}}
    @stack('scripts')
</body>
</html>
