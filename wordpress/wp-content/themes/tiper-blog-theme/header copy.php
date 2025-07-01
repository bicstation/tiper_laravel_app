<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <link rel="icon" href="<?php echo tiper_blog_theme_img_path( 'logo.webp' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'font-sans antialiased' ); ?>>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">Tiper.Live</a>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#myCustomSidebar" aria-controls="myCustomSidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav"> <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if ( is_user_logged_in() ) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( admin_url() ); ?>">管理画面</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">ログアウト</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( wp_login_url() ); ?>">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( wp_registration_url() ); ?>">登録</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="main-content-area">