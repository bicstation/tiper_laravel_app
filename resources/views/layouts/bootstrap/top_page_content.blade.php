{{-- resources/views/top_page_content.blade.php --}}

{{-- layouts/app.blade.php を継承する --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tiper.Live トップページ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- ここにあなたのトップページの具体的なコンテンツを記述します --}}
                    <h1>Tiper.Liveへようこそ！</h1>
                    <p>これは私の自作コンテンツです。</p>
                    <p>Filament、Breezeの導入後もメインサイトを表示できるようになりました。</p>
                    {{-- 必要に応じて、ここに自作のHTMLやBladeコードを追加してください --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>