<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

get_header(); // header.php を読み込む
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <h1>Welcome to my WordPress Blog!</h1>
        <p>This is the custom theme content.</p>

        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            _e( 'No posts found.', 'tiper-blog-theme' );
        endif;
        ?>
    </main>
</div>

<?php
get_footer(); // footer.php を読み込む
?>

