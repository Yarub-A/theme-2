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

    $meta_fields = [
        'renita_program_duration'      => 'string',
        'renita_program_language'      => 'string',
        'renita_program_delivery_mode' => 'string',
        'renita_program_requirements'  => 'string',
        'renita_program_modules'       => 'string',
        'renita_program_college_id'    => 'integer',
    ];

    foreach ( $meta_fields as $meta_key => $type ) {
        register_post_meta( 'program', $meta_key, [
            'single'        => true,
            'type'          => $type,
            'show_in_rest'  => true,
            'auth_callback' => 'renita_program_meta_can_edit',
        ] );
    }
} );

function renita_program_meta_can_edit(): bool {
    return current_user_can( 'edit_posts' );
}
