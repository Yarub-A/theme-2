<?php
/**
 * تعزيزات أمنية للقالب
 */

add_action( 'init', function () {
    add_filter( 'xmlrpc_enabled', '__return_false' );
    add_filter( 'rest_jsonp_enabled', '__return_false' );
} );

add_filter( 'the_generator', '__return_empty_string' );

add_action( 'after_setup_theme', function () {
    show_admin_bar( false );
} );
