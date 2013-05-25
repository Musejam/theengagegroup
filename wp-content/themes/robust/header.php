<!doctype html>
<!--[if IE 6]><html id="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<?php if ( ft_get_option('responsive') != 'off' ) : ?>
<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
<?php endif; ?>
<title><?php wp_title('|', true, 'right'); ?></title>
    
<!--[if lt IE 9]>
<script src="<?php echo THEME_DIR; ?>/javascripts/html5.js" type="text/javascript"></script>
<![endif]-->

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    
<!-- HEADER START -->
<div id="header-wrapper" class="clearfix <?php echo ft_get_option('header_type'); ?>">
    
    <?php if( ft_get_option('top_header') != 'off') : ?>
        <div id="topheader" class="clearfix">
            <div class="container">
                <div id="top-info" class="grid one-half">
                    <?php echo stripslashes( ft_get_option('top_info') ); ?>
                    <!-- Now available on <strong>ThemeForest</strong>, check it out! <a href="#">http://t.co/458sej</a> -->
                </div>
                <div id="call-us" class="grid one-half">
                    <?php echo stripslashes( ft_get_option('call_us') ); ?>
                    <!-- Toll Free Number: (123) 456-7890 - Email: hello@robust.com -->
                </div>
            </div>
        </div>
    <?php endif; ?>

    <header id="header" class="clearfix">
        <div class="container">

            <!-- LOGO START -->
            <div id="logo" class="grid one-third">
                <?php if ( ft_get_option('logo') ) : ?>
                    <h1 id="site-title"><a href="<?php echo home_url(); ?>"><img src="<?php echo ft_get_option('logo'); ?>" alt="<?php bloginfo('name'); ?>"></a></h1>
                <?php else : ?>
                    <h1 id="site-title"><a class="reserve" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
                <?php endif; ?>
            </div>
            <!-- LOGO END -->


            <!--PRIMARY MENU START-->
            <div class="grid two-thirds">
                <?php if ( has_nav_menu( 'primary_menu' ) ) : ?>
                    <?php 
                    wp_nav_menu( array(
                        'container' => 'nav', 
                        'container_id' => 'primary-menu',
                        'container_class' => 'clearfix', 
                        'menu_class' => 'sf-menu', 
                        'menu_id' => '', 
                        'theme_location' => 'primary_menu',
                        'walker' => new description_walker()
                    )); 
                    ?>
                <?php else : ?>
                    <nav id="primary-menu" class="clearfix">
                        <ul class="sf-menu">
                            <li class="active">
                                <a href="<?php echo home_url(); ?>">
                                    <strong><?php _e('Home', THEME_FX); ?></strong>
                                    <span><?php _e('Start from here', THEME_FX); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url('nav-menus.php'); ?>">
                                    <strong><?php _e('Configure', THEME_FX); ?></strong>
                                    <span><?php _e('Configure this menu', THEME_FX); ?></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
            <!--PRIMARY MENU END-->

        </div>
    </header>
</div>
<!-- HEADER END -->

<!-- MAIN WRAPPER START -->
<div id="main-wrapper">
