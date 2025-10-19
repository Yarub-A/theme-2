<?php
/**
 * تذييل الموقع
 */
?>
<footer class="site-footer bg-dark text-white mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <h4 class="h5 mb-3"><?php bloginfo( 'name' ); ?></h4>
                <p class="mb-0"><?php bloginfo( 'description' ); ?></p>
            </div>
            <div class="col-md-6">
                <?php
                $location = function_exists( 'pll_current_language' ) && 'en' === pll_current_language() ? 'footer_menu_en' : 'footer_menu_ar';
                wp_nav_menu( [
                    'theme_location' => $location,
                    'menu_class'     => 'nav justify-content-md-end flex-column flex-md-row gap-3',
                    'container'      => false,
                    'fallback_cb'    => '__return_false',
                ] );
                ?>
            </div>
        </div>
    </div>
    <div class="bg-black text-center py-3 small">
        &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
