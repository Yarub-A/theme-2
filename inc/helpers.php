<?php
/**
 * دوال مساعدة عامة
 */

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
