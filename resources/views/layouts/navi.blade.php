{{-- resources/views/layouts/navi.blade.php --}}
<nav x-data="{ open: false }" class="fixed w-full bg-blue-700 text-white shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14 items-center">
            {{-- ロゴとサイト名 --}}
            <div class="flex items-center">
                {{-- デスクトップ用ロゴ --}}
                <a class="flex-shrink-0 flex items-center hidden md:flex" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.webp') }}" alt="Tiper.Live Logo" class="h-8 w-auto mr-2">
                    <span class="font-bold text-lg tracking-wide">Tiper.Live</span>
                </a>
                {{-- モバイル用ロゴ --}}
                <a class="flex-shrink-0 flex items-center md:hidden" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.webp') }}" alt="Tiper.Live Logo" class="h-8 w-auto">
                </a>

                {{-- モバイル用サイドバートグルボタン --}}
                <button @click="$dispatch('toggle-sidebar')" class="md:hidden ml-4 p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- デスクトップ用ナビゲーションリンク --}}
            <div class="hidden space-x-8 md:flex items-center">
                <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:text-blue-100 hover:border-b-2 hover:border-white focus:outline-none focus:border-white transition duration-150 ease-in-out" href="{{ url('/') }}">
                    <i class="fas fa-home mr-2"></i>ホーム
                </a>
                
                {{-- サービス ドロップダウン --}}
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:text-blue-100 focus:outline-none focus:text-blue-100 focus:border-white transition duration-150 ease-in-out">
                        <i class="fas fa-cogs mr-2"></i>サービス
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="fas fa-wrench mr-2"></i>サービスA</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="fas fa-tools mr-2"></i>サービスB</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="fas fa-code mr-2"></i>サービスC</a>
                    </div>
                </div>

                <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:text-blue-100 hover:border-b-2 hover:border-white focus:outline-none focus:border-white transition duration-150 ease-in-out" href="{{ url('/about') }}">
                    <i class="fas fa-info-circle mr-2"></i>会社概要
                </a>
                <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:text-blue-100 hover:border-b-2 hover:border-white focus:outline-none focus:border-white transition duration-150 ease-in-out" href="{{ url('/contact') }}">
                    <i class="fas fa-envelope mr-2"></i>お問い合わせ
                </a>
            </div>

            {{-- ログイン/登録ボタン または ユーザーメニュー --}}
            <div class="flex items-center ml-auto">
                @auth
                    {{-- ユーザーがログインしている場合 --}}
                    <div x-data="{ profileOpen: false }" class="relative">
                        <button @click="profileOpen = !profileOpen" class="flex items-center text-sm font-medium text-white hover:text-blue-100 focus:outline-none focus:text-blue-100 transition duration-150 ease-in-out">
                            <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ asset('img/default-avatar.webp') }}" alt="User Avatar">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="profileOpen" @click.away="profileOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="fas fa-user-circle mr-2"></i>プロフィール</a>
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="fas fa-chart-line mr-2"></i>ダッシュボード</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="fas fa-sign-out-alt mr-2"></i>ログアウト</a>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- ユーザーがログインしていない場合 --}}
                    <a href="{{ route('login') }}" class="text-sm text-white hover:text-blue-100 mr-4 transition duration-150 ease-in-out">ログイン</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-3 py-1 bg-blue-500 rounded-md text-sm font-semibold text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">新規登録</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- モバイル用ドロップダウンメニュー (Hidden on desktop) --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="md:hidden bg-blue-800 border-t border-blue-700 shadow-md">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-home mr-2"></i>ホーム</a>
            <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-cogs mr-2"></i>サービス</a>
            <a href="{{ url('/about') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-info-circle mr-2"></i>会社概要</a>
            <a href="{{ url('/contact') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-envelope mr-2"></i>お問い合わせ</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-user-circle mr-2"></i>プロフィール</a>
                <a href="{{ url('/dashboard') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-chart-line mr-2"></i>ダッシュボード</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out"><i class="fas fa-sign-out-alt mr-2"></i>ログアウト</a>
                </form>
            @else
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out">ログイン</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:bg-blue-700 hover:border-l-4 hover:border-white transition duration-150 ease-in-out">新規登録</a>
                @endif
            @endauth
        </div>
    </div>
</nav>