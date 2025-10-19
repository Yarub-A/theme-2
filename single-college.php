<?php
/**
 * عرض الكليات
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
                <div class="entry-content mb-4">
                    <?php the_content(); ?>
                </div>
                <?php
                $departments = wp_get_post_terms( get_the_ID(), 'department' );
                if ( ! empty( $departments ) && ! is_wp_error( $departments ) ) :
                    ?>
                    <section class="college-departments">
                        <h2 class="h4 mb-3"><?php esc_html_e( 'الأقسام الأكاديمية', 'renita' ); ?></h2>
                        <ul class="list-group list-group-flush">
                            <?php foreach ( $departments as $department ) : ?>
                                <li class="list-group-item">
                                    <a href="<?php echo esc_url( get_term_link( $department ) ); ?>"><?php echo esc_html( $department->name ); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>
            </article>
            <?php
        }
    }
    ?>
</main>
<?php
get_footer();
