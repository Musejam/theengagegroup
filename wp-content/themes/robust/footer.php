</div>
<!-- MAIN WRAPPER END -->

<!-- FOOTER START -->
<footer id="footer-wrapper">

    <!-- COLOPHONE START -->
    <?php get_sidebar('footer'); ?>
    <!-- COLOPHONE END -->

    <!-- FOOTER BOTTOM START -->
    <div id="footer-bottom">
        <div class="container">
            
            <div class="grid two-third">
                <!-- FOOTER MENU START -->
                <?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
                    <?php
                    wp_nav_menu( array(
                        'container' => 'nav', 
                        'container_id' => 'footer-menu',
                        'container_class' => 'clearfix', 
                        'menu_class' => '', 
                        'menu_id' => '', 
                        'theme_location' => 'footer_menu',
                        'depth' => 1,
                    ));
                    ?>
                <?php else : ?>
                    <nav id="footer-menu" class="clearfix">
                        <ul>
                            <li class="current"><a href="<?php echo home_url(); ?>"><?php _e('Home', THEME_FX); ?></a></li>
                            <li><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Configure', THEME_FX); ?></a></li>
                        </ul>
                    </nav>
                <?php endif; ?>
                <!-- FOOTER MENU END -->

                <!-- COPYRIGHT START -->
                <div id="copyright">
                    <?php 
                    printf( 
                        __('&copy; %1$s <a href="%3$s" title="%2$s">%2$s</a>%4$s', THEME_FX) , 
                        date('Y'),
                        get_bloginfo('name'), 
                        home_url(),
                        ft_get_option('copyright_text') 
                    ); 
                    ?>
                </div>
                <!-- COPYRIGHT END -->
            </div>

            <!-- SOCIAL LINKS START -->
            <div class="grid one-third">
                <ul class="social-links">
                    <?php freshthemes_print_social_links(); ?>
                </ul>
            </div>
            <!-- SOCIAL LINKS END -->

        </div>
    </div>
    <!-- FOOTER START END -->

</footer>
<!-- FOOTER END -->

<?php wp_footer(); ?>
</body>
</html>