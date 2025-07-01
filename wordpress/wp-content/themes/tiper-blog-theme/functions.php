<?php
/**
 * Tiper Blog Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tiper_Blog_Theme
 */

if ( ! function_exists( 'tiper_blog_theme_setup' ) ) :
    function tiper_blog_theme_setup() {
        load_theme_textdomain( 'tiper-blog-theme', get_template_directory() . '/languages' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );

        register_nav_menus( array(
            'primary' => esc_html__( 'Primary menu', 'tiper-blog-theme' ),
            'sidebar-desktop' => esc_html__( 'Desktop Sidebar', 'tiper-blog-theme' ),
            'sidebar-mobile' => esc_html__( 'Mobile Sidebar', 'tiper-blog-theme' ),
            'footer-related' => esc_html__( 'Footer Related Domains', 'tiper-blog-theme' ),
            'footer-general' => esc_html__( 'Footer General Links', 'tiper-blog-theme' ),
        ) );

        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        ) );

        add_theme_support( 'customize-selective-refresh-widgets' );
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
    }
endif;
add_action( 'after_setup_theme', 'tiper_blog_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function tiper_blog_theme_scripts() {
    // Font Awesome (CDN)
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3' );

    // Bootstrap CSS (CDN)
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3', 'all' );

    // Theme stylesheet (style.css - 必ず読み込まれるもの)
    wp_enqueue_style( 'tiper-blog-theme-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Bootstrap JS (CDN) - フッターで読み込む
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.3', true );

    // カスタムJavaScript（offcanvasの挙動など）
    $custom_js = "
        document.addEventListener('DOMContentLoaded', function() {
            const myCustomSidebar = document.getElementById('myCustomSidebar');
            const mainContentWrapper = document.getElementById('main-content-wrapper');
            const body = document.body; // body要素を取得

            if (myCustomSidebar && mainContentWrapper) {
                // オフキャンバスが開いた時
                myCustomSidebar.addEventListener('show.bs.offcanvas', function () {
                    body.classList.add('offcanvas-active'); // bodyにクラスを追加
                    if (window.innerWidth >= 768) { // デスクトップサイズの場合
                        mainContentWrapper.style.marginLeft = '280px';
                        mainContentWrapper.style.width = 'calc(100% - 280px)'; // 幅も調整
                    } else { // モバイルサイズの場合
                        // メインコンテンツを隠すか、適切に移動させるためのクラスを追加
                        body.classList.add('showing-offcanvas');
                    }
                });

                // オフキャンバスが閉じた時
                myCustomSidebar.addEventListener('hide.bs.offcanvas', function () {
                    body.classList.remove('offcanvas-active'); // bodyからクラスを削除
                    if (window.innerWidth >= 768) { // デスクトップサイズの場合
                        mainContentWrapper.style.marginLeft = '0';
                        mainContentWrapper.style.width = '100%';
                    } else { // モバイルサイズの場合
                        body.classList.remove('showing-offcanvas');
                    }
                });

                // ウィンドウサイズ変更時
                window.addEventListener('resize', function() {
                    // 現在オフキャンバスが開いているか確認
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(myCustomSidebar);

                    if (window.innerWidth < 768) {
                        // モバイルサイズになったらデスクトップ用のスタイルをリセット
                        mainContentWrapper.style.marginLeft = '0';
                        mainContentWrapper.style.width = '100%';
                        if (bsOffcanvas && bsOffcanvas._isShown) {
                             body.classList.add('showing-offcanvas'); // モバイルで開いていればクラスを追加
                        }
                    } else {
                        // デスクトップサイズになったらモバイル用のスタイルをリセット
                        body.classList.remove('showing-offcanvas');
                        if (bsOffcanvas && bsOffcanvas._isShown) {
                            mainContentWrapper.style.marginLeft = '280px';
                            mainContentWrapper.style.width = 'calc(100% - 280px)';
                        } else {
                            mainContentWrapper.style.marginLeft = '0';
                            mainContentWrapper.style.width = '100%';
                        }
                    }
                });
            }
        });
    ";
    wp_add_inline_script( 'bootstrap-js', $custom_js, 'after' ); // Bootstrap JSの後に読み込む
}
add_action( 'wp_enqueue_scripts', 'tiper_blog_theme_scripts' );

/**
 * Custom function to get theme image path.
 */
function tiper_blog_theme_img_path( $image_name ) {
    return get_template_directory_uri() . '/img/' . $image_name;
}

// WordPress Admin Bar のための調整CSSをwp_add_inline_styleで追加
function tiper_blog_theme_admin_bar_css() {
    $custom_css = "
        body.admin-bar .navbar {
            top: var(--wp-admin--admin-bar--height, 32px) !important;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .navbar {
                top: var(--wp-admin--admin-bar--height, 46px) !important;
            }
        }
        /* 管理バーが表示されているときのオフキャンバスの位置調整 */
        body.admin-bar .offcanvas {
            top: var(--wp-admin--admin-bar--height, 0px) !important; /* 管理バーの高さ分ずらす */
            height: calc(100vh - var(--wp-admin--admin-bar--height, 0px)) !important; /* 高さも調整 */
        }
        /* #main-content-area の margin-top は削除します */
        /* コンテンツがナビゲーションバーのすぐ下から始まるように */
        /*
        #main-content-area {
            margin-top: 56px;
        }
        body.admin-bar #main-content-area {
            margin-top: calc(56px + var(--wp-admin--admin-bar--height, 32px));
        }
        @media screen and (max-width: 782px) {
            body.admin-bar #main-content-area {
                margin-top: calc(56px + var(--wp-admin--admin-bar--height, 46px));
            }
        }
        */
    ";
    wp_add_inline_style( 'bootstrap-css', $custom_css ); // Bootstrap CSSの後に読み込む
}
add_action( 'wp_enqueue_scripts', 'tiper_blog_theme_admin_bar_css' );

// カスタムスタイルをwp_add_inline_styleで読み込む
function tiper_blog_theme_custom_styles() {
    $custom_styles = "
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #main-content-area {
            display: flex;
            flex-grow: 1;
            width: 100%;
        }
        aside.d-md-block {
            flex-shrink: 0;
            width: 280px;
            height: 100%;
            overflow-y: auto;
        }
        #main-content-wrapper {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            /* widthはJSで調整されるため、ここではデフォルトの100%または可変幅を設定 */
            width: 100%; /* デスクトップではJSでcalc(100% - 280px)に上書きされる */
            overflow-x: hidden;
        }
        /* モバイル表示時、サイドバーがない場合はメインコンテンツが全幅になるように調整 */
        @media (max-width: 767.98px) {
            #main-content-wrapper {
                width: 100%;
            }
        }
        /* オフキャンバスが開いているときのメインコンテンツの挙動 */
        .showing-offcanvas #main-content-wrapper {
            transform: translateX(280px); /* オフキャンバスの幅分右にずらす */
            transition: transform 0.3s ease-in-out; /* スムーズなアニメーション */
        }
        /* オフキャンバスが閉じているときのメインコンテンツの挙動 (元に戻す) */
        /* transitionプロパティは常に付与しておくことで、スムーズな開閉が可能 */
        #main-content-wrapper {
            transform: translateX(0);
            transition: transform 0.3s ease-in-out;
        }
        main {
            flex-grow: 1;
            overflow-y: auto;
        }
        /* サイドバーの背景色をカスタマイズ（ダークモードに合わせる） */
        .offcanvas.bg-dark, aside.bg-dark {
            background-color: #343a40 !important;
        }
        /* アコーディオンのヘッダーとボディのテキスト色を調整 */
        .accordion-button.bg-dark,
        .accordion-body .list-unstyled a {
            color: white;
        }
        /* アクティブなリンクのスタイル */
        .nav-link.active, .accordion-button:not(.collapsed) {
            color: #fff;
            background-color: #0d6efd;
            border-radius: 0.25rem;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        /* メインナビが常に表示されるように調整 (Bootstrapのデフォルト動作で非表示になるのを防ぐため) */
        /* d-md-none と連携してデスクトップで表示、モバイルで非表示にする */
        .navbar-collapse.collapse:not(.d-md-none) {
            display: block !important;
        }
        .navbar-toggler:not(.d-md-none) {
            display: none !important;
        }
        @media (max-width: 767.98px) { /* md未満の画面サイズ */
            .navbar-collapse.collapse:not(.d-md-none) {
                display: none !important;
            }
            .navbar-toggler:not(.d-md-none) {
                display: block !important;
            }
            aside.d-md-block {
                display: none !important;
            }
        }
        /* オフキャンバスが開いているときにbodyのスクロールを無効化 */
        body.offcanvas-active {
            overflow: hidden;
        }
    ";
    wp_add_inline_style( 'bootstrap-css', $custom_styles ); // Bootstrap CSSの後に読み込む
}
add_action( 'wp_enqueue_scripts', 'tiper_blog_theme_custom_styles' );