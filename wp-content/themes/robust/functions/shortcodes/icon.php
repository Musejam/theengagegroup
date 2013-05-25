<?php
/**
*   Icon Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['icon'] = array(
		'options' => array(
			'icon' => array(
				'name' => __('Icon', THEME_FX),
				'desc' => __('Select the icon.', THEME_FX),
				'type' => 'select',
				'options' => $fontawesome,
				'std' => 'none'
			),
			'size' => array(
				'name' => __('Size', THEME_FX),
				'desc' => __('Select the icon size.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'normal' => __('Normal Size', THEME_FX),
					'large' => __('Large Size', THEME_FX),
					'2x' => __('2x Size', THEME_FX),
					'3x' => __('3x Size', THEME_FX),
					'4x' => __('4x Size', THEME_FX)
				),
				'std' => 'normal'
			),
			'style' => array(
				'name' => __('Style', THEME_FX),
				'desc' => __('Select the icon style.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'normal' => __('Normal', THEME_FX),
					'muted' => __('Muted', THEME_FX),
					'border' => __('Border', THEME_FX),
					'spin' => __('Spin', THEME_FX)
				),
				'std' => 'normal'
			),
		),
		'shortcode' => '[icon icon="{{icon}}" size="{{size}}" style="{{style}}"]',
		'popup_title' => __('Insert Icon Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('icon', 'fresh_shortcode_icon');

	function fresh_shortcode_icon( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'style' => ''
		), $atts));
		
		return '<i class="icon-'. $icon .' icon-'. $size .' icon-'. $style .'"></i>';
	}