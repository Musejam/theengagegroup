<?php
/**
*   Button Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['button'] = array(
		'no_preview' => false,
		'options' => array(
			'content' => array(
				'name' => __('Label', THEME_FX),
				'desc' => __('Enter the button text label.', THEME_FX),
				'type' => 'text',
				'std' => 'Button Text'
			),
			'size' => array(
				'name' => __('Button Size', THEME_FX),
				'desc' => __('Select the button size.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'small' => 'Small',
					'normal' => 'Normal',
					'large' => 'Large'
				),
				'std' => 'normal'
			),
			'color' => array(
				'name' => __('Button Color', THEME_FX),
				'desc' => __('Select the button color.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'default' => 'Default',
					'black' => 'Black',
					'blue' => 'Blue',
					'brown' => 'Brown',
					'green' => 'Green',
					'orange' => 'Orange',
					'pink' => 'Pink',
					'purple' => 'Purple',
					'red' => 'Red',
					'silver' => 'Silver',
					'yellow' => 'Yellow',
					'white' => 'White'
				),
				'std' => 'default'
			),
			'icon' => array(
				'name' => __('Icon', THEME_FX),
				'desc' => __('Select an icon.', THEME_FX),
				'type' => 'select',
				'options' => $fontawesome,
				'std' => ''
			),
			'url' => array(
				'name' => __('Link Destination', THEME_FX),
				'desc' => __('Enter the destination URL.', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'blank' => array(
				'name' => __('Link Targeting', THEME_FX),
				'checkbox_text' => __('Check to open the link in the new tab.', THEME_FX),
				'desc' => '',
				'type' => 'checkbox',
				'std' => '1'
			),
		),
		'shortcode' => '[button size="{{size}}" color="{{color}}" icon="{{icon}}" url="{{url}}" blank="{{blank}}"]{{content}}[/button]',
		'popup_title' => __('Insert Button Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('button', 'fresh_shortcode_button');

	function fresh_shortcode_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'size' => '',
			'color' => '',
			'icon' => '',
			'url' => '',
			'blank' => ''
		), $atts));

		$class = "button $color $size";
		$icon = '<i class="icon-'. $icon .'"></i>&nbsp;';
		$target = ($blank) ? ' target="_blank"' : '';

		return '<a class="'. $class .'" href="'. $url .'"'. $target .'>'. $icon . $content .'</a>';
	}