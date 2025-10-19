<?php
/**
 * تصنيف الأقسام التابعة للكليات
 */

add_action( 'init', function () {
    $labels = [
        'name'              => __( 'الأقسام الأكاديمية', 'renita' ),
        'singular_name'     => __( 'قسم أكاديمي', 'renita' ),
        'search_items'      => __( 'بحث في الأقسام', 'renita' ),
        'all_items'         => __( 'جميع الأقسام', 'renita' ),
        'parent_item'       => __( 'القسم الأب', 'renita' ),
        'parent_item_colon' => __( 'القسم الأب:', 'renita' ),
        'edit_item'         => __( 'تحرير القسم', 'renita' ),
        'update_item'       => __( 'تحديث القسم', 'renita' ),
        'add_new_item'      => __( 'إضافة قسم جديد', 'renita' ),
        'new_item_name'     => __( 'اسم القسم الجديد', 'renita' ),
        'menu_name'         => __( 'الأقسام', 'renita' ),
    ];

    register_taxonomy( 'department', [ 'college', 'program' ], [
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'departments', 'with_front' => false ],
        'show_in_rest'      => true,
    ] );
} );
