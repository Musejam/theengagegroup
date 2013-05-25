/* 
 * <?php echo THEME_NAME; ?> Theme Custom CSS 
 *
 * This file and all CSS code is created and generated automatically, if you found this file please don't edit or add code here.
 */ 

<?php

/* Body Background */
$body_bg = ft_get_option('body_bg');

if ($body_bg['image'] || $body_bg['color']) { 
	echo 'body.boxed{';

		if ($body_bg['color']) :
			echo 'background-color:' . $body_bg['color'] .';';
		endif;

		if ($body_bg['image']) :
			echo 'background-image: url("'. $body_bg['image'] .'");';
			echo 'background-repeat:' . $body_bg['repeat'] .';';
			echo 'background-position:' . $body_bg['position'] .';';
			echo 'background-attachment:' . $body_bg['attachment'] .';';
		endif;

	echo '}';
}

/* Body font */
$body_typo = ft_get_option('body_typo');
$line_height = $body_typo['size'] + 6 . 'px';

if( $body_typo ) {
	echo 'body{';
		echo 'color:' . $body_typo['color'] .';';
		echo 'font-family:' . $body_typo['face'] .';';
		echo 'font-size:' . $body_typo['size'] .';';
		echo 'line-height:' . $line_height .';';
	echo '}';
}

/* Heading font */
$heading_typo = ft_get_option('heading_typo');

if( $heading_typo ) {
	echo 'h1,h2,h3,h4,h5,h6{';
		echo 'color:' . $heading_typo['color'] .';';
		echo 'font-family:' . $heading_typo['face'] .';';
	echo '}';
}

/* Color Scheme */
$color_scheme = ft_get_option('color_scheme');

if( $color_scheme ) {
	echo '#respond #submit, .button, .flex-direction-nav a:hover, ol.flex-control-paging li a.flex-active, .jp-play-bar, .jp-volume-bar-value, .heading .sep, .entry-badge:hover, #portfolio-filter .sep, .portfolio-items .item .overlay, #content .wp-pagenavi a:hover, #content .wp-pagenavi span.current, .widget-title .sep, .tagcloud a:hover, .social-links li a:hover, #footer-wrapper .social-links li a:hover, .teaser:hover .teaser-icon, .profile-box .profile-socials a:hover, ul.social-links li a:hover, #footer-wrapper ul.social-links li a:hover{';
		echo 'background-color:' . $color_scheme .';';
	echo '}';

	echo '#primary-menu > ul > li > a:hover, #primary-menu > ul > li.sfHover > a, #primary-menu > ul > li.active > a{';
		echo 'border-color:' . $color_scheme .';';
	echo '}';

	echo 'a, a.reserve:hover, #primary-menu > ul > li > a:hover, #primary-menu > ul > li.sfHover > a, #primary-menu > ul > li.active > a, #primary-menu ul li ul li a:hover, ol.commentlist li .comment .comment-meta .comment-author .fn a, #portfolio-filter li a.selected{';
		echo 'color:' . $color_scheme .';';
	echo '}';

	echo '::selection{';
		echo 'background-color:' . $color_scheme .';';
	echo '}';

	echo '::-moz-selection{';
		echo 'background-color:' . $color_scheme .';';
	echo '}';
}

/* Logo */
$logo_top_margin = ft_get_option('logo_top_margin');

if( $logo_top_margin != '' ) {
	echo '#logo #site-title{';
		echo 'margin-top:' . $logo_top_margin .'px;';
	echo '}';
}

/* Top Header */
$top_header_bg = ft_get_option('top_header_bg');
$top_header_border_top_color = ft_get_option('top_header_border_top_color');
$top_header_border_bottom_color = ft_get_option('top_header_border_bottom_color');
$top_header_text_color = ft_get_option('top_header_text_color');

if( $top_header_bg != '' || $top_header_border_top_color != '' || $top_header_border_bottom_color != '' || $top_header_text_color != '') {
	echo '#topheader{';
	if( $top_header_bg ) :
		echo 'background-color:' . $top_header_bg .';';
	endif;

	if( $top_header_border_top_color ) :
		echo 'border-top-color:' . $top_header_border_top_color .';';
	endif;

	if( $top_header_border_bottom_color ) :
		echo 'border-bottom-color:' . $top_header_border_bottom_color .';';
	endif;

	if( $top_header_text_color ) :
		echo 'color:' . $top_header_text_color .';';
	endif;
	echo '}';
}

/* Header Background */
$header_bg = ft_get_option('header_bg');
$header_border_color = ft_get_option('header_border_color');

if ($header_bg['image'] || $header_bg['color'] || $header_border_color) :
	echo '#header{';

		if ($header_bg['color']) :
			echo 'background-color:' . $header_bg['color'] .';';
		endif;

		if ($header_bg['image']) :
			echo 'background-image: url("'. $header_bg['image'] .'");';
			echo 'background-repeat:' . $header_bg['repeat'] .';';
			echo 'background-position:' . $header_bg['position'] .';';
			echo 'background-attachment:' . $header_bg['attachment'] .';';
		endif;

		if ($header_border_color) :
			echo 'border-color:' . $header_border_color .';';
		endif;

		if( ft_get_option('top_header') == 'off') :
			echo 'border-top:none;';
		endif;

	echo '}';
endif; 

/* Page title */ 
$page_title_bg = ft_get_option('page_title_bg');
$page_title_border_color = ft_get_option('page_title_border_color');
$page_title_heading_color = ft_get_option('page_title_heading_color');
$page_title_desc_color = ft_get_option('page_title_desc_color');

if ($page_title_bg['image'] || $page_title_bg['color'] || $page_title_border_color) :
	echo '#page-title{';

		if ($page_title_bg['color']) :
			echo 'background-color:' . $page_title_bg['color'] .';';
		endif;

		if ($page_title_bg['image']) :
			echo 'background-image: url("'. $page_title_bg['image'] .'");';
			echo 'background-repeat:' . $page_title_bg['repeat'] .';';
			echo 'background-position:' . $page_title_bg['position'] .';';
			echo 'background-attachment:' . $page_title_bg['attachment'] .';';
		endif;

		if ($page_title_border_color) :
			echo 'border-color:' . $page_title_border_color .';';
		endif;

	echo '}';
endif; 

if ($page_title_heading_color) :
	echo '#page-title h1{';
		echo 'color:' . $page_title_heading_color .';';
	echo '}';
endif; 

if ($page_title_desc_color) :
	echo '#page-title h2{';
		echo 'color:' . $page_title_desc_color .';';
	echo '}';
endif;

/* Menu font */
$primary_menu_typo = ft_get_option('primary_menu_typo');

if( $primary_menu_typo ) {
	echo '#primary-menu > ul > li > a{';
		echo 'font-family:' . $primary_menu_typo['face'] .';';
	echo '}';


	echo '#primary-menu > ul > li > a strong{';
		echo 'font-size:' . $primary_menu_typo['size'] .';';
		echo 'text-transform:' . $primary_menu_typo['case'] .';';
	echo '}';
}

/* Menu link color */
$menu_link_color = ft_get_option('menu_link_color');

if( $menu_link_color ) {
	echo '#primary-menu > ul > li > a{';
		echo 'color:' . $menu_link_color .';';
	echo '}';
}

/* Menu desc color */
$menu_link_desc_color = ft_get_option('menu_link_desc_color');

if( $menu_link_desc_color ) {
	echo '#primary-menu > ul > li > a span{';
		echo 'color:' . $menu_link_desc_color .';';
	echo '}';
}

/* Menu indicator color */
$menu_link_indicator_color = ft_get_option('menu_link_indicator_color');

if( $menu_link_indicator_color ) {
	echo '#primary-menu > ul > li > a:hover, #primary-menu > ul > li.sfHover > a, #primary-menu > ul > li.active > a{';
		echo 'border-top-color:' . $menu_link_indicator_color .';';
		echo 'color:' . $menu_link_indicator_color .';';
	echo '}';
}

/* Footer Widgets Background */
$footer_widgets_bg = ft_get_option('footer_widgets_bg');
$footer_widgets_top_border_color = ft_get_option('footer_widgets_top_border_color');

if ($footer_widgets_bg['image'] || $footer_widgets_bg['color'] || $footer_widgets_top_border_color) :
	echo '#footer-wrapper{';

		if ($footer_widgets_bg['color']) :
			echo 'background-color:' . $footer_widgets_bg['color'] .';';
		endif;

		if ($footer_widgets_bg['image']) :
			echo 'background-image: url("'. $footer_widgets_bg['image'] .'");';
			echo 'background-repeat:' . $footer_widgets_bg['repeat'] .';';
			echo 'background-position:' . $footer_widgets_bg['position'] .';';
			echo 'background-attachment:' . $footer_widgets_bg['attachment'] .';';
		endif;

		if ($footer_widgets_top_border_color) :
			echo 'border-color:' . $footer_widgets_top_border_color .';';
		endif;

	echo '}';
endif; 

/* Footer widget title color */
$footer_widgets_title_color = ft_get_option('footer_widgets_title_color');

if( $footer_widgets_title_color ) {
	echo '#footer-wrapper .widget-title{';
		echo 'color:' . $footer_widgets_title_color .';';
	echo '}';
}

/* Footer widget text color */
$footer_widgets_text_color = ft_get_option('footer_widgets_text_color');

if( $footer_widgets_text_color ) {
	echo '#footer-wrapper, .widget-about i{';
		echo 'color:' . $footer_widgets_text_color .';';
	echo '}';
}

/* Footer widget text link color */
$footer_widgets_link_color = ft_get_option('footer_widgets_link_color');

if( $footer_widgets_link_color ) {
	echo '#footer-wrapper a{';
		echo 'color:' . $footer_widgets_link_color .';';
	echo '}';
}

/* Footer widget text link hover color */
$footer_widgets_link_hover_color = ft_get_option('footer_widgets_link_hover_color');

if( $footer_widgets_link_hover_color ) {
	echo '#footer-wrapper a:hover{';
		echo 'color:' . $footer_widgets_link_hover_color .';';
	echo '}';
}

/* Footer Bottom Background */
$footer_bottom_bg = ft_get_option('footer_bottom_bg');
$footer_bottom_top_border_color = ft_get_option('footer_bottom_top_border_color');

if ($footer_bottom_bg['image'] || $footer_bottom_bg['color'] || $footer_bottom_top_border_color) :
	echo '#footer-bottom{';

		if ($footer_bottom_bg['color']) :
			echo 'background-color:' . $footer_bottom_bg['color'] .';';
		endif;

		if ($footer_bottom_bg['image']) :
			echo 'background-image: url("'. $footer_bottom_bg['image'] .'");';
			echo 'background-repeat:' . $footer_bottom_bg['repeat'] .';';
			echo 'background-position:' . $footer_bottom_bg['position'] .';';
			echo 'background-attachment:' . $footer_bottom_bg['attachment'] .';';
		endif;

		if ($footer_bottom_top_border_color) :
			echo 'border-color:' . $footer_bottom_top_border_color .';';
		endif;

	echo '}';
endif;

/* Footer bottom text color */
$footer_bottom_text_color = ft_get_option('footer_bottom_text_color');

if( $footer_bottom_text_color ) {
	echo '#footer-bottom, #copyright{';
		echo 'color:' . $footer_bottom_text_color .';';
	echo '}';
}

/* Footer bottom text link color */
$footer_bottom_link_color = ft_get_option('footer_bottom_link_color');

if( $footer_bottom_link_color ) {
	echo '#footer-bottom a, #footer-menu ul li a{';
		echo 'color:' . $footer_bottom_link_color .';';
	echo '}';
}

/* Footer bottom text link hover color */
$footer_bottom_link_hover_color = ft_get_option('footer_bottom_link_hover_color');

if( $footer_bottom_link_hover_color ) {
	echo '#footer-bottom a:hover, #footer-menu ul li a:hover{';
		echo 'color:' . $footer_bottom_link_hover_color .';';
	echo '}';
}

/* Footer menu font */
$footer_menu_typo = ft_get_option('footer_menu_typo');

if( $footer_menu_typo ) {
	echo '#footer-menu ul li a{';
		echo 'font-family:' . $footer_menu_typo['face'] .';';
		echo 'font-size:' . $footer_menu_typo['size'] .';';
		echo 'text-transform:' . $footer_menu_typo['case'] .';';
	echo '}';
}

/* Custom CSS */
$custom_css = ft_get_option('custom_css');
if ($custom_css) echo stripslashes($custom_css);