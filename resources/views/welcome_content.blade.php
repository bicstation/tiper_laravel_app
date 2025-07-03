{{-- resources/views/welcome_content.blade.php --}}

{{-- layouts/app.blade.php を親レイアウトとして指定 --}}
@extends('layouts.app')

{{-- app.blade.php の $slot に挿入するコンテンツを定義 --}}
@section('content') {{-- あるいは @section('main_content') など、カスタムセクション名を使用することも可能 --}}

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- あなたのウェルカムページの内容 --}}
                <h1 class="text-3xl font-bold mb-4">ようこそ Tiper.Live へ！</h1>
                <p class="mb-4">このページは、あなたのウェブサイトのランディングページです。</p>
                <p>Tailwind CSSへの移行作業を続けていきましょう。</p>

                {{-- 以前のBootstrapコンテンツの一部がここにあった場合は、Tailwind CSSに変換してください --}}
                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h2 class="text-xl font-semibold text-blue-800 mb-2">現在の進捗</h2>
                    <ul class="list-disc list-inside text-blue-700">
                        <li>ナビゲーション (layouts/navi.blade.php) : Tailwind CSSに変換済み</li>
                        <li>メインレイアウト (layouts/app.blade.php) : Tailwind CSSに変換済み</li>
                        <li>サイドバー (layouts/sidebar.blade.php) : Tailwind CSSに変換済み</li>
                        <li>フッター (layouts/footer.blade.php) : Tailwind CSSに変換済み</li>
                    </ul>
                    <p class="mt-4 text-blue-700">残りのメインコンテンツの変換に進みましょう！</p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection