<?php
/**
 * تسجيل البلوكات الديناميكية الخاصة بالقالب
 */

add_action( 'init', function () {
    register_block_type( 'renita/news-grid', [
        'render_callback' => 'renita_render_news_grid',
        'attributes'      => [
            'postsToShow' => [ 'type' => 'number', 'default' => 6 ],
        ],
        'title'           => __( 'شبكة الأخبار', 'renita' ),
        'description'     => __( 'يعرض آخر الأخبار في شبكة بطاقات.', 'renita' ),
        'category'        => 'widgets',
        'icon'            => 'grid-view',
    ] );

    register_block_type( 'renita/stats-strip', [
        'render_callback' => 'renita_render_stats_strip',
        'attributes'      => [
            'items' => [
                'type'    => 'array',
                'default' => [
                    [ 'value' => '+25K', 'label' => __( 'طلاب', 'renita' ) ],
                    [ 'value' => '+120', 'label' => __( 'برامج', 'renita' ) ],
                    [ 'value' => '+60', 'label' => __( 'شركاء', 'renita' ) ],
                    [ 'value' => '12', 'label' => __( 'كليات', 'renita' ) ],
                ],
                'items'   => [ 'type' => 'object' ],
            ],
        ],
        'title'           => __( 'شريط الإحصاءات', 'renita' ),
        'description'     => __( 'شريط يعرض إحصاءات رئيسة للجامعة.', 'renita' ),
        'category'        => 'widgets',
        'icon'            => 'chart-pie',
    ] );

    register_block_type( 'renita/quick-links', [
        'render_callback' => 'renita_render_quick_links',
        'attributes'      => [
            'links' => [ 'type' => 'array', 'default' => [] ],
        ],
        'title'           => __( 'روابط سريعة', 'renita' ),
        'description'     => __( 'قائمة أزرار لأهم الروابط.', 'renita' ),
        'category'        => 'widgets',
        'icon'            => 'admin-links',
    ] );
} );

function renita_render_news_grid( $attributes ): string {
    $count = isset( $attributes['postsToShow'] ) ? (int) $attributes['postsToShow'] : 6;
    $query = new WP_Query( [
        'post_type'      => 'news',
        'posts_per_page' => $count,
        'no_found_rows'  => true,
    ] );

    ob_start();
    if ( $query->have_posts() ) :
        ?>
        <div class="row row-cols-1 row-cols-md-3 g-4 renita-news-grid">
            <?php
            while ( $query->have_posts() ) :
                $query->the_post();
                ?>
                <div class="col">
                    <article class="card h-100">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="card-img-top-link">
                                <?php the_post_thumbnail( 'medium_large', [ 'class' => 'card-img-top', 'loading' => 'lazy' ] ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="card-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
                        </div>
                        <div class="card-footer text-muted">
                            <span><?php echo esc_html( get_the_date() ); ?></span>
                        </div>
                    </article>
                </div>
                <?php
            endwhile;
            ?>
        </div>
        <?php
    else :
        echo '<p>' . esc_html__( 'لا توجد أخبار حالياً.', 'renita' ) . '</p>';
    endif;
    wp_reset_postdata();

    return ob_get_clean();
}

function renita_render_stats_strip( $attributes ): string {
    $items = $attributes['items'] ?? [];

    ob_start();
    ?>
    <div class="renita-stats-strip py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center g-4">
                <?php foreach ( $items as $item ) : ?>
                    <div class="col-6 col-md-3">
                        <span class="display-5 fw-bold d-block"><?php echo esc_html( $item['value'] ?? '' ); ?></span>
                        <span class="text-uppercase"><?php echo esc_html( $item['label'] ?? '' ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php

    return ob_get_clean();
}

function renita_render_quick_links( $attributes ): string {
    $links = $attributes['links'] ?? [];

    if ( empty( $links ) ) {
        $links = [
            [ 'title' => __( 'قدّم الآن', 'renita' ), 'url' => '#apply' ],
            [ 'title' => __( 'القبول والتسجيل', 'renita' ), 'url' => '#admissions' ],
            [ 'title' => __( 'البحث العلمي', 'renita' ), 'url' => '#research' ],
            [ 'title' => __( 'زيارة الحرم الجامعي', 'renita' ), 'url' => '#visit' ],
        ];
    }

    ob_start();
    ?>
    <div class="renita-quick-links py-4">
        <div class="container">
            <div class="row g-3">
                <?php foreach ( $links as $link ) : ?>
                    <div class="col-6 col-md-3">
                        <a class="btn btn-outline-secondary w-100" href="<?php echo esc_url( $link['url'] ); ?>">
                            <?php echo esc_html( $link['title'] ); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php

    return ob_get_clean();
}
