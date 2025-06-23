{{-- このファイルは、`layouts/app.blade.php` で `@yield('content')` の中にインクルードするか、
     各具体的なビューファイルでこの内容を `@section('content')` として記述します。
     今回は、このコンテンツを独立したファイルとして扱い、必要な部分で呼び出す例として記述します。 --}}

{{-- メインコンテンツのラッパーとなる div は、app.blade.php などに配置されることを想定しています。
     ここでは、その内部のコンテンツのみを提供します。 --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        {{-- ホームへのリンク --}}
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>ホーム</a></li>
        
        {{-- カテゴリへのリンク (必要に応じて動的に生成) --}}
        <li class="breadcrumb-item">
            <a href="#">
                <i class="fas fa-list me-1"></i>カテゴリ
                {{-- ここにカテゴリ名などを動的に表示する場合は @yield('breadcrumb_category') などを使用 --}}
            </a>
        </li>
        
        {{-- 現在のページタイトル (各ビューファイルで @section('current_page_breadcrumb') で設定) --}}
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-file me-1"></i>@yield('current_page_breadcrumb', '現在のページ')
        </li>
    </ol>
</nav>

<div class="container-fluid bg-white p-4 rounded shadow-sm mt-3">
    {{-- メインコンテンツのタイトル (各ビューファイルで @section('main_title') で設定) --}}
    <h1 class="mb-4"><i class="fas fa-clipboard-list me-2"></i>@yield('main_title', 'メインコンテンツタイトル')</h1>
    
    {{-- ここに各ページ固有のコンテンツを挿入します --}}
    @yield('content') {{-- ここが各ページ固有のコンテンツが入る場所です --}}

    {{-- デフォルトのコンテンツブロック (必要であれば残す) --}}
    @if (!View::hasSection('content')) {{-- contentセクションが定義されていない場合にのみ表示 --}}
        <p>ここにあなたのサイトの主要なコンテンツが入ります。テキスト、画像、フォームなどを配置しましょう。</p>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-info-circle me-2"></i>コンテンツブロック 1</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-lightbulb me-2"></i>コンテンツブロック 2</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-images me-2"></i>ギャラリー</h5>
                        <div class="row">
                            <div class="col-md-4 mb-2"><img src="{{ asset('img/photos/download.png') }}" class="img-fluid rounded" alt="Placeholder Image"></div>
                            <div class="col-md-4 mb-2"><img src="{{ asset('img/photos/download.png') }}" class="img-fluid rounded" alt="Placeholder Image"></div>
                            <div class="col-md-4 mb-2"><img src="{{ asset('img/photos/download.png') }}" class="img-fluid rounded" alt="Placeholder Image"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>