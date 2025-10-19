<?php
/**
 * نتائج البحث
 */

get_header();
?>
<main id="primary" class="site-main container py-5">
    <header class="mb-4">
        <h1 class="h3 fw-bold"><?php printf( esc_html__( 'نتائج البحث عن: %s', 'renita' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </header>
    <?php if ( have_posts() ) : ?>
        <div class="list-group">
            <?php while ( have_posts() ) : the_post(); ?>
                <a class="list-group-item list-group-item-action" href="<?php the_permalink(); ?>">
                    <h2 class="h5 mb-1"><?php the_title(); ?></h2>
                    <p class="mb-0 text-muted"><?php echo esc_html( get_the_excerpt() ); ?></p>
                </a>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'لم يتم العثور على نتائج.', 'renita' ); ?></p>
    <?php endif; ?>
</main>
<?php
get_footer();
