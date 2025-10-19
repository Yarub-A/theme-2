<?php
/**
 * صفحة الخطأ 404
 */

get_header();
?>
<main id="primary" class="site-main container py-5 text-center">
    <h1 class="display-4 fw-bold mb-3"><?php esc_html_e( 'الصفحة غير موجودة', 'renita' ); ?></h1>
    <p class="mb-4"><?php esc_html_e( 'عذراً، الصفحة المطلوبة غير متوفرة. استخدم البحث أو عد إلى الصفحة الرئيسية.', 'renita' ); ?></p>
    <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'العودة إلى الرئيسية', 'renita' ); ?></a>
</main>
<?php
get_footer();
