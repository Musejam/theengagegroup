<?php

/* 	Definitions
 *	--------------------------------------------------------------------------- */
	$the_theme = wp_get_theme();
	define( 'THEME_NAME', $the_theme['Name'] );
	define( 'THEME_VERSION', $the_theme['Version'] );
	define( 'THEME_FX', str_replace( ' ', '_', strtolower( THEME_NAME ) ) );
	define( 'THEME_DIR', get_template_directory_uri() . '/');
	define( 'THEME_PATH', get_template_directory() . '/' );

/* 	Set Content Width
 *	--------------------------------------------------------------------------- */
	if ( ! isset( $content_width ) )
	$content_width = 560;
	
/* 	Theme Setup
 *	--------------------------------------------------------------------------- */
	function freshtheme_setup() {
		global $wpdb, $pagenow;
		
		/* Load the theme text domain for translation */
		load_theme_textdomain( THEME_FX , get_template_directory() . '/languages' );
		
		/* Redirect to theme options page once after theme has beed activated */
		if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
			header( 'Location: '.admin_url().'admin.php?page=fresh-panel' ) ;
		}
	}
	
	add_action( 'after_setup_theme', 'freshtheme_setup' );

/*	Load Framework
 *	---------------------------------------------------------------------------- */
	require_once( 'framework/admin.php' );
	require_once( 'framework/metabox.php' );
	require_once( 'framework/page-builder.php' );
	require_once( 'framework/shortcodes.php' );
	require_once( 'framework/includes/fonts.php' );

/*	Load Theme Functions & Plugins
 *	---------------------------------------------------------------------------- */
	require_once( 'functions/theme-functions.php' );
	require_once( 'functions/theme-shortcodes.php' );
	require_once( 'functions/theme-post-type.php' );
	require_once( 'functions/theme-costumizer.php' );
	require_once( 'functions/theme-comment-template.php' );
	require_once( 'functions/theme-widgets.php' );
	require_once( 'functions/plugins/plugins.php' );
	require_once( 'functions/plugins/custom-image-sizes.php' );