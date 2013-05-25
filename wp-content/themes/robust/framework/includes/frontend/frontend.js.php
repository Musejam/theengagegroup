/* 
 * <?php echo THEME_NAME; ?> Theme Custom Script 
 *
 * This file and all code is created and generated automatically, if you found this file please don't edit or add code here.
 */ 
<?php
$responsive = ft_get_option('responsive');
?>
jQuery(document).ready(function($){
<?php if ( $responsive == 'on') : ?>
    $('#primary-menu').mobileMenu({
        defaultText: 'Navigate to...',
        className: 'mobile-menu',
        subMenuDash: '&ndash;'
    });
<?php endif; ?>
});