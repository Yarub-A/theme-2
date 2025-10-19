<?php
/**
 * تسجيل البرامج الأكاديمية
 */

add_action( 'init', function () {
    $labels = [
        'name'          => __( 'البرامج الأكاديمية', 'renita' ),
        'singular_name' => __( 'برنامج', 'renita' ),
        'add_new'       => __( 'إضافة برنامج', 'renita' ),
        'add_new_item'  => __( 'إضافة برنامج جديد', 'renita' ),
        'edit_item'     => __( 'تحرير البرنامج', 'renita' ),
        'new_item'      => __( 'برنامج جديد', 'renita' ),
        'view_item'     => __( 'عرض البرنامج', 'renita' ),
        'search_items'  => __( 'بحث في البرامج', 'renita' ),
        'not_found'     => __( 'لا توجد برامج', 'renita' ),
        'all_items'     => __( 'جميع البرامج', 'renita' ),
        'menu_name'     => __( 'البرامج', 'renita' ),
    ];

    register_post_type( 'program', [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-awards',
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'has_archive' => true,
        'rewrite' => [ 'slug' => 'programs', 'with_front' => false ],
        'show_in_rest' => true,
        'capability_type' => 'post',
    ] );
} );
