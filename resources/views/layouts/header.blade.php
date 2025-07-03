{{-- resources/views/layouts/header.blade.php --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
    <div class="container-fluid">
        {{-- デスクトップ用ブランドロゴとタイトル --}}
        <a class="navbar-brand d-none d-md-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.webp') }}" alt="Tiper.Live Logo" height="30" class="me-2">
            <span class="fw-bold">Tiper.Live</span> {{-- ロゴの隣にタイトルを追加しました --}}
        </a>
        {{-- モバイル用ブランドロゴ --}}
        <a class="navbar-brand d-md-none" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.webp') }}" alt="Tiper.Live Logo" height="30">
        </a>
        
        {{-- モバイル用オフキャンバスサイドバートグルボタン --}}
        <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- ここにナビゲーション項目を追加できますが、通常はメインナビに任せる --}}
            </ul>
            {{-- デスクトップ用検索フォーム --}}
            <form class="d-none d-md-inline-flex ms-auto">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="検索..." aria-label="検索">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        
        {{-- ログイン/登録ボタン（常に表示） --}}
        <div class="d-flex align-items-center ms-auto ms-md-3">
            @auth
                {{-- ★★★ ここに管理ダッシュボードへのリンクを追加 ★★★ --}}
                <a href="{{ env('FILAMENT_ADMIN_URL') }}" class="btn btn-outline-info me-2 d-none d-md-inline-flex">
                    <i class="fas fa-cog me-2"></i>管理ダッシュボード
                </a>
                {{-- モバイル用ドロップダウンメニューにも追加する場合は、以下をドロップダウンリスト内に追加 --}}
                {{--
                <a class="dropdown-item" href="{{ env('FILAMENT_ADMIN_URL') }}"><i class="fas fa-cog me-2"></i>管理ダッシュボード</a>
                --}}
                <div class="dropdown">
                    <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2"></i>プロフィール</a></li>
                        {{-- ★★★ モバイル用ドロップダウンメニューに管理ダッシュボードリンクを追加するならここ ★★★ --}}
                        <li class="d-md-none"><a class="dropdown-item" href="{{ env('FILAMENT_ADMIN_URL') }}"><i class="fas fa-cog me-2"></i>管理ダッシュボード</a></li>
                        <li><hr class="dropdown-divider d-md-none"></li> {{-- モバイルのみ区切り線 --}}
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="route('logout')"
                                   onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>ログアウト
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">ログイン</a>
                <a href="{{ route('register') }}" class="btn btn-primary">登録</a>
            @endauth
        </div>
    </div>
</nav>