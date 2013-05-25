<?php
/**
*   Lead Paragraph Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['leadp'] = array(
		'no_preview' => true,
		'options' => array(
			'align' => array(
				'name' => __('Alignment', THEME_FX),
				'desc' => __('Add the pharagraph alignment', THEME_FX),
				'type' => 'select',
				'options' => array(
					'left' => 'Align Left',
					'right' => 'Align Right',
					'center' => 'Align Center'
				),
				'std' => ''
			),
			'content' => array(
				'name' => __('Paragraph Text', THEME_FX),
				'desc' => __('Add the pharagraph text', THEME_FX),
				'type' => 'textarea',
				'std' => ''
			)
		),
		'shortcode' => '[leadp align="{{align}}"]{{content}}[/leadp]',
		'popup_title' => __('Insert Lead Paragraph Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('leadp', 'fresh_shortcode_leadp');

	function fresh_shortcode_leadp( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'align' => ''
		), $atts));
		
		return '<p class="lead" style="text-align:'.$align.'">' . do_shortcode($content) . '</p>';
	}