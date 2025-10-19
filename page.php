<?php
/**
 * قالب الصفحات العامة
 */

get_header();
?>
<main id="primary" class="site-main container py-5">
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
                <header class="mb-4">
                    <h1 class="h2 fw-bold"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        }
    }
    ?>
</main>
<?php
get_footer();
