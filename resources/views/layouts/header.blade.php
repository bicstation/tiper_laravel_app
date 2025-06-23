{{-- resources/views/layouts/header.blade.php --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-md-block" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Tiper.Live Logo" height="30" class="me-2">Tiper.Live
        </a>
        <a class="navbar-brand d-md-none" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Tiper.Live Logo" height="30">
        </a>

        {{-- スマホ版サイドバー開閉ボタン (Offcanvasトリガー) --}}
        <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- ナビゲーションメニュー項目は navi.blade.php に移動しました --}}
            </ul>
            {{-- PC版検索フォーム --}}
            <form class="d-none d-md-inline-flex ms-auto">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="検索..." aria-label="検索">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex align-items-center ms-auto ms-md-3">
            @auth
                {{-- ログイン済みユーザーの場合 --}}
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ url('/profile') }}">プロフィール</a></li>
                        <li><a class="dropdown-item" href="{{ url('/dashboard') }}">ダッシュボード</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">ログアウト</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                {{-- 未ログインユーザーの場合 --}}
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">ログイン</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">登録</a>
                @endif
            @endauth
        </div>
    </div>
</nav>
