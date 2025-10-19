<?php
/**
 * القالب الافتراضي العام
 */

get_header();
?>
<main id="primary" class="site-main container py-5">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
                <header class="mb-3">
                    <h1 class="h3 fw-bold"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'لا يوجد محتوى للعرض حالياً.', 'renita' ); ?></p>
    <?php endif; ?>
</main>
<?php get_footer();
