{{-- resources/views/layouts/footer.blade.php --}}

<footer class="bg-dark text-white py-4 mt-auto grid-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <h5><i class="fas fa-link me-2"></i>関連ドメイン</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-white text-decoration-none"><i class="fas fa-globe me-2"></i>tiper.live (メインサイト)</a></li>
                    <li><a href="http://blog.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-blog me-2"></i>blog.tiper.live (ブログ)</a></li>
                    {{-- ★★★ ここにFilamentダッシュボードへのリンクを追加 (ログイン時のみ表示) ★★★ --}}
                    @auth
                                        <li><a href="http://tipers.live:8081/" class="text-white text-decoration-none"><i class="fas fa-database me-2"></i>phpMyAdmin (開発用)</a></li>
                        <li><a href="{{ env('FILAMENT_ADMIN_URL') }}" class="text-white text-decoration-none"><i class="fas fa-tachometer-alt me-2"></i>Filamentダッシュボード</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5><i class="fas fa-info-circle me-2"></i>一般リンク</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/sitemap') }}" class="text-white text-decoration-none"><i class="fas fa-sitemap me-2"></i>サイトマップ</a></li>
                    <li><a href="{{ url('/privacy-policy') }}" class="text-white text-decoration-none"><i class="fas fa-shield-alt me-2"></i>プライバシーポリシー</a></li>
                    <li><a href="{{ url('/terms-of-service') }}" class="text-white text-decoration-none"><i class="fas fa-file-contract me-2"></i>利用規約</a></li>
                    <li><a href="{{ url('/company') }}" class="text-white text-decoration-none"><i class="fas fa-users me-2"></i>会社概要</a></li>
                    <li><a href="{{ url('/rss') }}" class="text-white text-decoration-none"><i class="fas fa-rss-square me-2"></i>RSS</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5><i class="fas fa-map-marker-alt me-2"></i>お問い合わせ</h5>
                <address class="mb-0">
                    〒306-0615 茨城県坂東市<br>
                    <i class="fas fa-phone-alt me-2"></i>XXX-XXX-XXXX<br> 
                    <i class="fas fa-envelope me-2"></i><a href="mailto:info@example.com" class="text-white text-decoration-none">info@example.com</a> 
                </address>
                <div class="mt-3">
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter-square fa-2x"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-square fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram-square fa-2x"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-3 border-secondary">
        <div class="text-center">
            <p class="mb-0">&copy; 2025 Tiper Live. All rights reserved.</p>
        </div>
    </div>
</footer>