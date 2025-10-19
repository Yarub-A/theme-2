<?php
/**
 * تكامل Polylang
 */

add_action( 'after_switch_theme', function () {
    if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_create_language' ) ) {
        return;
    }

    $languages = pll_languages_list( [ 'fields' => 'slug' ] );

    if ( ! in_array( 'ar', $languages, true ) ) {
        pll_create_language( [
            'name'        => 'Arabic',
            'slug'        => 'ar',
            'locale'      => 'ar',
            'rtl'         => true,
            'flag'        => 'ps',
            'term_group'  => 0,
        ] );
    }

    if ( ! in_array( 'en', $languages, true ) ) {
        pll_create_language( [
            'name'        => 'English',
            'slug'        => 'en',
            'locale'      => 'en_US',
            'rtl'         => false,
            'flag'        => 'gb',
            'term_group'  => 0,
        ] );
    }
} );

add_action( 'init', function () {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    $strings = [
        'hero_heading'       => [ 'ar' => 'جامعة Renita University', 'en' => 'Renita University' ],
        'hero_subheading'    => [ 'ar' => 'الجامعة الأوروبية للعلوم الذكية', 'en' => 'European University for Smart Sciences' ],
        'apply_now'          => [ 'ar' => 'قدّم الآن', 'en' => 'Apply Now' ],
        'research_innovation' => [ 'ar' => 'البحث والابتكار', 'en' => 'Research & Innovation' ],
    ];

    foreach ( $strings as $key => $value ) {
        pll_register_string( $key, $value['ar'], 'renita' );
        pll_register_string( $key . '_en', $value['en'], 'renita' );
    }
} );
