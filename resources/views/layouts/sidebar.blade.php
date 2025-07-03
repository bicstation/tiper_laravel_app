{{-- resources/views/layouts/sidebar.blade.php --}}
<div class="space-y-2">
    {{-- ホームリンク --}}
    <a href="{{ url('/') }}" class="flex items-center px-4 py-2 rounded-md text-white hover:bg-gray-700 transition duration-150 ease-in-out {{ Request::is('/') ? 'bg-gray-700' : '' }}">
        <i class="fas fa-home w-5 h-5 mr-3"></i>ホーム
    </a>

    {{-- ダッシュボードカテゴリ (アコーディオン) --}}
    <div x-data="{ open: false }" class="rounded-md">
        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-left rounded-md text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out">
            <span class="flex items-center">
                <i class="fas fa-chart-line w-5 h-5 mr-3"></i>ダッシュボード
            </span>
            <svg class="h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-90': open }" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="pt-2 pl-6 space-y-1">
            <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-2 rounded-md text-sm text-gray-300 hover:bg-gray-700 transition duration-150 ease-in-out {{ Request::is('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                <i class="fas fa-th-large w-4 h-4 mr-2"></i>概要
            </a>
            <a href="{{ url('/profile') }}" class="flex items-center px-4 py-2 rounded-md text-sm text-gray-300 hover:bg-gray-700 transition duration-150 ease-in-out {{ Request::is('profile') ? 'bg-gray-700 text-white' : '' }}">
                <i class="fas fa-user-circle w-4 h-4 mr-2"></i>プロフィール設定
            </a>
            {{-- さらにサブカテゴリを追加するならここに記述 --}}
        </div>
    </div>

    {{-- レポートカテゴリ (アコーディオン) --}}
    <div x-data="{ open: false }" class="rounded-md">
        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-left rounded-md text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out">
            <span class="flex items-center">
                <i class="fas fa-chart-pie w-5 h-5 mr-3"></i>レポート
            </span>
            <svg class="h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-90': open }" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="pt-2 pl-6 space-y-1">
            <a href="#" class="flex items-center px-4 py-2 rounded-md text-sm text-gray-300 hover:bg-gray-700 transition duration-150 ease-in-out">
                <i class="fas fa-calendar-day w-4 h-4 mr-2"></i>日次レポート
            </a>
            <a href="#" class="flex items-center px-4 py-2 rounded-md text-sm text-gray-300 hover:bg-gray-700 transition duration-150 ease-in-out">
                <i class="fas fa-calendar-alt w-4 h-4 mr-2"></i>月次レポート
            </a>
        </div>
    </div>

    {{-- その他のリンク --}}
    <a href="{{ url('/contact') }}" class="flex items-center px-4 py-2 rounded-md text-white hover:bg-gray-700 transition duration-150 ease-in-out {{ Request::is('contact') ? 'bg-gray-700' : '' }}">
        <i class="fas fa-comments w-5 h-5 mr-3"></i>お問い合わせ
    </a>
    <a href="{{ url('/help') }}" class="flex items-center px-4 py-2 rounded-md text-white hover:bg-gray-700 transition duration-150 ease-in-out {{ Request::is('help') ? 'bg-gray-700' : '' }}">
        <i class="fas fa-info-circle w-5 h-5 mr-3"></i>ヘルプ
    </a>
</div>