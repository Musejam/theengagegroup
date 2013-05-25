<?php
/**
*   Accordion Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['accordion'] = array(
		'no_preview' => true,
		'options' => array(
			'heading' => array(
				'name' => __('Heading', THEME_FX),
				'desc' => __('Enter the heading text', THEME_FX),
				'type' => 'text',
				'std' => '',
			)
		),
		'child' => array(
			'options' => array(
				'title' => array(
					'name' => __('Pane Title',  THEME_FX),
					'desc' => __('Enter the pane title.',  THEME_FX),
					'type' => 'text',
					'std' => ''
				),
				'icon' => array(
					'name' => __('Pane Icon', THEME_FX),
					'desc' => __('Select an icon.', THEME_FX),
					'type' => 'select',
					'options' => $fontawesome,
					'std' => 'none'
				),
				'content' => array(
					'name' => __('Pane Content',  THEME_FX),
					'desc' => __('Enter the content here.',  THEME_FX),
					'type' => 'textarea',
					'std' => ''
				)
			),
			'shortcode' => '[pane title="{{title}}" icon="{{icon}}"]{{content}}[/pane]',
			'clone' => __('Add More Pane',  THEME_FX )
		),
		'shortcode' => '[accordion heading="{{heading}}"]{{child}}[/accordion]',
		'popup_title' => __('Insert Accordion Shortcode',  THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['accordion'] = array(
		'name' => __('Accordion', THEME_FX),
		'size' => 'one_half',
		'options' => array(
			'heading' => array(
				'name' => __('Heading', THEME_FX),
				'desc' => __('Enter the heading text', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => '0'
			)
		),
		'child' => array(
			'title' => array(
				'name' => __('Title', THEME_FX),
				'desc' => __('Enter the pane title.', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => '0'
			),
			'icon' => array(
				'name' => __('Icon', THEME_FX),
				'desc' => __('Select an icon.', THEME_FX),
				'type' => 'select',
				'options' => $fontawesome,
				'std' => 'none',
				'class' => '',
				'is_content' => '0'
			),
			'content' => array(
				'name' => __('Content', THEME_FX),
				'desc' => __('Enter the content here.', THEME_FX),
				'type' => 'textarea',
				'class' => '',
				'is_content' => '1'
			)
		),
		'child_code' => 'pane'
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('accordion', 'fresh_shortcode_accordion');

	function fresh_shortcode_accordion( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'heading' => ''
		), $atts));

		$out = '';

		if ($heading != '') {
			$out .= '<div class="heading"><h3>'.$heading.'</h3><div class="sep"></div></div>';
		}
	
		if (!preg_match_all("/(.?)\[(pane)\b(.*?)(?:(\/))?\](?:(.+?)\[\/pane\])?(.?)/s", $content, $matches)) {
			return do_shortcode($content);
		} 
		else {
			
			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
			}

			$out .= '<div class="accordion">';
				for($i = 0; $i < count($matches[0]); $i++) {
					$icon = ( $matches[3][$i]['icon'] != '' ) ? '<i class="pane-icon icon-'.$matches[3][$i]['icon'].'"></i>' : '';
					$pane_class = ( $i == count($matches[0]) - 1 ) ? ' last' : '';

					$out .= '<div class="pane-title" title="'.$matches[3][$i]['title'].'">'.$icon.'<span class="label">'.$matches[3][$i]['title'].'<span><span class="status-on"><i class="icon-minus"></i></span><span class="status-off"><i class="icon-plus"></i></span></div>';
					$out .= '<div class="pane'. $pane_class .'">' . do_shortcode(trim($matches[5][$i])) .'</div>';
				}
			$out .= '</div>';
			
			return $out;
		}
	}