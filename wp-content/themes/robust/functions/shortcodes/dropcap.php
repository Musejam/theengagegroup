<?php
/**
*   Dropcap Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['dropcap'] = array(
		'no_preview' => true,
		'options' => array(
			'content' => array(
				'name' => __('Letter', THEME_FX),
				'desc' => __('Enter the dropcap letter.', THEME_FX),
				'type' => 'text',
				'std' => 'D'
			),
			'style' => array(
				'name' => __('Style', THEME_FX),
				'desc' => __('Select the style.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'' => __('Normal', THEME_FX),
					'rounded' => __('Rounded', THEME_FX),
					'square' => __('Square', THEME_FX)
				),
				'std' => ''
			)
		),
		'shortcode' => '[dropcap style="{{style}}"]{{content}}[/dropcap]',
		'popup_title' => __('Insert Dropcap Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('dropcap', 'fresh_shortcode_dropcap');

	function fresh_shortcode_dropcap( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style' => ''
		), $atts));
		
		$style = ( $style != '') ? ' ' . $style : '';

		return '<span class="dropcap'. $style .'">' . do_shortcode($content) . '</span>';
	}