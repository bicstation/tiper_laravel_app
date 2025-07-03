{{-- resources/views/layouts/sidebar.blade.php --}}

{{--
    このファイルは、app.blade.php の `.offcanvas-body` の中、
    またはデスクトップ用 <aside> タグの中に
    インクルードされることを想定しています。
    したがって、外側のラッパー要素（例: <div class="sidebar">）は含めません。
--}}

{{-- サイドバーの項目リスト (アコーディオンではない直接のリンク) --}}
<ul class="list-unstyled mb-0">
    <li>
        {{-- tiper.live のトップページの場合のみ active --}}
        <a class="nav-link text-white py-2 {{ Request::is('/') && Request::getHost() === 'tiper.live' ? 'active' : '' }}" href="{{ url('/') }}">
            <i class="fas fa-home me-2"></i>ホーム
        </a>
    </li>
    {{-- ダッシュボードリンク（メインドメインのみ） --}}
    @if (!isset($isDugaDomain) || !$isDugaDomain)
    <li>
        <a class="nav-link text-white py-2 {{ Request::is('dashboard') && Request::getHost() === 'tiper.live' ? 'active' : '' }}" href="{{ url('/dashboard') }}">
            <i class="fas fa-tachometer-alt me-2"></i>ダッシュボード
        </a>
    </li>
    @endif
</ul>

{{-- サイドバーのアコーディオンメニュー --}}
{{-- $accordionId は app.blade.php から渡されます (例: sidebarAccordionDesktop, sidebarAccordionMobile) --}}

{{-- アコーディオン全体のラッパー（重要：これがないとdata-bs-parentが機能しません） --}}
<div class="accordion accordion-flush" id="{{ $accordionId }}"> 
    @if (isset($isDugaDomain) && $isDugaDomain) {{-- $isDugaDomain がコントローラから渡され、かつtrueの場合 --}}

        {{-- Dugaジャンル --}}
        <div class="accordion-item bg-dark">
            <h2 class="accordion-header" id="headingDugaGenres">
                <button class="accordion-button bg-dark text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDugaGenres" aria-expanded="false" aria-controls="collapseDugaGenres">
                    <i class="fas fa-video me-2"></i>Dugaジャンル
                </button>
            </h2>
            <div id="collapseDugaGenres" class="accordion-collapse collapse" aria-labelledby="headingDugaGenres" data-bs-parent="#{{ $accordionId }}">
                <div class="accordion-body bg-dark">
                    <ul class="list-unstyled mb-0">
                        @if (!empty($dugaGenres))
                            @foreach ($dugaGenres as $genre)
                                <li>
                                    <a class="nav-link text-white py-2" href="http://duga.tipers.live?genre={{ urlencode($genre) }}">
                                        <i class="fas fa-tag me-2"></i>{{ htmlspecialchars($genre) }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><span class="nav-link text-muted">ジャンルなし</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

    @else {{-- メインドメイン (tiper.live) の場合 --}}

        {{-- カテゴリ 1 --}}
        <div class="accordion-item bg-dark">
            <h2 class="accordion-header" id="headingCategory1">
                <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory1" aria-expanded="true" aria-controls="collapseCategory1">
                    <i class="fas fa-folder me-2"></i>カテゴリ 1
                </button>
            </h2>
            <div id="collapseCategory1" class="accordion-collapse collapse show" aria-labelledby="headingCategory1" data-bs-parent="#{{ $accordionId }}">
                <div class="accordion-body bg-dark">
                    <ul class="list-unstyled mb-0">
                        <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-1</a></li>
                        <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-2</a></li>
                        <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-3</a></li>
                        <li><a class="nav-link text-white py-2" href="{{ route('register') }}"><i class="fas fa-user-plus me-2"></i>ユーザー登録</a></li>
                        <li><a class="nav-link text-white py-2" href="{{ url('/products_admin') }}"><i class="fas fa-cube me-2"></i>商品登録</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- カテゴリ 2 --}}
        <div class="accordion-item bg-dark">
            <h2 class="accordion-header" id="headingCategory2">
                <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory2" aria-expanded="false" aria-controls="collapseCategory2">
                    <i class="fas fa-folder me-2"></i>カテゴリ 2
                </button>
            </h2>
            <div id="collapseCategory2" class="accordion-collapse collapse" aria-labelledby="headingCategory2" data-bs-parent="#{{ $accordionId }}">
                <div class="accordion-body bg-dark">
                    <ul class="list-unstyled mb-0">
                        <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-chart-bar me-2"></i>データ分析</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 認証 --}}
        <div class="accordion-item bg-dark">
            <h2 class="accordion-header" id="headingAuth">
                <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuth" aria-expanded="false" aria-controls="collapseAuth">
                    <i class="fas fa-lock me-2"></i>認証
                </button>
            </h2>
            <div id="collapseAuth" class="accordion-collapse collapse" aria-labelledby="headingAuth" data-bs-parent="#{{ $accordionId }}">
                <div class="accordion-body bg-dark">
                    <ul class="list-unstyled mb-0">
                        @auth {{-- ユーザーがログインしている場合 --}}
                            <li>
                                <a class="nav-link text-white py-2" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>ログアウト
                                </a>
                                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li><a class="nav-link text-white py-2" href="{{ url('/users_admin') }}"><i class="fas fa-users-cog me-2"></i>ユーザー管理</a></li>
                        @else {{-- ユーザーがログインしていない場合 --}}
                            <li><a class="nav-link text-white py-2" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>ログイン</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div> {{-- アコーディオン全体のラッパーの閉じタグ --}}

@push('scripts') {{-- app.blade.php の @stack('scripts') に挿入される --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const myCustomSidebarOffcanvas = document.getElementById('myCustomSidebar');
        const mainContent = document.querySelector('main');

        if (myCustomSidebarOffcanvas && mainContent) {
            myCustomSidebarOffcanvas.addEventListener('show.bs.offcanvas', function () {
                // オフキャンバス表示時にメインコンテンツの左マージンを調整 (mdサイズ以上の場合のみ)
                if (window.innerWidth >= 768) { 
                    mainContent.style.marginLeft = '280px'; 
                }
            });
            myCustomSidebarOffcanvas.addEventListener('hide.bs.offcanvas', function () {
                mainContent.style.marginLeft = '0'; 
            });
            
            // 画面サイズ変更時の対応
            window.addEventListener('resize', function() {
                if (window.innerWidth < 768) { 
                    mainContent.style.marginLeft = '0';
                } else { 
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(myCustomSidebarOffcanvas);
                    if (bsOffcanvas && bsOffcanvas._isShown) { 
                        mainContent.style.marginLeft = '280px';
                    }
                }
            });
        }
    });
</script>
@endpush