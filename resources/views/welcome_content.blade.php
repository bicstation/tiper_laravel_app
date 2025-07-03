@extends('layouts.app')

{{-- このページ固有の追加CSSが必要な場合（任意） --}}
{{-- @section('styles')
    <style>
        .custom-welcome-style {
            background-color: lightblue;
        }
    </style>
@endsection --}}

@section('content')
    {{-- ここに、以前 app.blade.php に直接書いていたメインコンテンツを貼り付けます --}}
    {{-- 例: <div class="container my-4">...</div> の中身など --}}
    <div class="container"> 
        <div class="content-card"> {{-- カスタムの背景と影を持つカード風の要素 --}}
            <h1>Tiper.Live メインサイト</h1>
            <p>ここに、以前のapp.blade.phpにあったメインコンテンツをコピー＆ペーストしてください。</p>
            <p>このページは、`layouts/app.blade.php` を基盤レイアウトとして使用しています。</p>
            <p>ナビゲーションバーは `layouts/navi.blade.php` から、サイドバーは `layouts/sidebar.blade.php` から読み込まれています。</p>
            <p>フッターはページ下部に `layouts/footer.blade.php` から読み込まれます。</p>
            {{-- ★★★ ここにあなたのメインコンテンツのHTMLを挿入する ★★★ --}}
            <p>Laravel Breezeの認証機能も統合されています。</p>
            <p>ログインしていない場合は、右上のボタンでログイン・登録が可能です。</p>
            <p>ログイン後は、ユーザー名が表示され、プロフィール編集やログアウトができます。</p>
        </div>
    </div>
@endsection

{{-- このページ固有の追加JSが必要な場合（任意） --}}
{{-- @section('scripts')
    <script>
        console.log('Welcome content loaded!');
    </script>
@endsection --}}