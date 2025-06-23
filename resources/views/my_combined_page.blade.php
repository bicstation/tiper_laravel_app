<!DOCTYPE html>
<html lang="ja">
<head>
    @include('layouts.head') {{-- 'layouts.head' は resources/views/layouts/head.blade.php を指します --}}
    <title>私の統合ページ</title>
    {{-- 必要であれば、このページ固有のCSSやJSを追加 --}}
</head>
<body>
    <header>
        @include('layouts.header')
    </header>

    <nav>
        @include('layouts.navi')
    </nav>

    <div id="wrapper" style="display: flex;"> {{-- sidebarとmainを並べるためのラッパー例 --}}
        <aside style="width: 20%;"> {{-- サイドバーのスタイリング例 --}}
            @include('layouts.sidebar')
        </aside>

        <main style="width: 80%;"> {{-- メインコンテンツのスタイリング例 --}}
            {{-- ここに、このページ固有の動的なコンテンツが入る場所を定義できます --}}
            {{-- 例: @yield('content') --}}
            @include('layouts.main') {{-- 固定のmainコンテンツを組み込む場合 --}}
        </main>
    </div>

    <footer>
        @include('layouts.footer')
    </footer>
</body>
</html>