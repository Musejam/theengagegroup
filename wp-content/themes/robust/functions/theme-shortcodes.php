<?php

/* 	Include & Variables
 * 	----------------------------------------------------- */

	/* Include global fontawesome */
	global $fontawesome;

	/* Categories options */
	$options_categories = array();
	$options_categories_obj = get_categories();
	$options_categories[''] = __('Select a category:', THEME_FX);
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	require_once ('shortcodes/accordion.php');
	require_once ('shortcodes/alert.php');
	require_once ('shortcodes/button.php');
	require_once ('shortcodes/callout.php');
	require_once ('shortcodes/client-box.php');
	require_once ('shortcodes/column.php');
	require_once ('shortcodes/content-box.php');
	require_once ('shortcodes/divider.php');
	require_once ('shortcodes/dropcap.php');
	require_once ('shortcodes/entries.php');
	require_once ('shortcodes/gmap.php');
	require_once ('shortcodes/heading.php');
	require_once ('shortcodes/icon.php');
	require_once ('shortcodes/intro.php');
	require_once ('shortcodes/leadp.php');
	require_once ('shortcodes/list-icon.php');
	require_once ('shortcodes/portfolio.php');
	require_once ('shortcodes/pricing.php');
	require_once ('shortcodes/profile.php');
	require_once ('shortcodes/social.php');
	require_once ('shortcodes/tabs.php');
	require_once ('shortcodes/teaser.php');
	require_once ('shortcodes/testimonial.php');
	require_once ('shortcodes/video.php');

/* 
 * 	Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop. 
 * 	http://www.johannheyne.de
 * 	----------------------------------------------------- */
	function shortcode_empty_paragraph_fix($content){   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);

		$content = strtr($content, $array);

		return $content;
	}

	add_filter('the_content', 'shortcode_empty_paragraph_fix');
	add_filter( 'widget_text', 'do_shortcode', 11);