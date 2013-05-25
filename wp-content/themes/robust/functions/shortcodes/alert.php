<?php
/**
*   Alert Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['alert'] = array(
		'no_preview' => true,
		'options' => array(
			'color' => array(
				'name' => __('Color Style', THEME_FX),
				'desc' => __('Select the style.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'default' => __('Default', THEME_FX),
					'blue' => __('Blue', THEME_FX),
					'green' => __('Green', THEME_FX),
					'red' => __('Red', THEME_FX),
					'yellow' => __('Yellow', THEME_FX)
				),
				'std' => ''
			),
			'content' => array(
				'name' => __('Message', THEME_FX),
				'desc' => __('Your message here.', THEME_FX),
				'type' => 'textarea',
				'std' => ''
			)
		),
		'shortcode' => '[alert color="{{color}}"]{{content}}[/alert]',
		'popup_title' => __('Insert Alert Message Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('alert', 'fresh_shortcode_alert');

	function fresh_shortcode_alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'color' => ''
		), $atts));

		return '<div class="alert-message '.$color.'">'.do_shortcode($content).'</div>';
	}