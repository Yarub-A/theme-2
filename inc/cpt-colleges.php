<?php
/**
 * تسجيل نوع المحتوى المخصص للكليات
 */

add_action( 'init', function () {
    $labels = [
        'name'               => __( 'الكليات', 'renita' ),
        'singular_name'      => __( 'كلية', 'renita' ),
        'add_new'            => __( 'إضافة كلية جديدة', 'renita' ),
        'add_new_item'       => __( 'إضافة كلية جديدة', 'renita' ),
        'edit_item'          => __( 'تحرير الكلية', 'renita' ),
        'new_item'           => __( 'كلية جديدة', 'renita' ),
        'view_item'          => __( 'عرض الكلية', 'renita' ),
        'view_items'         => __( 'عرض الكليات', 'renita' ),
        'search_items'       => __( 'بحث في الكليات', 'renita' ),
        'not_found'          => __( 'لا توجد كليات', 'renita' ),
        'not_found_in_trash' => __( 'لا توجد كليات في سلة المهملات', 'renita' ),
        'all_items'          => __( 'كل الكليات', 'renita' ),
        'menu_name'          => __( 'الكليات', 'renita' ),
    ];

    register_post_type( 'college', [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => [ 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ],
        'has_archive' => true,
        'rewrite' => [ 'slug' => 'colleges', 'with_front' => false ],
        'show_in_rest' => true,
        'capability_type' => 'page',
    ] );
} );
