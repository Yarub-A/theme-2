<?php
/**
 * أرشيف البرامج الأكاديمية
 */

get_header();
?>
<main id="primary" class="site-main container py-5">
    <header class="mb-4">
        <h1 class="h2 fw-bold"><?php post_type_archive_title(); ?></h1>
    </header>
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-4">
            <label for="filter-college" class="form-label"><?php esc_html_e( 'اختر الكلية', 'renita' ); ?></label>
            <?php
            wp_dropdown_categories( [
                'show_option_all' => __( 'جميع الكليات', 'renita' ),
                'taxonomy'       => 'department',
                'name'           => 'department',
                'selected'       => get_query_var( 'department' ),
                'class'          => 'form-select',
                'value_field'    => 'slug',
            ] );
            ?>
        </div>
        <div class="col-md-4">
            <label for="filter-type" class="form-label"><?php esc_html_e( 'نوع البرنامج', 'renita' ); ?></label>
            <?php
            wp_dropdown_categories( [
                'show_option_all' => __( 'جميع الأنواع', 'renita' ),
                'taxonomy'       => 'program-type',
                'name'           => 'program-type',
                'selected'       => get_query_var( 'program-type' ),
                'class'          => 'form-select',
                'value_field'    => 'slug',
            ] );
            ?>
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary w-100"><?php esc_html_e( 'تطبيق الفلاتر', 'renita' ); ?></button>
        </div>
    </form>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <div class="col">
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100' ); ?>>
                        <div class="card-body">
                            <h2 class="h5 card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="card-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
                        </div>
                    </article>
                </div>
                <?php
            endwhile;
        else :
            echo '<p>' . esc_html__( 'لا توجد برامج متاحة.', 'renita' ) . '</p>';
        endif; ?>
    </div>
    <?php the_posts_pagination(); ?>
</main>
<?php
get_footer();
