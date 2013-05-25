<?php
/**
*   Heading Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['heading'] = array(
		'no_preview' => true,
		'options' => array(
			'content' => array(
				'name' => __('Heading Text', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'std' => ''
			)
		),
		'shortcode' => '[heading]{{content}}[/heading]',
		'popup_title' => __('Insert Heading Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('heading', 'fresh_shortcode_heading');

	function fresh_shortcode_heading( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'class' => '',
		), $atts));

		$class = ($class) ? " $class" : '';
		
		return '<div class="heading'.$class.'"><h3>'.$content.'</h3><div class="sep"></div></div>';
	}