<?php
/**
 * هوكات إضافية للقالب
 */

add_filter( 'comment_form_defaults', function ( $defaults ) {
    $defaults['comment_notes_before'] = '';
    $defaults['comment_notes_after']  = '';
    return $defaults;
} );

add_filter( 'rest_endpoints', function ( $endpoints ) {
    unset( $endpoints['/wp/v2/comments'] );
    return $endpoints;
} );

add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_post_type_archive( 'program' ) ) {
        $tax_query = [];

        if ( ! empty( $_GET['department'] ) ) {
            $tax_query[] = [
                'taxonomy' => 'department',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( wp_unslash( $_GET['department'] ) ),
            ];
        }

        if ( ! empty( $_GET['program-type'] ) ) {
            $tax_query[] = [
                'taxonomy' => 'program-type',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( wp_unslash( $_GET['program-type'] ) ),
            ];
        }

        if ( ! empty( $tax_query ) ) {
            $query->set( 'tax_query', $tax_query );
        }
    }
} );
