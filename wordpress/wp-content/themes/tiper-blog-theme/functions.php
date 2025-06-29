<?php
/**
 * Tiper Blog Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if ( ! function_exists( 'tiper_blog_theme_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function tiper_blog_theme_setup() {
        // テーマの基本的な設定（後で追加可能）
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    }
endif;
add_action( 'after_setup_theme', 'tiper_blog_theme_setup' );

/**
 * Enqueue scripts and styles.
 * Laravelアプリケーションのアセットを読み込むための設定
 */
function tiper_blog_theme_scripts() {
    // ----------------------------------------------------
    // 1. Bootstrap CSS (Laravelのapp.blade.phpでCDNから読み込んでいるものと同じものをWordPressからも読み込む)
    // LaravelがBootstrapをCDNで読み込んでいる場合、WordPressテーマでもCDNから読み込むのが最もシンプルです。
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );

    // ----------------------------------------------------
    // 2. LaravelのカスタムCSS (public/css/style_v2.css) を読み込む
    // Laravelが tipers.live ドメインで提供しているパスを直接指定します。
    // 必ず hosts ファイルで tipers.live が 127.0.0.1 を指していることを確認してください。
    wp_enqueue_style( 'laravel-custom-style', 'http://tipers.live/css/style_v2.css', array('bootstrap-css'), null );

    // ----------------------------------------------------
    // 3. LaravelのViteでビルドされたCSSアセットを読み込む
    // Viteはビルドごとにファイル名にハッシュを追加するため、manifest.jsonから正確なパスを取得する必要があります。
    // これは少し複雑ですが、最も堅牢な方法です。
    $manifest_path = ABSPATH . '../public/build/manifest.json'; // Laravelのpublicディレクトリにあるmanifest.jsonへのパス
    // WordPressコンテナから見たパスを考慮する必要があります
    // Nginxは /var/www/wordpress からWordPressファイルを提供し、
    // Laravelのpublicは /var/www/html/public にマウントされています。
    // WordPressコンテナから直接 public/build/manifest.json にアクセスすることはできません。
    // 代わりに、tipers.live ドメイン経由でアクセスします。
    // PHPで外部URLを読み込むため、WordPressコンテナで allow_url_fopen が有効になっている必要があります。
    // これが難しい場合は、直接ファイル名を指定するか、Laravel側でmanifest.jsonを公開APIとして提供する必要があります。

    // シンプルな方法（開発用）: 直接パスを指定する（ハッシュが変わると手動更新が必要）
    // wp_enqueue_style( 'laravel-app-css', 'http://tipers.live/build/assets/app-BhcmQXf2.css', array(), null ); // 例

    // より堅牢な方法: manifest.jsonを外部から読み込む（複雑）
    // fetch_asset_from_laravel_manifest() のようなカスタム関数を実装し、
    // その中で http://tipers.live/build/manifest.json を読み込むロジックが必要です。
    // 今回は簡単にするため、直接パス指定か、Laravelが提供するAPIエンドポイントを想定します。
    // まずは手動で確認できるパスを仮定して進めましょう。
    wp_enqueue_style( 'laravel-vite-app-css', 'http://tipers.live/build/assets/app-BhcmQXf2.css', array('laravel-custom-style'), null ); // Laravelのapp.cssビルド済み版
    
    // ----------------------------------------------------
    // 4. Bootstrap JavaScript (Laravelのapp.blade.phpでCDNから読み込んでいるものと同じものをWordPressからも読み込む)
    wp_enqueue_script( 'bootstrap-bundle-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.3', true );

    // ----------------------------------------------------
    // 5. LaravelのViteでビルドされたJavaScriptアセットを読み込む
    // wp_enqueue_script( 'laravel-vite-app-js', 'http://tipers.live/build/assets/app-ak4YfpFF.js', array('bootstrap-bundle-js'), null, true ); // Laravelのapp.jsビルド済み版
}
add_action( 'wp_enqueue_scripts', 'tiper_blog_theme_scripts' );