<?php
/**
 * وظائف القالب الرئيسة
 *
 * @package RenitaUniversity
 */

define( 'RENITA_THEME_VERSION', '1.0.0' );

define( 'RENITA_THEME_DIR', get_template_directory() );
define( 'RENITA_THEME_URI', get_template_directory_uri() );

require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/enqueue.php';
require_once __DIR__ . '/inc/security.php';
require_once __DIR__ . '/inc/cpt-colleges.php';
require_once __DIR__ . '/inc/cpt-news.php';
require_once __DIR__ . '/inc/cpt-programs.php';
require_once __DIR__ . '/inc/tax-departments.php';
require_once __DIR__ . '/inc/tax-program-type.php';
require_once __DIR__ . '/inc/blocks.php';
require_once __DIR__ . '/inc/polylang.php';
require_once __DIR__ . '/inc/initial-content.php';
require_once __DIR__ . '/inc/hooks.php';
