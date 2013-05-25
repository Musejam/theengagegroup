<?php
/**
*   Content Box Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['content_box'] = array(
		'no_preview' => true,
		'options' => array(
			'color' => array(
				'name' => __('Box Color', THEME_FX),
				'desc' => __('Select the color.', THEME_FX),
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
				'name' => __('Content', THEME_FX),
				'desc' => __('Enter the content.', THEME_FX),
				'type' => 'textarea',
				'std' => ''
			)
		),
		'shortcode' => '[content_box color="{{color}}"]{{content}}[/content_box]',
		'popup_title' => __('Insert Content Box Shortcode', THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['content_box'] = array(
		'name' => __('Content Box', THEME_FX),
		'size' => 'one_third',
		'options' => array(
			'color' => array(
				'name' => __('Box Color', THEME_FX),
				'desc' => __('Select the color.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'default' => __('Default', THEME_FX),
					'blue' => __('Blue', THEME_FX),
					'green' => __('Green', THEME_FX),
					'red' => __('Red', THEME_FX),
					'yellow' => __('Yellow', THEME_FX)
				),
				'std' => '',
				'class' => '',
				'is_content' => 0
			),
			'content' => array(
				'name' => __('Content', THEME_FX),
				'desc' => __('Enter the content', THEME_FX),
				'type' => 'textarea',
				'std' => '',
				'class' => '',
				'is_content' => 1
			)
		)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('content_box', 'fresh_shortcode_content_box');

	function fresh_shortcode_content_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'color' => 'default'
		), $atts));

		return '<div class="content-box '.$color.'">'.do_shortcode($content).'</div>';
	}