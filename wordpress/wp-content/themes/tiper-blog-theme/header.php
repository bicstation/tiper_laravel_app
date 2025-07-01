<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <link rel="icon" href="<?php echo tiper_blog_theme_img_path( 'logo.webp' ); ?>">
    <?php wp_head(); // ここでfunctions.phpでキューイングしたCSS/JSが読み込まれます ?>
</head>
<body <?php body_class( 'font-sans antialiased' ); ?>>
    <?php wp_body_open(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top w-100">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-md-flex align-items-center" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo tiper_blog_theme_img_path( 'logo.webp' ); ?>" alt="Tiper.Live Logo" height="30" class="me-2">
            <span class="fw-bold">Tiper.Live</span>
        </a>
        <a class="navbar-brand d-md-none" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo tiper_blog_theme_img_path( 'logo.webp' ); ?>" alt="Tiper.Live Logo" height="30">
        </a>

        <button class="btn btn-primary d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarCollapse" aria-controls="mainNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home me-1"></i>ホーム</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs me-1"></i>サービス
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-wrench me-2"></i>サービスA</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-tools me-2"></i>サービスB</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-code me-2"></i>サービスC</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-box me-1"></i>製品</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-question-circle me-1"></i>よくある質問</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-envelope me-1"></i>お問い合わせ</a>
                </li>
            </ul>

            <form class="d-flex d-md-none mt-2 w-100" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                <div class="input-group">
                    <input class="form-control form-control-sm" type="search" placeholder="サイト内検索..." aria-label="Search" name="s" value="<?php echo get_search_query(); ?>">
                    <button class="btn btn-outline-light btn-sm" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <form class="d-none d-md-inline-flex me-2 order-md-1" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="検索..." aria-label="検索" name="s" value="<?php echo get_search_query(); ?>">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( admin_url() ); ?>" class="btn btn-outline-light me-2 order-md-2">管理画面</a>
                <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="btn btn-primary order-md-3">ログアウト</a>
            <?php else : ?>
                <a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-outline-light me-2 order-md-2">ログイン</a>
                <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="btn btn-primary order-md-3">登録</a>
            <?php endif; ?>
        </div>
        </div>
</nav>
    <div id="main-content-area">