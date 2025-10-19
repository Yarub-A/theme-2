<?php
/**
 * تكامل Polylang
 */

require_once __DIR__ . '/seed/data.php';
require_once __DIR__ . '/seed/helpers.php';

add_action( 'after_switch_theme', 'renita_seed_ensure_languages' );

add_action( 'init', function () {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    foreach ( renita_theme_string_blueprint() as $key => $values ) {
        pll_register_string( $key, $values['ar'], 'Renita Theme' );
    }
} );
