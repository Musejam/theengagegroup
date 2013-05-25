<?php

/*	Load required scripts
 *	--------------------------------------------------------- */
	function widget_assets() {
		wp_register_script(
			'freshwidget', THEME_DIR . '/javascripts/widgets.js', 
			false, 
			THEME_VERSION, 
			true 
		);
		
		wp_enqueue_script('freshwidget');
	}
	
	add_action('wp_enqueue_scripts', 'widget_assets');
	

/*	Include widgets
 *	--------------------------------------------------------- */
	require_once ('widgets/widget-recent-portfolio.php');
	require_once ('widgets/widget-tweets.php');
	require_once ('widgets/widget-facebook.php');
	require_once ('widgets/widget-flickr.php'); 
	require_once ('widgets/widget-dribbble.php'); 
	require_once ('widgets/widget-embed.php');
	require_once ('widgets/widget-about.php');