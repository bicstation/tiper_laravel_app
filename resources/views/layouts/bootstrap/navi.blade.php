{{-- resources/views/layouts/navi.blade.php --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top w-100">
    <div class="container-fluid">
        {{-- ブランドロゴとタイトル --}}
        {{-- デスクトップ用 --}}
        <a class="navbar-brand d-none d-md-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.webp') }}" alt="Tiper.Live Logo" height="30" class="me-2">
            <span class="fw-bold">Tiper.Live</span> 
        </a>
        {{-- モバイル用 --}}
        <a class="navbar-brand d-md-none" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.webp') }}" alt="Tiper.Live Logo" height="30">
        </a>
        
        {{-- モバイル用オフキャンバスサイドバートグルボタン (モバイルでのみ表示) --}}
        <button class="btn btn-primary d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>

        {{-- メインナビのトグルボタン --}}
        {{-- `data-bs-toggle` と `data-bs-target` を削除し、ナビゲーションが常に展開されるようにする --}}
        <button class="navbar-toggler" type="button" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- メインナビゲーションのコンテンツ --}}
        {{-- `collapse` を削除し、`show` を追加して常に表示 --}}
        <div class="navbar-collapse show" id="mainNavbarCollapse">
            {{-- メインナビゲーションリンク --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    {{-- ホームへのリンク。ルートURLがtiper.liveの場合にactiveクラスを付与 --}}
                    <a class="nav-link {{ Request::is('/') && Request::getHost() === 'tiper.live' ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}"><i class="fas fa-home me-1"></i>ホーム</a>
                </li>
                {{-- サービス関連のリンクをドロップダウンに戻す --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs me-1"></i>サービス
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-wrench me-2"></i>サービスA</a></li> 
                        <li><a class="dropdown-item" href="#"><i class="fas fa-tools me-2"></i>サービスB</a></li> 
                        <li><a class="dropdown-item" href="#"><i class="fas fa-code me-2"></i>サービスC</a></li> 
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-box me-1"></i>製品</a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-question-circle me-1"></i>よくある質問</a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-envelope me-1"></i>お問い合わせ</a> 
                </li>
            </ul>

            {{-- デスクトップ用検索フォーム (モバイルでは非表示) --}}
            <form class="d-none d-md-inline-flex me-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="検索..." aria-label="検索">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            
            {{-- モバイル用検索フォーム (モバイルでのみ表示、ナビゲーションが展開された際に表示) --}}
            <form class="d-flex d-md-none mt-2 w-100">
                <div class="input-group">
                    <input class="form-control form-control-sm" type="search" placeholder="サイト内検索..." aria-label="Search">
                    <button class="btn btn-outline-light btn-sm" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        
        {{-- ログイン/登録ボタン（常に右側に表示） --}}
        <div class="d-flex align-items-center ms-auto">
            @auth
                <div class="dropdown">
                    <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2"></i>プロフィール</a></li>
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