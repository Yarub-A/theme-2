<?php
/**
 * تسجيل نوع الأخبار
 */

add_action( 'init', function () {
    $labels = [
        'name'          => __( 'الأخبار والفعاليات', 'renita' ),
        'singular_name' => __( 'خبر', 'renita' ),
        'add_new'       => __( 'إضافة خبر', 'renita' ),
        'add_new_item'  => __( 'إضافة خبر جديد', 'renita' ),
        'edit_item'     => __( 'تحرير الخبر', 'renita' ),
        'new_item'      => __( 'خبر جديد', 'renita' ),
        'view_item'     => __( 'عرض الخبر', 'renita' ),
        'search_items'  => __( 'بحث في الأخبار', 'renita' ),
        'all_items'     => __( 'جميع الأخبار', 'renita' ),
        'menu_name'     => __( 'الأخبار', 'renita' ),
    ];

    register_post_type( 'news', [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions' ],
        'has_archive' => true,
        'rewrite' => [ 'slug' => 'news', 'with_front' => false ],
        'show_in_rest' => true,
        'capability_type' => 'post',
    ] );
} );
