 </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="site-info">
            <?php printf( __( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'tiper-blog-theme' ), date_i18n( 'Y' ), get_bloginfo( 'name' ) ); ?>
        </div>
    </footer>

    <?php wp_footer(); ?> <!-- functions.phpで登録したスクリプト（下部に配置されるもの）がここに出力される -->
</body>
</html>
