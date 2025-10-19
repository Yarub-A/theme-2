<?php
/**
 * إعدادات القالب العامة
 */

add_action( 'after_setup_theme', function () {
    load_theme_textdomain( 'renita', RENITA_THEME_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( [ 'assets/css/editor-style.css' ] );

    register_nav_menus( [
        'primary_menu_ar' => __( 'القائمة الرئيسية (عربي)', 'renita' ),
        'primary_menu_en' => __( 'Primary Menu (English)', 'renita' ),
        'footer_menu_ar'  => __( 'قائمة التذييل (عربي)', 'renita' ),
        'footer_menu_en'  => __( 'Footer Menu (English)', 'renita' ),
    ] );
} );
