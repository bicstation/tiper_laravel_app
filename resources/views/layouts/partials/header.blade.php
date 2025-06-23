<header class="py-3 bg-primary text-white grid-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-light d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <button class="btn btn-outline-light me-3 d-none d-md-inline-flex" id="myCustomSidebarToggleBtn" type="button">
            <i class="fas fa-bars"></i>
        </button>
        <h3 class="my-0 me-auto">
            <a href="{{ url('/') }}" class="text-white text-decoration-none">Tiper Live</a>
        </h3>
        
        <div class="current-time me-3" id="current-time-display">
            読み込み中...
        </div>

        <nav class="navbar navbar-expand-md navbar-dark p-0">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}"><i class="fas fa-home me-1"></i>ホーム</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-box me-1"></i>サービス</a> {{-- 仮のリンク --}}
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cube me-1"></i>製品
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">製品A</a></li> {{-- 仮のリンク --}}
                            <li><a class="dropdown-item" href="#">製品B</a></li> {{-- 仮のリンク --}}
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">その他</a></li> {{-- 仮のリンク --}}
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-question-circle me-1"></i>よくある質問</a> {{-- 仮のリンク --}}
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-envelope me-1"></i>お問い合わせ</a> {{-- 仮のリンク --}}
                    </li>
                </ul>
                <form class="d-none d-md-inline-flex ms-3" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="サイト内検索..." aria-label="Search">
                        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                
                <div class="ms-3 d-flex align-items-center">
                    @auth {{-- ユーザーがログインしている場合 --}}
                        <span class="text-white me-2">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->username ?? Auth::user()->name }} {{-- usernameがなければnameを表示 --}}
                            @if (Auth::user()->is_admin) {{-- is_adminカラムがある場合 --}}
                                (管理者)
                            @else
                                (一般ユーザー)
                            @endif
                        </span>
                        <a href="{{ route('logout') }}" class="btn btn-outline-light"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i>ログアウト
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else {{-- ユーザーがログインしていない場合 --}}
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-1"></i>ログイン
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>

@push('scripts') {{-- app.blade.php の @stack('scripts') に挿入される --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeDisplay = document.getElementById('current-time-display');

    function updateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        // ローカルタイムゾーンの略称を取得（ブラウザ依存）
        // const timeZone = now.toLocaleTimeString('en', { timeZoneName:'short' }).split(' ')[2] || '';

        // Timezoneは表示しない場合は上記をコメントアウト
        timeDisplay.textContent = `時刻: ${year}/${month}/${day} ${hours}:${minutes}:${seconds}`;
    }

    // 初回表示
    updateTime();
    // 1秒ごとに更新
    setInterval(updateTime, 1000);
});
</script>
@endpush