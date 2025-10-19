<?php
/**
 * دوال مساعدة عامة
 */

if ( ! function_exists( 'renita_theme_string_blueprint' ) ) {
    require_once __DIR__ . '/seed/data.php';
}

if ( ! function_exists( 'renita_is_rtl' ) ) {
    function renita_is_rtl(): bool {
        return function_exists( 'is_rtl' ) ? is_rtl() : ( get_locale() === 'ar' );
    }
}

if ( ! function_exists( 'renita_localized_text' ) ) {
    function renita_localized_text( string $ar, string $en ): string {
        if ( function_exists( 'pll_current_language' ) && 'en' === pll_current_language() ) {
            return $en;
        }

        return $ar;
    }
}

if ( ! function_exists( 'renita_get_theme_string' ) ) {
    function renita_get_theme_string( string $key, ?string $lang = null ): string {
        $strings = renita_theme_string_blueprint();

        if ( empty( $strings[ $key ] ) ) {
            return '';
        }

        if ( null === $lang ) {
            if ( function_exists( 'pll_current_language' ) ) {
                $lang = pll_current_language();
            } else {
                $lang = renita_is_rtl() ? 'ar' : 'en';
            }
        }

        $default_ar = $strings[ $key ]['ar'] ?? '';

        if ( function_exists( 'pll_translate_string' ) && $default_ar ) {
            $translated = pll_translate_string( $default_ar, $lang );
            if ( $translated && $translated !== $default_ar ) {
                return $translated;
            }
        }

        if ( isset( $strings[ $key ][ $lang ] ) ) {
            return $strings[ $key ][ $lang ];
        }

        return $default_ar;
    }
}

if ( ! function_exists( 'renita_get_page_link_by_path' ) ) {
    function renita_get_page_link_by_path( string $path, string $lang = '' ): string {
        $page = get_page_by_path( $path );

        if ( ! $page ) {
            return '';
        }

        $post_id = $page->ID;

        if ( $lang && function_exists( 'pll_get_post' ) ) {
            $translated = pll_get_post( $post_id, $lang );
            if ( $translated ) {
                $post_id = $translated;
            }
        }

        return get_permalink( $post_id ) ?: '';
    }
}
