<?php
/**
 * بناء القوائم الرئيسية والتذييل
 */

function renita_seed_menus( array $page_ids, array $college_ids, array $department_ids, array $program_type_ids, array $department_college_map, array $languages ): void {
    $menus = [
        'primary_menu_ar' => [ 'name' => 'القائمة الرئيسية', 'lang' => 'ar' ],
        'primary_menu_en' => [ 'name' => 'Primary Menu', 'lang' => 'en' ],
        'footer_menu_ar'  => [ 'name' => 'قائمة التذييل', 'lang' => 'ar' ],
        'footer_menu_en'  => [ 'name' => 'Footer Menu', 'lang' => 'en' ],
    ];

    $translation_groups = [];

    foreach ( $menus as $location => $meta ) {
        $menu = wp_get_nav_menu_object( $meta['name'] );
        $menu_id = $menu ? $menu->term_id : wp_create_nav_menu( $meta['name'] );

        if ( is_wp_error( $menu_id ) || ! $menu_id ) {
            continue;
        }

        if ( function_exists( 'pll_set_term_language' ) ) {
            pll_set_term_language( $menu_id, $meta['lang'] );
        }

        $translation_groups[ $location ] = $menu_id;

        $locations = (array) get_theme_mod( 'nav_menu_locations', [] );
        $locations[ $location ] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        if ( ! empty( wp_get_nav_menu_items( $menu_id ) ) ) {
            continue;
        }

        $lang = $meta['lang'];

        $front_id = $page_ids['front-page'][ $lang ] ?? 0;
        if ( $front_id ) {
            renita_menu_add_page( $menu_id, $front_id );
        }

        $about_parent = renita_menu_add_page( $menu_id, $page_ids['about'][ $lang ] ?? 0 );
        if ( $about_parent ) {
            $about_children = [ 'about-overview', 'about-vision', 'about-certification', 'about-units', 'about-study', 'about-staff' ];
            foreach ( $about_children as $child_key ) {
                if ( 'about-units' === $child_key ) {
                    $units_parent = renita_menu_add_page( $menu_id, $page_ids['about-units'][ $lang ] ?? 0, $about_parent );
                    foreach ( [
                        'presidency-language-translation',
                        'presidency-educational-development',
                        'presidency-swedish-iraqi-center',
                        'presidency-innovation-center',
                        'presidency-psychological-counseling',
                    ] as $unit_key ) {
                        renita_menu_add_page( $menu_id, $page_ids[ $unit_key ][ $lang ] ?? 0, $units_parent );
                    }
                    continue;
                }
                renita_menu_add_page( $menu_id, $page_ids[ $child_key ][ $lang ] ?? 0, $about_parent );
            }
        }

        $colleges_parent = renita_menu_add_page( $menu_id, $page_ids['colleges'][ $lang ] ?? 0 );
        if ( $colleges_parent ) {
            foreach ( $college_ids as $college_slug => $translations ) {
                if ( empty( $translations[ $lang ] ) ) {
                    continue;
                }
                $college_item = renita_menu_add_post( $menu_id, $translations[ $lang ], 'college', $colleges_parent );
                if ( ! $college_item ) {
                    continue;
                }
                foreach ( $department_ids as $department_slug => $department_translation ) {
                    if ( ( $department_college_map[ $department_slug ] ?? '' ) !== $college_slug ) {
                        continue;
                    }
                    $term_id = $department_translation[ $lang ] ?? 0;
                    if ( $term_id ) {
                        renita_menu_add_term( $menu_id, $term_id, 'department', $college_item );
                    }
                }
            }
        }

        $programs_parent = renita_menu_add_page( $menu_id, $page_ids['programs'][ $lang ] ?? 0 );
        if ( $programs_parent ) {
            foreach ( $program_type_ids as $type_translation ) {
                $term_id = $type_translation[ $lang ] ?? 0;
                if ( $term_id ) {
                    renita_menu_add_term( $menu_id, $term_id, 'program-type', $programs_parent );
                }
            }
        }

        $admissions_parent = renita_menu_add_page( $menu_id, $page_ids['admissions'][ $lang ] ?? 0 );
        if ( $admissions_parent ) {
            foreach ( [ 'admissions-requirements', 'admissions-documents', 'admissions-process', 'admissions-fees', 'admissions-faq' ] as $admission_key ) {
                renita_menu_add_page( $menu_id, $page_ids[ $admission_key ][ $lang ] ?? 0, $admissions_parent );
            }
        }

        $research_parent = renita_menu_add_page( $menu_id, $page_ids['research'][ $lang ] ?? 0 );
        if ( $research_parent ) {
            foreach ( [ 'research-twinning', 'research-centers', 'research-innovation' ] as $research_key ) {
                renita_menu_add_page( $menu_id, $page_ids[ $research_key ][ $lang ] ?? 0, $research_parent );
            }
        }

        $news_link = get_post_type_archive_link( 'news' );
        if ( $news_link ) {
            $news_label = ( 'en' === $lang ) ? 'News & Events' : 'الأخبار والفعاليات';
            renita_menu_add_custom_url( $menu_id, $news_label, $news_link );
        }

        renita_menu_add_page( $menu_id, $page_ids['contact'][ $lang ] ?? 0 );

        if ( 0 === strpos( $location, 'footer_' ) ) {
            continue;
        }
    }

    if ( function_exists( 'pll_save_term_translations' ) ) {
        $primary_translation = [];
        $footer_translation  = [];
        foreach ( $menus as $location => $meta ) {
            $menu_id = $translation_groups[ $location ] ?? 0;
            if ( ! $menu_id ) {
                continue;
            }
            if ( 0 === strpos( $location, 'primary_menu_' ) ) {
                $primary_translation[ $meta['lang'] ] = $menu_id;
            }
            if ( 0 === strpos( $location, 'footer_menu_' ) ) {
                $footer_translation[ $meta['lang'] ] = $menu_id;
            }
        }
        if ( count( $primary_translation ) > 1 ) {
            pll_save_term_translations( $primary_translation );
        }
        if ( count( $footer_translation ) > 1 ) {
            pll_save_term_translations( $footer_translation );
        }
    }
}

function renita_menu_add_page( int $menu_id, int $page_id, int $parent = 0 ): int {
    if ( ! $page_id ) {
        return 0;
    }

    return (int) wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => get_the_title( $page_id ),
        'menu-item-object'    => 'page',
        'menu-item-object-id' => $page_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_post( int $menu_id, int $object_id, string $post_type, int $parent = 0 ): int {
    if ( ! $object_id ) {
        return 0;
    }

    return (int) wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => get_the_title( $object_id ),
        'menu-item-object'    => $post_type,
        'menu-item-object-id' => $object_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_term( int $menu_id, int $term_id, string $taxonomy, int $parent = 0 ): int {
    if ( ! $term_id ) {
        return 0;
    }

    return (int) wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => get_term_field( 'name', $term_id, $taxonomy ),
        'menu-item-object'    => $taxonomy,
        'menu-item-object-id' => $term_id,
        'menu-item-type'      => 'taxonomy',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_custom_url( int $menu_id, string $title, string $url, int $parent = 0 ): int {
    return (int) wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => $title,
        'menu-item-url'       => $url,
        'menu-item-type'      => 'custom',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}
