</div><footer class="bg-dark text-white py-4 mt-auto grid-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5><i class="fas fa-link me-2"></i>関連ドメイン</h5>
                    <ul class="list-unstyled">
                        <li><a href="http://tipers.live" class="text-white text-decoration-none"><i class="fas fa-globe me-2"></i>tiper.live (メインサイト)</a></li>
                        <li><a href="http://admin.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-user-cog me-2"></i>admin.tiper.live (管理パネル)</a></li>
                        <li><a href="http://dti.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>dti.tipers.live (DTI環境)</a></li>
                        <li><a href="http://duga.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>duga.tipers.live (DUGA環境)</a></li>
                        <li><a href="http://fanza.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>fanza.tipers.live (FANZA環境)</a></li>
                        <li><a href="http://dmm.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>dmm.tipers.live (DMM.com環境)</a></li>
                        <li><a href="http://okashi.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>okashi.tipers.live (お菓子環境)</a></li>
                        <li><a href="http://lemon.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>lemon.tipers.live (レモン環境)</a></li>
                        <li><a href="http://b10f.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>b10f.tipers.live (地下10階環境)</a></li>
                        <li><a href="http://sokmil.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>sokmil.tipers.live (ソクミル環境)</a></li>
                        <li><a href="http://mgs.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-film me-2"></i>mgs.tiper.live (MGS環境)</a></li>
                        <li><a href="http://blog.tipers.live/" class="text-white text-decoration-none"><i class="fas fa-blog me-2"></i>blog.tiper.live (ブログ)</a></li>
                        <li><a href="https://162.43.71.24:8080/" class="text-white text-decoration-none"><i class="fas fa-database me-2"></i>phpMyAdmin (開発用)</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5><i class="fas fa-info-circle me-2"></i>一般リンク</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo esc_url( home_url( '/sitemap' ) ); ?>" class="text-white text-decoration-none"><i class="fas fa-sitemap me-2"></i>サイトマップ</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" class="text-white text-decoration-none"><i class="fas fa-shield-alt me-2"></i>プライバシーポリシー</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/terms-of-service' ) ); ?>" class="text-white text-decoration-none"><i class="fas fa-file-contract me-2"></i>利用規約</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/company' ) ); ?>" class="text-white text-decoration-none"><i class="fas fa-users me-2"></i>会社概要</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/rss' ) ); ?>" class="text-white text-decoration-none"><i class="fas fa-rss-square me-2"></i>RSS</a></li>
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
                <p class="mb-0">&copy; <?php echo date_i18n( 'Y' ); ?> Tiper Live. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <div class="offcanvas offcanvas-start bg-dark text-white d-md-none" tabindex="-1" id="myCustomSidebar" aria-labelledby="myCustomSidebarLabel">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title" id="myCustomSidebarLabel">サイドメニュー</h5>
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-0">
            <div class="accordion accordion-flush w-100" id="sidebarAccordionMobile">
                <ul class="list-unstyled mb-0">
                    <li>
                        <a class="nav-link text-white py-2" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <i class="fas fa-home me-2"></i>ホーム
                        </a>
                    </li>
                    <li>
                        <a class="nav-link text-white py-2" href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>ダッシュボード
                        </a>
                    </li>
                </ul>

                <div class="accordion-item bg-dark">
                    <h2 class="accordion-header" id="headingMobileCategory1">
                        <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileCategory1" aria-expanded="true" aria-controls="collapseMobileCategory1">
                            <i class="fas fa-folder me-2"></i>カテゴリ 1
                        </button>
                    </h2>
                    <div id="collapseMobileCategory1" class="accordion-collapse collapse show" aria-labelledby="headingMobileCategory1" data-bs-parent="#sidebarAccordionMobile">
                        <div class="accordion-body bg-dark">
                            <ul class="list-unstyled mb-0">
                                <li><a class="nav-link text-white py-2" href="#">サブメニュー 1-1</a></li>
                                <li><a class="nav-link text-white py-2" href="#">サブメニュー 1-2</a></li>
                                <li><a class="nav-link text-white py-2" href="#">サブメニュー 1-3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item bg-dark">
                    <h2 class="accordion-header" id="headingMobileCategory2">
                        <button class="accordion-button bg-dark text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileCategory2" aria-expanded="false" aria-controls="collapseMobileCategory2">
                            <i class="fas fa-folder me-2"></i>カテゴリ 2
                        </button>
                    </h2>
                    <div id="collapseMobileCategory2" class="accordion-collapse collapse" aria-labelledby="headingMobileCategory2" data-bs-parent="#sidebarAccordionMobile">
                        <div class="accordion-body bg-dark">
                            <ul class="list-unstyled mb-0">
                                <li><a class="nav-link text-white py-2" href="#">データ分析</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item bg-dark">
                    <h2 class="accordion-header" id="headingMobileAuth">
                        <button class="accordion-button bg-dark text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobileAuth" aria-expanded="false" aria-controls="collapseMobileAuth">
                            <i class="fas fa-lock me-2"></i>認証
                        </button>
                    </h2>
                    <div id="collapseMobileAuth" class="accordion-collapse collapse" aria-labelledby="headingMobileAuth" data-bs-parent="#sidebarAccordionMobile">
                        <div class="accordion-body bg-dark">
                            <ul class="list-unstyled mb-0">
                                <?php if ( ! is_user_logged_in() ) : ?>
                                    <li><a class="nav-link text-white py-2" href="<?php echo esc_url( wp_login_url() ); ?>"><i class="fas fa-sign-in-alt me-2"></i>ログイン</a></li>
                                <?php else : ?>
                                    <li><a class="nav-link text-white py-2" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><i class="fas fa-sign-out-alt me-2"></i>ログアウト</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); // ここでfunctions.phpでキューイングしたJSが読み込まれます ?>
</body>
</html>