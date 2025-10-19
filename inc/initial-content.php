<?php
/**
 * تهيئة المحتوى الأولي للقالب
 */

require_once __DIR__ . '/seed/data.php';
require_once __DIR__ . '/seed/helpers.php';
require_once __DIR__ . '/seed/menus.php';

function renita_seed_initial_content(): void {
    if ( get_option( 'renita_seed_version' ) === RENITA_THEME_VERSION ) {
        return;
    }

    $languages = renita_seed_ensure_languages();

    $pages    = renita_seed_page_definitions();
    $page_ids = renita_seed_pages( $pages, $languages );

    if ( ! empty( $page_ids['front-page'] ) ) {
        $front_ar = $page_ids['front-page']['ar'] ?? array_values( $page_ids['front-page'] )[0];
        update_option( 'page_on_front', $front_ar );
        update_option( 'show_on_front', 'page' );
    }

    [ $college_ids, $department_ids, $department_college_map ] = renita_seed_colleges( renita_seed_college_definitions(), $languages );
    $program_type_ids = renita_seed_program_types( renita_seed_program_type_definitions(), $languages );

    renita_seed_programs( renita_seed_program_definitions(), $languages, $college_ids, $department_ids, $program_type_ids );
    renita_seed_news( renita_seed_news_definitions(), $languages );

    renita_seed_menus( $page_ids, $college_ids, $department_ids, $program_type_ids, $department_college_map, $languages );

    update_option( 'renita_seed_version', RENITA_THEME_VERSION );
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'renita_seed_initial_content' );
