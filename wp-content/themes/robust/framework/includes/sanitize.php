<?php

/**
 * Default sanitization 
 * 
 * Returns the original value as output.
 */
function freshframework_sanitize_default($input) {
	$output = $input;
	return $output;
}

/* Sanitize text input */
add_filter('freshframework_sanitize_text', 'sanitize_text_field');

/* Sanitize textarea */
add_filter('freshframework_sanitize_textarea', 'freshframework_sanitize_default');

/* Sanitize toggle */
add_filter('freshframework_sanitize_toggle', 'freshframework_sanitize_default');

/* Sanitize multi upload */
add_filter('freshframework_sanitize_multiupload', 'freshframework_sanitize_default');



/**
 * Array sanitization 
 * 
 * Remove duplicate array value
 * Or return array if the value is a string.
 *
 * @return array_unique
 *
 */
function freshframework_sanitize_array($input) {
	if( is_array($input) )
		return array_unique($input);
	else 
		return array();
}

/* Sanitize sidebars */
add_filter('freshframework_sanitize_sidebar', 'freshframework_sanitize_array');



/**
 * enum sanitization
 *
 * Check that the key value sent is valid.
 */
function freshframework_sanitize_enum($input, $option) {
	$output = '';
	if ( array_key_exists($input, $option['options']) ) {
		$output = $input;
	}
	return $output;
}

/* Sanitize select field */
add_filter('freshframework_sanitize_select', 'freshframework_sanitize_enum', 10, 2);

/* Sanitize radio input */
add_filter('freshframework_sanitize_radio', 'freshframework_sanitize_enum', 10, 2);

/* Sanitize image selector input */
add_filter('freshframework_sanitize_images', 'freshframework_sanitize_enum', 10, 2);



/**
 * Checkbox Sanitization
 *
 */

function freshframework_sanitize_checkbox($input) {
	if ($input) {
		$output = true;
	} else {
		$output = false;
	}
	return $output;
}

/* Sanitize checkbox */
add_filter('freshframework_sanitize_checkbox', 'freshframework_sanitize_checkbox');



/**
 * Multicheck Sanitization 
 *
 */
function freshframework_sanitize_multicheck( $input, $option ) {
	$output = '';
	if ( is_array( $input ) ) {
		foreach( $option['options'] as $key => $value ) {
			$output[$key] = "0";
		}
		foreach( $input as $key => $value ) {
			if ( array_key_exists( $key, $option['options'] ) && $value ) {
				$output[$key] = "1";
			}
		}
	}
	return $output;
}

/* Sanitize multicheck */
add_filter('freshframework_sanitize_multicheck', 'freshframework_sanitize_multicheck', 10, 2);



/**
 * Numeric Sanitization
 *
 */
function freshframework_sanitize_numeric($input) {
	if( is_numeric($input))
		return $input;
}

/* Sanitize Slider */
add_filter('freshframework_sanitize_slider', 'freshframework_sanitize_numeric');



/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @param string Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param string The value that this function should return if it cannot be recognized as a color.
 * @return string
 *
 */
function freshframework_sanitize_hex( $hex, $default = '' ) {
	if ( freshframework_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}



/**
 * Is a given string a color formatted in hexidecimal notation?
 *
 * @param string Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return bool
 *
 */
function freshframework_validate_hex( $hex ) {
	$hex = trim( $hex );
	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	}
	elseif ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	}
	else {
		return true;
	}
}

/* Sanitize Color */
add_filter('freshframework_sanitize_color', 'freshframework_sanitize_hex');



/**
 * Upload Sanitization
 *
 */
function freshframework_sanitize_upload($input) {
	$output = '';
	$filetype = wp_check_filetype($input);
	if ( $filetype["ext"] ) {
		$output = $input;
	}
	return $output;
}

/* Sanitize upload */
add_filter('freshframework_sanitize_upload', 'freshframework_sanitize_upload');



/**
 * Editor Sanitization
 *
 */
function freshframework_sanitize_editor($input) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedtags;
		$output = wpautop(wp_kses( $input, $allowedtags));
	}
	return $output;
}

/* Sanitize editor */
add_filter('freshframework_sanitize_editor', 'freshframework_sanitize_editor');



/**
 * Background sanitization
 * 
 */
function freshframework_sanitize_background( $input ) {
	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );

	$output['color'] = apply_filters('freshframework_sanitize_hex', $input['color']);
	$output['image'] = apply_filters('freshframework_sanitize_upload', $input['image']);
	$output['repeat'] = apply_filters('freshframework_background_repeat', $input['repeat']);
	$output['position'] = apply_filters('freshframework_background_position', $input['position']);
	$output['attachment'] = apply_filters('freshframework_background_attachment', $input['attachment']);

	return $output;
}

/* Sanitize background */
add_filter('freshframework_sanitize_background', 'freshframework_sanitize_background');



/**
 * Background Repeat Sanitization
 * 
 */
function freshframework_recognized_background_repeat() {
	$default = array(
		'no-repeat' => __('No Repeat', THEME_FX),
		'repeat-x' => __('Repeat Horizontally', THEME_FX),
		'repeat-y' => __('Repeat Vertically', THEME_FX),
		'repeat' => __('Repeat All', THEME_FX),
		);
	return apply_filters('freshframework_recognized_background_repeat', $default);
}

function freshframework_sanitize_background_repeat($value) {
	$recognized = freshframework_recognized_background_repeat();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'freshframework_default_background_repeat', current($recognize ) );
}

/* Sanitize background repear */
add_filter('freshframework_background_repeat', 'freshframework_sanitize_background_repeat');



/**
 * Background Position Sanitization
 * 
 */
function freshframework_recognized_background_position() {
	$default = array(
		'top left' => __('Top Left', THEME_FX),
		'top center' => __('Top Center', THEME_FX),
		'top right' => __('Top Right', THEME_FX),
		'center left' => __('Middle Left', THEME_FX),
		'center center' => __('Middle Center', THEME_FX),
		'center right' => __('Middle Right', THEME_FX),
		'bottom left' => __('Bottom Left', THEME_FX),
		'bottom center' => __('Bottom Center', THEME_FX),
		'bottom right' => __('Bottom Right', THEME_FX)
		);
	return apply_filters('freshframework_recognized_background_position', $default);
}

function freshframework_sanitize_background_position($value) {
	$recognized = freshframework_recognized_background_position();
	if ( array_key_exists($value, $recognized) ) {
		return $value;
	}
	return apply_filters('freshframework_default_background_position', current($recognized));
}

/* Sanitize background position */
add_filter('freshframework_background_position', 'freshframework_sanitize_background_position');



/**
 * Background Attachment Sanitization
 * 
 */
function freshframework_recognized_background_attachment() {
	$default = array(
		'scroll' => __('Scroll Normally', THEME_FX),
		'fixed'  => __('Fixed in Place', THEME_FX)
		);
	return apply_filters('freshframework_recognized_background_attachment', $default);
}

function freshframework_sanitize_background_attachment($value) {
	$recognized = freshframework_recognized_background_attachment();
	if ( array_key_exists($value, $recognized) ) {
		return $value;
	}
	return apply_filters('freshframework_default_background_attachment', current($recognized));
}

/* Sanitize background attachment */
add_filter('freshframework_background_attachment', 'freshframework_sanitize_background_attachment');



/**
 * Typography Sanitization
 * 
 */
function freshframework_sanitize_typography($input, $option) {
	$output = wp_parse_args( $input, array(
		'size'  => '',
		'face'  => '',
		'style' => '',
		'color' => ''
	) );

	if ( isset($option['options']['faces']) && isset($input['face']) ) {
		if ( !(array_key_exists($input['face'], $option['options']['faces']))) {
			$output['face'] = '';
		}
	}
	else {
		$output['face']  = apply_filters('freshframework_font_face', $output['face']);
	}

	$output['size']  = apply_filters('freshframework_font_size', $output['size'] );
	$output['style'] = apply_filters('freshframework_font_style', $output['style'] );
	$output['color'] = apply_filters('freshframework_sanitize_color', $output['color']);

	return $output;
}

/* Sanitize typography */
add_filter('freshframework_sanitize_typography', 'freshframework_sanitize_typography', 10, 2);



/**
 * Font Size Sanitization
 * 
 */
function freshframework_recognized_font_sizes() {
	$sizes = range(9, 72);
	$sizes = apply_filters('freshframework_recognized_font_sizes', $sizes);
	$sizes = array_map('absint', $sizes);
	return $sizes;
}

function freshframework_sanitize_font_size($value) {
	$recognized = freshframework_recognized_font_sizes();
	$value_check = preg_replace('/px/','', $value);

	if ( in_array((int)$value_check, $recognized) ) {
		return $value;
	}
	return apply_filters('freshframework_default_font_size', $recognized);
}

/* Sanitize font size */
add_filter('freshframework_font_size', 'freshframework_sanitize_font_size');



/**
 * Font Face Sanitization
 * 
 */
function freshframework_recognized_font_faces() {
	$default = array(
		'arial'     => 'Arial',
		'verdana'   => 'Verdana, Geneva',
		'trebuchet' => 'Trebuchet',
		'georgia'   => 'Georgia',
		'times'     => 'Times New Roman',
		'tahoma'    => 'Tahoma, Geneva',
		'palatino'  => 'Palatino',
		'helvetica' => 'Helvetica*'
	);
	return apply_filters('freshframework_recognized_font_faces', $default);
}

function freshframework_sanitize_font_face( $value ) {
	$recognized = freshframework_recognized_font_faces();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters('freshframework_default_font_face', current($recognized));
}

/* Sanitize font face */
add_filter('freshframework_font_face', 'freshframework_sanitize_font_face');



/**
 * Font Style Sanitization
 * 
 */
function freshframework_recognized_font_styles() {
	$default = array(
		'normal'      => __('Normal', THEME_FX),
		'italic'      => __('Italic', THEME_FX),
		'bold'        => __('Bold', THEME_FX ),
		'bold italic' => __('Bold Italic', THEME_FX)
	);
	return apply_filters('freshframework_recognized_font_styles', $default);
}

function freshframework_sanitize_font_style($value) {
	$recognized = freshframework_recognized_font_styles();
	if ( array_key_exists($value, $recognized) ) {
		return $value;
	}
	return apply_filters('freshframework_default_font_style', current($recognized));
}

/* Sanitize font style */
add_filter('freshframework_font_style', 'freshframework_sanitize_font_style');