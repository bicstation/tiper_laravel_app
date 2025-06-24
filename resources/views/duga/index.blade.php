{{-- resources/views/main/index.blade.php --}}

@extends('layouts.app') {{-- app.blade.php をマスターレイアウトとして継承 --}}

@section('content') {{-- app.blade.php の @yield('content') に挿入されるメインコンテンツをここに記述します --}}
<div class="container-fluid bg-white p-4 rounded shadow-sm mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>ホーム</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-file me-1"></i>トップページ
            </li>
        </ol>
    </nav>
    <h1 class="mb-4"><i class="fas fa-clipboard-list me-2"></i>メインコンテンツタイトル</h1>
    <p>ここにあなたのサイトの主要なコンテンツが入ります。テキスト、画像、フォームなどを配置しましょう。</p>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle me-2"></i>コンテンツブロック 1</h5>
                    <p class="card-text">ここにブロック1の詳細な説明が入ります。</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-lightbulb me-2"></i>コンテンツブロック 2</h5>
                    <p class="card-text">ここにブロック2の詳細な説明が入ります。</p>
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
</div>
@endsection
