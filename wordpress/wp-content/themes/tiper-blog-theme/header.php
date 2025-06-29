<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?> <!-- functions.phpで登録したスタイルやスクリプトがここに出力される -->
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header id="site-header">
        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary', // メニュー位置を定義
                'container_class' => 'main-menu',
            ) );
            ?>
        </nav>
    </header>

    <div id="content" class="site-content">