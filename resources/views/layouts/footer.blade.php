{{-- resources/views/layouts/footer.blade.php --}}

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-gray-300">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-4 border-b border-gray-700">
        {{-- 列 1: 会社情報 --}}
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-building mr-2 text-blue-400"></i>Tiper.Live
            </h3>
            <p class="text-sm leading-relaxed mb-2">
                お客様のビジネス成長をサポートする革新的なサービスを提供しています。
            </p>
            <p class="text-sm">
                〒123-4567 東京都千代田区〇〇 1-2-3
            </p>
            <p class="text-sm">
                電話: 03-XXXX-XXXX
            </p>
        </div>

        {{-- 列 2: クイックリンク --}}
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-link mr-2 text-blue-400"></i>クイックリンク
            </h3>
            <ul class="space-y-2">
                <li><a href="{{ url('/about') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>会社概要</a></li>
                <li><a href="{{ url('/services') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>サービス</a></li>
                <li><a href="{{ url('/news') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>ニュース</a></li>
                <li><a href="{{ url('/faq') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>よくある質問</a></li>
            </ul>
        </div>

        {{-- 列 3: 法的情報とソーシャルメディア --}}
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-gavel mr-2 text-blue-400"></i>その他
            </h3>
            <ul class="space-y-2 mb-4">
                <li><a href="{{ url('/terms') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>利用規約</a></li>
                <li><a href="{{ url('/privacy') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>プライバシーポリシー</a></li>
                <li><a href="{{ url('/contact') }}" class="hover:text-white transition duration-150 ease-in-out text-sm"><i class="fas fa-angle-right mr-2"></i>お問い合わせ</a></li>
            </ul>
            <div class="flex space-x-4 mt-4">
                <a href="#" class="text-gray-400 hover:text-white transition duration-150 ease-in-out"><i class="fab fa-twitter text-xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-150 ease-in-out"><i class="fab fa-facebook-f text-xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-150 ease-in-out"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-150 ease-in-out"><i class="fab fa-instagram text-xl"></i></a>
            </div>
        </div>
    </div>

    <div class="text-center py-4 text-sm text-gray-400">
        &copy; {{ date('Y') }} Tiper.Live All rights reserved.
    </div>
</div>