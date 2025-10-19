<?php
/**
 * وظائف مساعدة لعمليات البذر
 */

function renita_seed_ensure_languages(): array {
    $definitions = renita_seed_languages_definition();

    if ( ! function_exists( 'pll_languages_list' ) ) {
        return array_keys( $definitions );
    }

    $existing = pll_languages_list( [ 'fields' => 'slug' ] );

    foreach ( $definitions as $lang => $data ) {
        if ( in_array( $lang, $existing, true ) ) {
            continue;
        }

        if ( function_exists( 'pll_create_language' ) ) {
            pll_create_language( [
                'name'       => $data['name'],
                'slug'       => $data['slug'],
                'locale'     => $data['locale'],
                'rtl'        => $data['rtl'],
                'flag'       => $data['flag'],
                'term_group' => 0,
            ] );
        }
    }

    return array_keys( $definitions );
}

function renita_seed_upsert_post( string $seed_key, array $args, string $lang ): int {
    $post_type = $args['post_type'] ?? 'page';
    $title     = $args['post_title'] ?? $seed_key;
    $slug      = $args['post_name'] ?? sanitize_title( $title );

    $slug = sanitize_title( str_replace( '/', '-', $slug ) );

    $meta_query = [
        'relation' => 'AND',
        [
            'key'   => '_renita_seed_key',
            'value' => $seed_key,
        ],
        [
            'key'   => '_renita_seed_lang',
            'value' => $lang,
        ],
    ];

    $existing = get_posts( [
        'post_type'      => $post_type,
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_query'     => $meta_query,
    ] );

    if ( $existing ) {
        $post_id = (int) $existing[0];
        wp_update_post( array_merge( $args, [
            'ID'          => $post_id,
            'post_status' => 'publish',
            'post_name'   => $slug,
        ] ) );
        return $post_id;
    }

    $fallback = get_posts( [
        'post_type'      => $post_type,
        'name'           => $slug,
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ] );

    if ( $fallback ) {
        $post_id = (int) $fallback[0];
        update_post_meta( $post_id, '_renita_seed_key', $seed_key );
        update_post_meta( $post_id, '_renita_seed_lang', $lang );
        update_post_meta( $post_id, '_renita_seeded', 1 );
        if ( function_exists( 'pll_set_post_language' ) ) {
            pll_set_post_language( $post_id, $lang );
        }
        wp_update_post( array_merge( $args, [
            'ID'        => $post_id,
            'post_name' => $slug,
        ] ) );
        return $post_id;
    }

    $post_id = wp_insert_post( array_merge( $args, [
        'post_status' => 'publish',
        'post_name'   => $slug,
    ] ) );

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        return 0;
    }

    update_post_meta( $post_id, '_renita_seed_key', $seed_key );
    update_post_meta( $post_id, '_renita_seed_lang', $lang );
    update_post_meta( $post_id, '_renita_seeded', 1 );

    if ( function_exists( 'pll_set_post_language' ) ) {
        pll_set_post_language( $post_id, $lang );
    }

    return (int) $post_id;
}

function renita_seed_upsert_term( string $seed_key, string $taxonomy, string $slug, string $name, string $lang ): int {
    $slug = sanitize_title( str_replace( '/', '-', $slug ) );

    $existing = get_terms( [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'number'     => 1,
        'fields'     => 'ids',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'   => '_renita_seed_key',
                'value' => $seed_key,
            ],
            [
                'key'   => '_renita_seed_lang',
                'value' => $lang,
            ],
        ],
    ] );

    if ( $existing ) {
        $term_id = (int) $existing[0];
        wp_update_term( $term_id, $taxonomy, [
            'name' => $name,
            'slug' => $slug,
        ] );
        return $term_id;
    }

    $term = get_terms( [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'number'     => 1,
        'fields'     => 'ids',
        'slug'       => $slug,
    ] );

    if ( $term ) {
        $term_id = (int) $term[0];
        update_term_meta( $term_id, '_renita_seed_key', $seed_key );
        update_term_meta( $term_id, '_renita_seed_lang', $lang );
        update_term_meta( $term_id, '_renita_seeded', 1 );
        if ( function_exists( 'pll_set_term_language' ) ) {
            pll_set_term_language( $term_id, $lang );
        }
        wp_update_term( $term_id, $taxonomy, [
            'name' => $name,
            'slug' => $slug,
        ] );
        return $term_id;
    }

    $result = wp_insert_term( $name, $taxonomy, [ 'slug' => $slug ] );

    if ( is_wp_error( $result ) ) {
        return 0;
    }

    $term_id = (int) $result['term_id'];

    update_term_meta( $term_id, '_renita_seed_key', $seed_key );
    update_term_meta( $term_id, '_renita_seed_lang', $lang );
    update_term_meta( $term_id, '_renita_seeded', 1 );

    if ( function_exists( 'pll_set_term_language' ) ) {
        pll_set_term_language( $term_id, $lang );
    }

    return $term_id;
}

function renita_seed_pages( array $pages, array $languages ): array {
    $page_ids = [];

    foreach ( $pages as $key => $page ) {
        foreach ( $languages as $lang ) {
            $parent_id = 0;
            if ( ! empty( $page['parent'] ) && ! empty( $page_ids[ $page['parent'] ][ $lang ] ) ) {
                $parent_id = $page_ids[ $page['parent'] ][ $lang ];
            }

            $post_id = renita_seed_upsert_post( 'page-' . $key . '-' . $lang, [
                'post_title'   => $page['titles'][ $lang ] ?? $page['titles']['ar'],
                'post_content' => $page['content'][ $lang ] ?? '',
                'post_type'    => 'page',
                'post_parent'  => $parent_id,
                'post_name'    => $page['slug'],
            ], $lang );

            if ( $post_id ) {
                $page_ids[ $key ][ $lang ] = $post_id;
            }
        }

        if ( function_exists( 'pll_save_post_translations' ) && ! empty( $page_ids[ $key ] ) ) {
            pll_save_post_translations( $page_ids[ $key ] );
        }
    }

    return $page_ids;
}

function renita_seed_colleges( array $colleges, array $languages ): array {
    $college_ids          = [];
    $department_ids       = [];
    $department_college   = [];

    foreach ( $colleges as $college ) {
        $translations = [];
        foreach ( $languages as $lang ) {
            $post_id = renita_seed_upsert_post( 'college-' . $college['slug'] . '-' . $lang, [
                'post_title'   => $college['titles'][ $lang ] ?? $college['titles']['ar'],
                'post_content' => '',
                'post_type'    => 'college',
                'post_name'    => $college['slug'],
            ], $lang );

            if ( $post_id ) {
                $translations[ $lang ] = $post_id;
            }
        }

        if ( function_exists( 'pll_save_post_translations' ) && count( $translations ) > 1 ) {
            pll_save_post_translations( $translations );
        }

        $college_ids[ $college['slug'] ] = $translations;

        foreach ( $college['departments'] as $department ) {
            $term_translations = [];
            foreach ( $languages as $lang ) {
                $term_id = renita_seed_upsert_term(
                    'department-' . $department['slug'] . '-' . $lang,
                    'department',
                    $department['slug'],
                    $department['names'][ $lang ] ?? $department['names']['ar'],
                    $lang
                );

                if ( $term_id ) {
                    $term_translations[ $lang ]                     = $term_id;
                    $department_ids[ $department['slug'] ][ $lang ] = $term_id;

                    foreach ( $translations as $translation_lang => $college_post_id ) {
                        if ( $translation_lang === $lang ) {
                            wp_set_object_terms( $college_post_id, $term_id, 'department', true );
                        }
                    }
                }
            }

            if ( function_exists( 'pll_save_term_translations' ) && count( $term_translations ) > 1 ) {
                pll_save_term_translations( $term_translations );
            }

            $department_college[ $department['slug'] ] = $college['slug'];
        }
    }

    return [ $college_ids, $department_ids, $department_college ];
}

function renita_seed_program_types( array $types, array $languages ): array {
    $type_ids = [];

    foreach ( $types as $slug => $names ) {
        $term_translations = [];
        foreach ( $languages as $lang ) {
            $term_id = renita_seed_upsert_term( 'program-type-' . $slug . '-' . $lang, 'program-type', $slug, $names[ $lang ] ?? $names['ar'], $lang );
            if ( $term_id ) {
                $term_translations[ $lang ] = $term_id;
                $type_ids[ $slug ][ $lang ] = $term_id;
            }
        }

        if ( function_exists( 'pll_save_term_translations' ) && count( $term_translations ) > 1 ) {
            pll_save_term_translations( $term_translations );
        }
    }

    return $type_ids;
}

function renita_seed_programs( array $programs, array $languages, array $college_ids, array $department_ids, array $program_type_ids ): void {
    foreach ( $programs as $program ) {
        $translations = [];
        foreach ( $languages as $lang ) {
            $post_id = renita_seed_upsert_post( 'program-' . $program['slug'] . '-' . $lang, [
                'post_title'   => $program['titles'][ $lang ] ?? $program['titles']['ar'],
                'post_content' => $program['content'][ $lang ] ?? '',
                'post_type'    => 'program',
                'post_name'    => $program['slug'],
            ], $lang );

            if ( ! $post_id ) {
                continue;
            }

            $translations[ $lang ] = $post_id;

            $department_term_id = $department_ids[ $program['department'] ][ $lang ] ?? 0;
            if ( $department_term_id ) {
                wp_set_object_terms( $post_id, [ $department_term_id ], 'department', false );
            }

            $program_type_term_id = $program_type_ids[ $program['type'] ][ $lang ] ?? 0;
            if ( $program_type_term_id ) {
                wp_set_object_terms( $post_id, [ $program_type_term_id ], 'program-type', false );
            }

            if ( ! empty( $college_ids[ $program['college_slug'] ][ $lang ] ) ) {
                update_post_meta( $post_id, 'renita_program_college_id', $college_ids[ $program['college_slug'] ][ $lang ] );
            }

            foreach ( $program['meta'] as $meta_key => $meta_value ) {
                $value = $meta_value[ $lang ] ?? $meta_value['ar'];
                update_post_meta( $post_id, 'renita_program_' . $meta_key, $value );
            }

            update_post_meta( $post_id, '_renita_seeded', 1 );
        }

        if ( function_exists( 'pll_save_post_translations' ) && count( $translations ) > 1 ) {
            pll_save_post_translations( $translations );
        }
    }
}

function renita_seed_news( array $news, array $languages ): void {
    foreach ( $news as $item ) {
        $translations = [];
        foreach ( $languages as $lang ) {
            $post_id = renita_seed_upsert_post( 'news-' . $item['slug'] . '-' . $lang, [
                'post_title'   => $item['titles'][ $lang ] ?? $item['titles']['ar'],
                'post_content' => '<p>' . esc_html__( 'محتوى افتراضي للخبر.', 'renita' ) . '</p>',
                'post_type'    => 'news',
                'post_name'    => $item['slug'],
            ], $lang );

            if ( $post_id ) {
                $translations[ $lang ] = $post_id;
            }
        }

        if ( function_exists( 'pll_save_post_translations' ) && count( $translations ) > 1 ) {
            pll_save_post_translations( $translations );
        }
    }
}
