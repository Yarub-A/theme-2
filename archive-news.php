<?php
/**
 * أرشيف الأخبار
 */

get_header();
?>
<main id="primary" class="site-main container py-5">
    <header class="mb-4">
        <h1 class="h2 fw-bold"><?php post_type_archive_title(); ?></h1>
    </header>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <div class="col">
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium_large', [ 'class' => 'card-img-top', 'loading' => 'lazy' ] ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h2 class="h5 card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="card-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
                        </div>
                        <div class="card-footer text-muted">
                            <?php echo esc_html( get_the_date() ); ?>
                        </div>
                    </article>
                </div>
                <?php
            endwhile;
        else :
            echo '<p>' . esc_html__( 'لا توجد أخبار متاحة حالياً.', 'renita' ) . '</p>';
        endif; ?>
    </div>
    <?php the_posts_pagination(); ?>
</main>
<?php
get_footer();
