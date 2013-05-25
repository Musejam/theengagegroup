<?php

/*	Include Wordpress
 *	--------------------------------------------------------------------------- */
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];

	require_once( $path_to_wp . '/wp-load.php' );

/*	Get Shortcodes
 *	--------------------------------------------------------------------------- */
	$shortcode = html_entity_decode( trim( $_GET['sc'] ) ); ?>

	<!DOCTYPE HTML>
	<html lang="en">
		<head>
			<link rel="stylesheet" type="text/css" href="<?php echo THEME_DIR; ?>/stylesheets/base.css" media="all" />
			<link rel="stylesheet" type="text/css" href="<?php echo THEME_DIR; ?>/style.css" media="all" />
			<?php wp_head(); ?>
			<style type="text/css">
				html {margin: 0 !important;}
				body {padding: 20px 15px; background:#fff;}
			</style>
		</head>
		<body>
			<?php echo do_shortcode( $shortcode ); ?>
		</body>
	</html>