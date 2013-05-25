<?php
/**
*   Columns Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['columns'] = array(
		'no_preview' => true,
		'options' => array(
			'gutter' => array(
				'name' => __('Gutter Width', THEME_FX),
				'desc' => __('A space between the columns.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'20' => '20px',
					'30' => '30px'
				),
				'std' => ''
			),
			'set' => array(
				'name' => __('Column Set', THEME_FX),
				'desc' => __('Select the set.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'[one_full]Content goes here[/one_full]' => '1/1',
					'[one_half]Content goes here[/one_half][one_half]Content goes here[/one_half]' => '1/2 + 1/2',
					'[one_third]Content goes here[/one_third][one_third]Content goes here[/one_third][one_third]Content goes here[/one_third]' => '1/3 + 1/3 + 1/3',
					'[two_third]Content goes here[/two_third][one_third]Content goes here[/one_third]' => '2/3 + 1/3',
					'[one_fourth]Content goes here[/one_fourth][one_fourth]Content goes here[/one_fourth][one_fourth]Content goes here[/one_fourth][one_fourth]Content goes here[/one_fourth]' => '1/4 + 1/4 + 1/4 + 1/4',
					'[one_half]Content goes here[/one_half][one_fourth]Content goes here[/one_fourth][one_fourth]Content goes here[/one_fourth]' => '1/2 + 1/4 + 1/4',
					'[three_fourth]Content goes here[/three_fourth][one_fourth]Content goes here[/one_fourth]' => '3/4 + 1/4',
					'[one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth]' => '1/5 + 1/5 + 1/5 + 1/5 + 1/5',
					'[two_fifth]Content goes here[/two_fifth][one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth]' => '2/5 + 1/5 + 1/5 + 1/5',
					'[three_fifth]Content goes here[/three_fifth][one_fifth]Content goes here[/one_fifth][one_fifth]Content goes here[/one_fifth]' => '3/5 + 1/5 + 1/5',
					'[four_fifth]Content goes here[/four_fifth][one_fifth]Content goes here[/one_fifth]' => '4/5 + 1/5',
				),
				'std' => ''
			)
		),
		'shortcode' => '[columns gutter="{{gutter}}"]{{set}}[/columns]',
		'popup_title' => __('Insert Column Shortcode', THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['column'] = array(
		'name' => __('Column', THEME_FX),
		'size' => 'one_fifth',
		'options' => array(
			'content' => array(
				'name' => __('Column Content', THEME_FX),
				'desc' => __('Enter the column content', THEME_FX),
				'type' => 'textarea',
				'std' => '',
				'class' => 'wide',
				'is_content' => '1'
			)
		)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	/* Columns Wrap */
	function fresh_shortcode_columns( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'gutter' => '20'
		), $atts));

		if( $gutter == '30') {
			$gutter = 'row_30';
		} else {
			$gutter = 'row';
		}

		return '<div class="'. $gutter .'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('columns', 'fresh_shortcode_columns');
	
	/* Full column */
	function fresh_shortcode_full_columns( $atts, $content = null ) {
		return '<div class="grid full">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_full', 'fresh_shortcode_full_columns');
	
	/* One Half */
	function fresh_shortcode_one_half_columns( $atts, $content = null ) {
		return '<div class="grid one-half">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_half', 'fresh_shortcode_one_half_columns');
	
	/* One Third */
	function fresh_shortcode_one_third_columns( $atts, $content = null ) {
		return '<div class="grid one-third">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_third', 'fresh_shortcode_one_third_columns');
	
	/* Two Third */
	function fresh_shortcode_two_third_columns( $atts, $content = null ) {
		return '<div class="grid two-third">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_third', 'fresh_shortcode_two_third_columns');
	
	/* One Fourth */
	function fresh_shortcode_one_fourth_columns( $atts, $content = null ) {
		return '<div class="grid one-fourth">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fourth', 'fresh_shortcode_one_fourth_columns');
	
	/* Three Fourth */
	function fresh_shortcode_three_fourth_columns( $atts, $content = null ) {
		return '<div class="grid three-fourth">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_fourth', 'fresh_shortcode_three_fourth_columns');
	
	/* One Fifth */
	function fresh_shortcode_one_fifth_columns( $atts, $content = null ) {
		return '<div class="grid one-fifth">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fifth', 'fresh_shortcode_one_fifth_columns');
	
	/* Two Fifth */
	function fresh_shortcode_two_fifth_columns( $atts, $content = null ) {
		return '<div class="grid two-fifth">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_fifth', 'fresh_shortcode_two_fifth_columns');
	
	/* Three Fifth */
	function fresh_shortcode_three_fifth_columns( $atts, $content = null ) {
		return '<div class="grid three-fifth">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_fifth', 'fresh_shortcode_three_fifth_columns');

	/* Four Fifth */
	function fresh_shortcode_four_fifth_columns( $atts, $content = null ) {
		return '<div class="grid three-four">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_four', 'fresh_shortcode_four_fifth_columns');