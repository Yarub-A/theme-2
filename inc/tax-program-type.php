<?php
/**
 * تصنيف أنواع البرامج
 */

add_action( 'init', function () {
    $labels = [
        'name'          => __( 'أنواع البرامج', 'renita' ),
        'singular_name' => __( 'نوع البرنامج', 'renita' ),
        'search_items'  => __( 'بحث في الأنواع', 'renita' ),
        'all_items'     => __( 'جميع الأنواع', 'renita' ),
        'edit_item'     => __( 'تحرير النوع', 'renita' ),
        'update_item'   => __( 'تحديث النوع', 'renita' ),
        'add_new_item'  => __( 'إضافة نوع جديد', 'renita' ),
        'new_item_name' => __( 'اسم النوع الجديد', 'renita' ),
        'menu_name'     => __( 'أنواع البرامج', 'renita' ),
    ];

    register_taxonomy( 'program-type', [ 'program' ], [
        'labels'            => $labels,
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'program-type', 'with_front' => false ],
        'show_in_rest'      => true,
    ] );
} );
