<?php
/**
*   Intro Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['intro'] = array(
		'no_preview' => true,
		'options' => array(
			'title' => array(
				'name' => __('Title', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'alignment' => array(
				'name' => __('Text Alignment', THEME_FX),
				'desc' => __('Enter text alignment.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'align-center' => __('Align Center', THEME_FX),
					'align-left' => __('Align Left', THEME_FX),
					'align-right' => __('Align Right', THEME_FX)
				),
				'std' => 'align-left',
			),
			'content' => array(
				'name' => __('Content', THEME_FX),
				'desc' => __('Enter the content', THEME_FX),
				'type' => 'textarea',
				'std' => ''
			)
		),
		'shortcode' => '[intro title="{{title}}" alignment="{{alignment}}"]{{content}}[/intro]',
		'popup_title' => __('Insert Intro Shortcode',  THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['intro'] = array(
		'name' => __('Intro', THEME_FX),
		'size' => 'one_full',
		'options' => array(
			'title' => array(
				'name' => __('Title', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'class' => '',
				'is_content' => 0
			),
			'alignment' => array(
				'name' => __('Text Alignment', THEME_FX),
				'desc' => __('The text alignment', THEME_FX),
				'type' => 'select',
				'options' => array(
					'align-center' => __('Align Center', THEME_FX),
					'align-left' => __('Align Left', THEME_FX),
					'align-right' => __('Align Right', THEME_FX)
				),
				'std' => 'align-left',
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
	add_shortcode('intro', 'fresh_shortcode_intro');

	function fresh_shortcode_intro( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title' => '',
			'alignment' => ''
		), $atts));

		$out = '';
		$out .= '<div class="intro clearfix '. $alignment .'">';
		$out .= '<h1>'. $title .'</h1>';
		$out .= '<div class="intro-content">'. do_shortcode($content) .'</div>';
		$out .= '</div>';

		return $out;
	}