{{-- コントローラから $isDugaDomain と $dugaGenres が渡されることを前提とします --}}
{{-- 例: Web.phpで下記のようにデータを渡す --}}
{{-- Route::get('/', function () {
    $isDugaDomain = (request()->getHost() === 'duga.tipers.live');
    $dugaGenres = [];
    if ($isDugaDomain) {
        // ここでデータベースからジャンルを取得するロジックを実装
        // $dugaGenres = \App\Models\Product::where('source_api', 'Duga')
        //                                   ->distinct('genre')
        //                                   ->pluck('genre')
        //                                   ->filter() // nullや空文字列を除外
        //                                   ->sortBy(fn($genre) => $genre)
        //                                   ->all();
        // Laravelのログに出力: Log::info("サイドバーにDugaジャンルをロードしました: " . implode(', ', $dugaGenres));
    }
    return view('welcome', compact('isDugaDomain', 'dugaGenres'));
}); --}}

<div class="sidebar">
    <div class="sidebar-header">
        <h5 class="text-white">サイドメニュー</h5>
        {{-- Bootstrap Offcanvasのトグルボタンとして機能させる --}}
        <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar" aria-label="Close"></button>
    </div>
    <ul class="nav flex-column">
        @if (isset($isDugaDomain) && $isDugaDomain) {{-- $isDugaDomain がコントローラから渡され、かつtrueの場合 --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('duga-home') ? 'active' : '' }}" href="http://duga.tipers.live"><i class="fas fa-home me-2"></i>Dugaホーム</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#dugaGenresSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="dugaGenresSubmenu">
                    <i class="fas fa-video me-2"></i>Dugaジャンル
                </a>
                <div class="collapse" id="dugaGenresSubmenu">
                    <ul class="nav flex-column ps-3">
                        @if (!empty($dugaGenres))
                            @foreach ($dugaGenres as $genre)
                                <li class="nav-item">
                                    <a class="nav-link" href="http://duga.tipers.live?genre={{ urlencode($genre) }}">
                                        <i class="fas fa-tag me-2"></i>{{ htmlspecialchars($genre) }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="nav-item">
                                <span class="nav-link text-muted">ジャンルなし</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}"><i class="fas fa-home me-2"></i>ホーム</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#category1Submenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="category1Submenu">
                    <i class="fas fa-folder me-2"></i>カテゴリ 1
                </a>
                <div class="collapse show" id="category1Submenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-1</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-2</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-3</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-2"></i>ユーザー登録</a></li> {{-- Laravelのデフォルト登録ルート --}}
                        <li class="nav-item"><a class="nav-link" href="{{ url('/products_admin') }}"><i class="fas fa-cube me-2"></i>商品登録</a></li> {{-- 仮のURL --}}
                    </ul>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#category2Submenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="category2Submenu">
                    <i class="fas fa-folder me-2"></i>カテゴリ 2
                </a>
                <div class="collapse" id="category2Submenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-chart-bar me-2"></i>データ分析</a></li>
                        </ul>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#authSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="authSubmenu">
                    <i class="fas fa-lock me-2"></i>認証
                </a>
                <div class="collapse" id="authSubmenu">
                    <ul class="nav flex-column ps-3">
                        @auth {{-- ユーザーがログインしている場合 --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>ログアウト
                                </a>
                                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/users_admin') }}"><i class="fas fa-users-cog me-2"></i>ユーザー管理</a></li> {{-- 仮のURL --}}
                        @else {{-- ユーザーがログインしていない場合 --}}
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>ログイン</a></li>
                        @endauth
                    </ul>
                </div>
            </li>
        @endif
    </ul>
</div>

@push('scripts') {{-- app.blade.php の @stack('scripts') に挿入される --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        // オフキャンバスを直接ターゲットにするため、BootstrapのOffcanvas JSが適用されている要素を取得
        const myCustomSidebar = document.getElementById('myCustomSidebar');
        const mainContent = document.querySelector('.grid-main'); // メインコンテンツの親要素

        if (sidebarToggle && myCustomSidebar && mainContent) {
            // sidebarToggleボタンは、Offcanvasの表示・非表示を制御するのみ
            // Bootstrap Offcanvasが自動でclassを管理するため、直接のclass操作は不要な場合が多い
            // ただし、メインコンテンツのシフトが必要な場合はこのロジックを維持
            myCustomSidebar.addEventListener('show.bs.offcanvas', function () {
                if (mainContent) {
                    mainContent.classList.add('sidebar-active'); // サイドバーが表示されたらクラスを追加
                }
            });
            myCustomSidebar.addEventListener('hide.bs.offcanvas', function () {
                if (mainContent) {
                    mainContent.classList.remove('sidebar-active'); // サイドバーが隠れたらクラスを削除
                }
            });
        }
    });
</script>
@endpush