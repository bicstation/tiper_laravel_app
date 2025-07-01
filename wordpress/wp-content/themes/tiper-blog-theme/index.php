<?php
get_header(); // header.php が <div id="main-content-area"> を開きます。
?>

    <aside class="bg-dark text-white d-none d-md-block">
        <div class="p-3 border-bottom border-secondary">
            <h5 class="text-white">サイドメニュー</h5>
        </div>
        <div class="accordion accordion-flush w-100" id="sidebarAccordionDesktop">
            <ul class="list-unstyled mb-0">
                <li>
                    <a class="nav-link text-white py-2 " href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <i class="fas fa-home me-2"></i>ホーム
                    </a>
                </li>
                <li>
                    <a class="nav-link text-white py-2 " href="<?php echo esc_url( home_url( '/dashboard' ) ); // 仮のWordPressパス ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>ダッシュボード
                    </a>
                </li>
            </ul>

            <div class="accordion-item bg-dark">
                <h2 class="accordion-header" id="headingCategory1">
                    <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory1" aria-expanded="true" aria-controls="collapseCategory1">
                        <i class="fas fa-folder me-2"></i>カテゴリ 1
                    </button>
                </h2>
                <div id="collapseCategory1" class="accordion-collapse collapse show" aria-labelledby="headingCategory1" data-bs-parent="#sidebarAccordionDesktop">
                    <div class="accordion-body bg-dark">
                        <ul class="list-unstyled mb-0">
                            <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-1</a></li>
                            <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-2</a></li>
                            <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-file-alt me-2"></i>サブメニュー 1-3</a></li>
                            <li><a class="nav-link text-white py-2" href="<?php echo esc_url( wp_registration_url() ); ?>"><i class="fas fa-user-plus me-2"></i>ユーザー登録</a></li>
                            <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-cube me-2"></i>商品登録</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item bg-dark">
                <h2 class="accordion-header" id="headingCategory2">
                    <button class="accordion-button bg-dark text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory2" aria-expanded="false" aria-controls="collapseCategory2">
                        <i class="fas fa-folder me-2"></i>カテゴリ 2
                    </button>
                </h2>
                <div id="collapseCategory2" class="accordion-collapse collapse" aria-labelledby="headingCategory2" data-bs-parent="#sidebarAccordionDesktop">
                    <div class="accordion-body bg-dark">
                        <ul class="list-unstyled mb-0">
                            <li><a class="nav-link text-white py-2" href="#"><i class="fas fa-chart-bar me-2"></i>データ分析</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item bg-dark">
                <h2 class="accordion-header" id="headingAuth">
                    <button class="accordion-button bg-dark text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuth" aria-expanded="false" aria-controls="collapseAuth">
                        <i class="fas fa-lock me-2"></i>認証
                    </button>
                </h2>
                <div id="collapseAuth" class="accordion-collapse collapse" aria-labelledby="headingAuth" data-bs-parent="#sidebarAccordionDesktop">
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
    </aside>

    <div id="main-content-wrapper">
        <main class="p-3">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    ?>
                    <div class="container-fluid bg-white p-4 rounded shadow-sm mt-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                                <li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home me-1"></i>ホーム</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-file me-1"></i><?php the_title(); ?>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="mb-4"><i class="fas fa-clipboard-list me-2"></i><?php the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-info-circle me-2"></i>コンテンツブロック 1</h5>
                                        <p class="card-text">ここにブロック1の詳細な説明が入ります。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-lightbulb me-2"></i>コンテンツブロック 2</h5>
                                        <p class="card-text">ここにブロック2の詳細な説明が入ります。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-images me-2"></i>ギャラリー</h5>
                                        <div class="row">
                                            <div class="col-md-4 mb-2"><img src="<?php echo tiper_blog_theme_img_path( 'photos/download.png' ); ?>" class="img-fluid rounded" alt="Placeholder Image"></div>
                                            <div class="col-md-4 mb-2"><img src="<?php echo tiper_blog_theme_img_path( 'photos/download.png' ); ?>" class="img-fluid rounded" alt="Placeholder Image"></div>
                                            <div class="col-md-4 mb-2"><img src="<?php echo tiper_blog_theme_img_path( 'photos/download.png' ); ?>" class="img-fluid rounded" alt="Placeholder Image"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
            else :
                ?>
                <p>表示する投稿がありません。</p>
                <?php
            endif;
            ?>
        </main>
    </div>

<?php
get_footer(); // footer.php が <div id="main-content-area"> を閉じます。
?>