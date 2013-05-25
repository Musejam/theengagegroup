<?php
/**
*   Social Links Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['social_links'] = array(
		'no_preview' => true,
		'options' => array(
			'facebook' => array(
				'name' => __('Facebook', THEME_FX),
				'desc' => __('Enter your facebook profile URL', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'twitter' => array(
				'name' => __('Twitter', THEME_FX),
				'desc' => __('Enter your twitter profile URL', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'google_plus' => array(
				'name' => __('Google+', THEME_FX),
				'desc' => __('Enter your google plus profile URL', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'linkedin' => array(
				'name' => __('Linkedin', THEME_FX),
				'desc' => __('Enter your linkedin profile URL', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'github' => array(
				'name' => __('Github', THEME_FX),
				'desc' => __('Enter your github profile URL', THEME_FX),
				'type' => 'text',
				'std' => ''
			),
			'pinterest' => array(
				'name' => __('Pinterest', THEME_FX),
				'desc' => __('Enter your pinterest profile URL', THEME_FX),
				'type' => 'text',
				'std' => ''
			)
		),
		'shortcode' => '[social_links facebook="{{facebook}}" twitter="{{twitter}}" google_plus="{{google_plus}}" linkedin="{{linkedin}}" github="{{github}}" pinterest="{{pinterest}}" /]',
		'popup_title' => __('Insert Social Link Shortcode', THEME_FX)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('social_links', 'fresh_shortcode_social_links');

	function fresh_shortcode_social_links( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'facebook' => '',
			'twitter' => '',
			'google_plus' => '',
			'linkedin' => '',
			'github' => '',
			'pinterest' => ''
		), $atts));

		$out = '';

		$out .= '<ul class="social-links">';
		if( $facebook ) { $out .= '<li class="facebook"><a href="'. $facebook .'"><i class="icon-facebook icon-large"></i></a></li>'; }
		if( $twitter ) { $out .= '<li class="twitter"><a href="'. $twitter .'"><i class="icon-twitter icon-large"></i></a></li>'; }
		if( $google_plus ) { $out .= '<li class="google-plus"><a href="'. $google_plus .'"><i class="icon-google-plus icon-large"></i></a></li>'; }
		if( $linkedin ) { $out .= '<li class="linkedin"><a href="'. $linkedin .'"><i class="icon-linkedin icon-large"></i></a></li>'; }
		if( $github ) { $out .= '<li class="github"><a href="'. $github .'"><i class="icon-github icon-large"></i></a></li>'; }
		if( $pinterest ) { $out .= '<li class="pinterest"><a href="'. $pinterest .'"><i class="icon-pinterest icon-large"></i></a></li>'; }
		$out .= '</ul>';
		
		return $out;
	}