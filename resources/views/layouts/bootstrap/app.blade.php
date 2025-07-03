<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlalH/lRjYwT+5R5/3o/Xv+p4eD/jLpE9y+5z4k7U3o2lQ5J/h+rT+6M+G8w2e/Rz+y+X6D+Q6w+w+x+XQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- Laravel Breezeが自動生成するapp.css (Tailwind CSS) は使用しないためコメントアウト --}}
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

        {{-- カスタムCSSのスタイルブロック --}}
        <style>
            /* Bootstrap 5.3 に特化したカスタムスタイル */
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh; /* 画面の高さいっぱいに広げる */
                background-color: #f8f9fa; /* 背景色 */
            }

            /* ナビバーの高さに合わせてメインコンテンツを下にずらす */
            .main-content-area {
                padding-top: 56px; /* ナビバーの高さ (Bootstrapのデフォルトは約56px) */
                flex-grow: 1; /* 残りの高さを占有 */
            }

            /* デスクトップサイドバーのスタイル */
            .desktop-sidebar {
                position: fixed;
                top: 56px; /* ナビバーの高さの分だけ下にずらす */
                left: 0;
                bottom: 0;
                width: 280px; /* サイドバーの固定幅 */
                background-color: #343a40; /* Dark背景色 */
                overflow-y: auto; /* コンテンツが長い場合にスクロール */
                z-index: 1030; /* Navbar(1050)より低く、Dropdown(1070)より低く */
                padding: 1rem; /* サイドバー内部のパディング */
            }

            /* メインコンテンツエリアの左マージンを調整 */
            @media (min-width: 768px) { /* md以上 */
                .main-content-wrapper,
                .main-content-footer {
                    margin-left: 280px; /* デスクトップサイドバーの幅分マージンを設定 */
                }
            }
            /* モバイルではマージンをリセット */
            @media (max-width: 767.98px) { /* md未満 */
                .main-content-wrapper,
                .main-content-footer {
                    margin-left: 0 !important; /* 強制的にマージンをリセット */
                }
            }

            /* コンテンツエリアの背景色と影 */
            .content-card {
                background-color: #fff; /* 白い背景 */
                padding: 1.5rem; /* パディング */
                border-radius: .25rem; /* 角丸 */
                box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); /* 軽い影 */
            }

            /* ナビバーの z-index を明示的に高く設定 */
            .navbar {
                z-index: 1050; /* Bootstrapデフォルト */
            }

            /* ドロップダウンメニューの z-index をさらに高く設定 */
            .navbar-nav .dropdown-menu {
                z-index: 1070; /* Navbar(1050)やオフキャンバス(1040)より高く、モーダルバックドロップ(1060)より高く設定 */
            }

            /* オフキャンバスの z-index も確認 */
            .offcanvas {
                z-index: 1040; /* Bootstrapデフォルト */
            }

            /* 子ビューから追加されるスタイル */
            @yield('styles')
        </style>
    </head>
    <body>
        {{-- ★★★ ナビゲーションバー (ヘッダー) ★★★ --}}
        @include('layouts.navi') 

        {{-- ★★★ オフキャンバスサイドバー (モバイル用) ★★★ --}}
        <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="myCustomSidebar" aria-labelledby="offcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabel">
                    <img src="{{ asset('img/logo.webp') }}" alt="Logo" height="30" class="me-2"> Tiper.Live メニュー
                </h5>
                <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- オフキャンバス用サイドバーの内容を読み込む --}}
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionMobile', 'isDugaDomain' => (Request::getHost() === 'duga.tipers.live')])
            </div>
        </div>

        {{-- メインコンテンツとデスクトップサイドバーのラッパー --}}
        <div class="main-content-area d-flex"> 
            {{-- ★★★ デスクトップ用サイドバー ★★★ --}}
            <aside class="desktop-sidebar d-none d-md-block"> {{-- md以上の画面で表示 --}}
                {{-- デスクトップ用サイドバーの内容を読み込む --}}
                @include('layouts.sidebar', ['accordionId' => 'sidebarAccordionDesktop', 'isDugaDomain' => (Request::getHost() === 'duga.tipers.live')])
            </aside>

            {{-- ★★★ メインコンテンツエリア ★★★ --}}
            <main class="flex-grow-1 p-4 main-content-wrapper"> 
                {{-- ここに子ビューのコンテンツが展開される --}}
                @yield('content') {{-- ★★★ $slot を @yield('content') に変更 ★★★ --}}
            </main>
        </div> {{-- .main-content-area の閉じタグ --}}

        {{-- ★★★ フッター ★★★ --}}
        <footer class="bg-dark text-white py-3 main-content-footer">
            <div class="container"> {{-- メインコンテンツと同じ .container を使用 --}}
                @include('layouts.footer') 
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        {{-- sidebar.blade.php の @push('scripts') がここに入る --}}
        @stack('scripts')
        {{-- 子ビューから追加されるスクリプト --}}
        @yield('scripts')
    </body>