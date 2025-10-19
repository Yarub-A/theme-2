<?php
/**
 * تحميل الأصول
 */

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'renita-bootstrap', RENITA_THEME_URI . '/assets/css/bootstrap.min.css', [], '5.3.3' );
    wp_enqueue_style( 'renita-bootstrap-override', RENITA_THEME_URI . '/assets/css/bootstrap-override.css', [ 'renita-bootstrap' ], RENITA_THEME_VERSION );
    wp_enqueue_style( 'renita-style', get_stylesheet_uri(), [ 'renita-bootstrap-override' ], RENITA_THEME_VERSION );

    if ( renita_is_rtl() ) {
        wp_enqueue_style( 'renita-rtl', RENITA_THEME_URI . '/rtl.css', [ 'renita-style' ], RENITA_THEME_VERSION );
    }

    wp_enqueue_script( 'renita-bootstrap', RENITA_THEME_URI . '/assets/js/bootstrap.bundle.min.js', [], '5.3.3', true );
    wp_enqueue_script( 'renita-script', RENITA_THEME_URI . '/assets/js/script.js', [ 'renita-bootstrap' ], RENITA_THEME_VERSION, true );
} );

add_action( 'enqueue_block_editor_assets', function () {
    wp_enqueue_style( 'renita-editor', RENITA_THEME_URI . '/assets/css/editor-style.css', [], RENITA_THEME_VERSION );
} );
