<?php
/**
*   Divider Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['divider'] = array(
		'no_preview' => true,
		'options' => array(
			'style' => array(
				'name' => __('Border Style', THEME_FX),
				'desc' => __('Select the style.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'none' => __('No Border', THEME_FX),
					'dashed' => __('Dashed', THEME_FX),
					'dotted' => __('Dotted', THEME_FX),
					'double' => __('Double', THEME_FX),
					'solid' => __('Solid', THEME_FX)
				),
				'std' => 'none'
			),
			'color' => array(
				'name' => __('Border Color', THEME_FX),
				'desc' => __('Enter a hex color code.', THEME_FX),
				'type' => 'text',
				'std' => '#ebebea'
			),
			'margin_top' => array(
				'name' => __('Top Margin', THEME_FX),
				'desc' => __('Enter the top margin value.', THEME_FX),
				'type' => 'text',
				'std' => '0px'
			),
			'margin_bottom' => array(
				'name' => __('Bottom Margin', THEME_FX),
				'desc' => __('Enter the bottom margin value.', THEME_FX),
				'type' => 'text',
				'std' => '0px'
			)
		),
		'shortcode' => '[divider style="{{style}}" color="{{color}}" margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}"]',
		'popup_title' => __('Insert Divider Shortcode', THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['divider'] = array(
		'name' => __('Divider', THEME_FX),
		'size' => 'one_full',
		'options' => array(
			'style' => array(
				'name' => __('Border Style', THEME_FX),
				'desc' => __('Select the style.', THEME_FX),'type' => 'select',
				'options' => array(
					'none' => __('No Border', THEME_FX),
					'dashed' => __('Dashed', THEME_FX),
					'dotted' => __('Dotted', THEME_FX),
					'double' => __('Double', THEME_FX),
					'solid' => __('Solid', THEME_FX)
				),
				'std' => 'none',
				'class' => '',
				'is_content' => '0'
			),
			'color' => array(
				'name' => __('Border Color', THEME_FX),
				'desc' => __('Enter a hex color code.', THEME_FX),
				'type' => 'text',
				'std' => '#ebebea',
				'class' => '',
				'is_content' => '0'
			),
			'margin_top' => array(
				'name' => __('Margin Top', THEME_FX),
				'desc' => __('Enter the top margin value.', THEME_FX),
				'type' => 'text',
				'std' => '0px',
				'class' => '',
				'is_content' => '0'
			),
			'margin_bottom' => array(
				'name' => __('Margin Bottom', THEME_FX),
				'desc' => __('Enter the bottom margin value.', THEME_FX),
				'type' => 'text',
				'std' => '0px',
				'class' => '',
				'is_content' => '0'
			)
		)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('divider', 'fresh_shortcode_divider');

	function fresh_shortcode_divider( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style' => '',
			'margin_top' => '',
			'margin_bottom' => '',
			'color' => '',
			'class' => ''
		), $atts));

		$margin_top = ($margin_top) ? $margin_top : 0;
		$margin_bottom = ($margin_bottom) ? $margin_bottom : 0;
		$color = ($color) ? $color : '#eaeaea';
		$class = ($class) ? " $class" : '';
		
		return '<div class="divider '. $style . $class .'" style="margin-top:'. $margin_top .';margin-bottom:'. $margin_bottom .';border-color:'. $color .'"></div>';
	}