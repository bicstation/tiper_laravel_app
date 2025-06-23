<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'My Awesome Site'))</title> {{-- ページタイトルを動的に設定。デフォルトは config('app.name') --}}

    <link rel="icon" href="{{ asset('img/logo.webp') }}"> {{-- asset() ヘルパーで public/img/logo.webp を参照 --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="{{ asset('css/style_v2.css') }}" rel="stylesheet"> {{-- asset() ヘルパーで public/css/style_v2.css を参照 --}}

    {{-- 各ページ固有のスタイルを挿入するためのプレースホルダー --}}
    @stack('styles')