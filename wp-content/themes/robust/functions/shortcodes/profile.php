<?php
/**
*   Profile Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['profile'] = array(
		'no_preview' => true,
		'options' => array(
			'name' => array(
				'name' => __('Profile Name', THEME_FX),
				'desc' => __('Enter the name.', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'meta' => array(
				'name' => __('Profile Meta', THEME_FX),
				'desc' => __('Enter the profile meta. e.g job position etc.', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'image' => array(
				'name' => __('Profile Image', THEME_FX),
				'desc' => __('Paste your profile image URL here.', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'content' => array(
				'name' => __('Profile Description',  THEME_FX),
				'desc' => __('Enter the profile description text.',  THEME_FX),
				'type' => 'textarea',
				'std' => ''
			)
		),
		'shortcode' => '[profile name="{{name}}" meta="{{meta}}" image="{{image}}"]{{content}}[/profile]',
		'popup_title' => __('Insert Profile Shortcode', THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['profile'] = array(
		'name' => __('Profile', THEME_FX),
		'size' => 'one_fourth',
		'options' => array(
			'name' => array(
				'name' => __('Profile Name', THEME_FX),
				'desc' => __('Enter the name.', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => 0
			),
			'meta' => array(
				'name' => __('Profile Meta', THEME_FX),
				'desc' => __('Enter the profile meta. e.g job position etc.', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => 0
			),
			'image' => array(
				'name' => __('Profile Image', THEME_FX),
				'desc' => __('Paste your profile image URL here.', THEME_FX),
				'type' => 'text',
				'std' => '',
				'class' => '',
				'is_content' => 0
			),
			'content' => array(
				'name' => __('Profile Description', THEME_FX),
				'desc' => __('Enter the profile description text.',  THEME_FX),
				'type' => 'textarea',
				'std' => '',
				'class' => '',
				'is_content' => 1
			)
		)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('profile', 'fresh_shortcode_profile');

	function fresh_shortcode_profile( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'name' => '',
			'meta' => '',
			'image' => ''
		), $atts));

		$out = '';
		$out .= '<div class="profile-box clearfix">';

			if($image != '')
			$out .= '<figure class="profile-img"><img src="'. $image .'" alt="'. $name .'"/></figure>';

			if($name != '')
			$out .= '<h3 class="profile-name">'. $name .'</h3>';

			if($meta != '')
			$out .= '<div class="profile-meta">'. $meta .'</div>';
		
			$out .= '<div class="profile-desc">'. do_shortcode($content) .'</div>';
		$out .= '</div>';

		return $out;
	}