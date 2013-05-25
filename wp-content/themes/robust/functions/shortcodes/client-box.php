<?php
/**
*   Client Box Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['client_box'] = array(
		'no_preview' => true,
		'options' => array(
			'heading' => array(
				'name' => __('Heading', THEME_FX),
				'desc' => __('Enter the heading text', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'column' => array(
				'name' => __('Column', THEME_FX),
				'desc' => __('Select the number of column.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'1' => __('1 Column', THEME_FX),
					'2' => __('2 Columns', THEME_FX),
					'3' => __('3 Columns', THEME_FX),
					'4' => __('4 Columns', THEME_FX),
					'5' => __('5 Columns', THEME_FX)
				),
				'std' => '4'
			)
		),
		'child' => array(
			'options' => array(
				'url' => array(
					'name' => __('Client URL',  THEME_FX),
					'desc' => __('Enter the client URL.',  THEME_FX),
					'type' => 'text',
					'std' => ''
				),
				'image' => array(
					'name' => __('Logo Image URL', THEME_FX),
					'desc' => __('Paste the logo image URL.', THEME_FX),
					'type' => 'text',
					'std' => ''
				)
			),
			'shortcode' => '[client url="{{title}}" image="{{icon}}"]',
			'clone' => __('Add More Client',  THEME_FX )
		),
		'shortcode' => '[client_box heading="{{heading}}"]{{child}}[/client_box]',
		'popup_title' => __('Insert Client Box Shortcode',  THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['client_box'] = array(
		'name' => __('Client Box', THEME_FX),
		'size' => 'one_full',
		'options' => array(
			'heading' => array(
				'name' => __('Heading', THEME_FX),
				'desc' => __('Enter the heading text', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => '0'
			),
			'column' => array(
				'name' => __('Column', THEME_FX),
				'desc' => __('Select the number of column.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'1' => __('1 Column', THEME_FX),
					'2' => __('2 Columns', THEME_FX),
					'3' => __('3 Columns', THEME_FX),
					'4' => __('4 Columns', THEME_FX),
					'5' => __('5 Columns', THEME_FX)
				),
				'std' => '4',
				'class' => '',
				'is_content' => 0
			)
		),
		'child' => array(
			'url' => array(
				'name' => __('Client URL',  THEME_FX),
				'desc' => __('Enter the client URL.',  THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => '0'
			),
			'image' => array(
				'name' => __('Logo Image URL', THEME_FX),
				'desc' => __('Paste the logo image URL.', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => '0'
			)
		),
		'child_code' => 'client'
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('client_box', 'fresh_shortcode_client_box');

	function fresh_shortcode_client_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'heading' => '',
			'column' => 4,
		), $atts));

		$grid = ' grid full';
		if ($column == '2') $grid = ' grid one-half';
		if ($column == '3') $grid = ' grid one-third';
		if ($column == '4') $grid = ' grid one-fourth';
		if ($column == '5') $grid = ' grid one-fifth';
		$out = '';

		if ($heading != '') {
			$out .= '<div class="heading"><h3>'.$heading.'</h3><div class="sep"></div></div>';
		}
	
		if (!preg_match_all("/(.?)\[(client)\b(.*?)(?:(\/))?\](?:(.+?)\[\/client\])?(.?)/s", $content, $matches)) {
			return do_shortcode($content);
		} 
		else {
			
			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
			}

			$out .= '<div class="client_box clearfix"><ul>';
				for($i = 0; $i < count($matches[0]); $i++) {
					// $icon = ( $matches[3][$i]['icon'] != '' ) ? '<i class="pane-icon icon-'.$matches[3][$i]['icon'].'"></i>' : '';

					// $out .= '<div class="pane-title" title="'.$matches[3][$i]['title'].'">'.$icon.'<span class="label">'.$matches[3][$i]['title'].'<span><span class="status-on"><i class="icon-minus"></i></span><span class="status-off"><i class="icon-plus"></i></span></div>';
					// $out .= '<div class="pane">' . do_shortcode(trim($matches[5][$i])) .'</div>';

					$client = $matches[3][$i]['image'] != '' ? '<img src="'. $matches[3][$i]['image'] .'" alt="" />' : '';
					$client = $matches[3][$i]['url'] != '' ? '<a href="'. $matches[3][$i]['url'] .'">'. $client .'</a>' : $client;

					$out .= '<li class="grid '. $grid .'">'. $client .'</li>';
				}
			$out .= '</ul></div>';
			
			return $out;
		}
	}