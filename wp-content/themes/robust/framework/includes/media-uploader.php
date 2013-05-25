<?php

if ( !function_exists('freshframework_uploader') ) :

	function freshframework_uploader($args = '') {


		$defaults = array(
			'id' => '',
			'class' => '',
			'name' => '',
			'value' => '',
			'screenshot' => true
		);

		$arg = wp_parse_args ($args, $defaults);
		$output = '';


		//print_r($arg);


		$output .= '<input type="text" id="' . $arg['id'] . '" class="' . $arg['class'] . '" name="' . $arg['name'] . '" value="' . $arg['value'] . '" placeholder="' . __('No file chosen', THEME_FX) .'" />';

		$upload_button = ($arg['value'] == '') ? '<input id="upload_'. $arg['id'] .'" class="upload_button button" type="button" value="'. __('Upload', THEME_FX) .'" />' : '<input id="remove_'. $arg['id'] .'" class="remove_file button" type="button" value="'. __('Remove', THEME_FX) .'" />';

		$output .= $upload_button;

		if( $arg['screenshot'] ) {

			$output .= '<div class="screenshot'. ($arg['value'] == '' ? ' hidden' : '') .' clearfix" id="'. $arg['id'] .'_images">';
				$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $arg['value'] );

				if ($image || $image ) {
					$output .= '<img src="'. $arg['value'] .'" alt="" />';
				}
			$output .= '</div>';

		}

		return $output;
	}

endif;


if ( !function_exists('freshframework_multiple_uploader') ) :

	function freshframework_multiple_uploader($id = '', $name = '', $values = false) {
		$output = '';
		$i = 0;
		$output .= '<li class="hidden">
					<input type="hidden" data-id="'. $id .'" data-name="'. $name .'" value="">
					</li>';
					
		if( $values ) {
			foreach ($values as $value) {
				$i++;

				if( !is_numeric($value) ) {
					$img = wp_get_attachment_image_src(freshthemes_get_attachement_id($value), 'thumbnail');
				}
				else {
					$img = wp_get_attachment_image_src($value, 'thumbnail');
				}

				$output .= '<li>
							<input id="'. $id .'_'. $i .'" type="hidden" name="'. $name .'" value="'. $value .'">
							<img src="'. $img[0] .'" />
							<a class="remove_image">Remove</a>
							</li>';
			}
		}

		return $output;
	}

endif;

/**
 * Enqueue scripts for file uploader
 */
if ( !function_exists('freshframework_media_scripts') ) :
	add_action( 'admin_enqueue_scripts', 'freshframework_media_scripts' );

	function freshframework_media_scripts(){
		if ( function_exists('wp_enqueue_media') ) {
			wp_enqueue_media();
		}
		else {
			wp_enqueue_script('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_style('thickbox');
		}

		//wp_register_script('freshframework_media_uploader', THEME_DIR .'framework/javascripts/media-uploader.js', array('jquery'));
		wp_enqueue_script('freshframework_media_uploader');
		wp_localize_script('freshframework_media_uploader', 'freshframework_uploader_l10n', array(
			'upload' => __('Upload', THEME_FX),
			'remove' => __('Remove', THEME_FX),
			'title' => __('Select Image', THEME_FX)
		) );
	}
endif;
