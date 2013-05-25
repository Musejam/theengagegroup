<?php


/**
 * Admin Tab Navigation
 */
function freshframework_tab_nav() {

	/* Gets option setttings */
	$freshframework_settings = get_option('freshthemes');
	$options = freshframework_options();

	/* Default variables */
	$menu = '';
	$prev_heading_key = 0;
	$menu_items = '';
	$headings = '';

	/* Populate heading and sub heading */
	foreach($options as $key => $val) {
		if ($val['type'] == 'heading' || $val['type'] == 'subheading') {
			$headings[] = $val;
		}
	}

	if( is_array($headings) ) {
		foreach($headings as $key => $val) {
			$token = 'fresh_panel_option_'. preg_replace( '/[^a-zA-Z0-9\s]/', '', strtolower(trim(str_replace(' ', '', $val['name']))) );
			$val['token'] = $token;
			
			if ( $val['type'] == 'heading' ) {
				$menu_items[$token] = $val;
				$prev_heading_key = $token;
			}
			
			if ( $val['type'] == 'subheading' ) {
				$menu_items[$prev_heading_key]['children'][] = $val;
			}
		}
	}

	/* Create menu structure */
	if ( is_array($menu_items) && count($menu_items) > 0 ) {
		foreach ($menu_items as $key => $val) {
			$class = ( isset($val['icon']) && $val['icon'] != '' ) ? $val['icon'] : '';
			$class = ( isset($val['children']) && $val['children'] != '' ) ? $class . ' has_children' : $class;
			$click_hook = ( isset($val['token']) && $val['token'] != '' ) ? $val['token'] . '_trigger': '';

			$menu .= '<li id="'. $click_hook .'" class="top_level '. $class .'"><span class="effect"></span><span class="arrow"></span>';
			
			if ( isset( $val['icon'] ) && ( $val['icon'] != '' ) ) {
				$menu .= '<span class="icon icon-'. $val['icon'] .'"></span>';
			}

			$menu .= '<a href="#'. $val['token'] .'">'. esc_html($val['name']) .'</a>';

			if ( isset($val['children']) && count($val['children']) > 0 ){
				$menu .= '<ul class="submenu">';
					foreach ( $val['children'] as $child ) {
						$click_hook = $child['token'] . '_trigger';
						$menu .= '<li id="'. $click_hook .'" class="icon"><a href="#'. $child['token'] .'">'. esc_html($child['name']) .'</a></li>';
					}
				$menu .= '</ul>';
			}

			$menu .= '</li>';
		}

		$menu .= '<li class="white_border"></li>';
	}

	return $menu;
}


/**
 * Admin Page Options Fields
 */
function freshframework_fields() {

	/* Include global allowedtags */
	global $allowedtags;

	/* Gets option setttings */
	$freshframework_settings = get_option('freshthemes');
	$option_name = ( isset($freshframework_settings['id']) ) ? $freshframework_settings['id'] : 'freshframework';
	$option_data = get_option($option_name);
	$option_fields = freshframework_options();

	/* Default variables */
	$counter = 0;
	$select_value = '';
	$checked = '';
	$output = '';

	/* Ensure options_fields is an array */
	if( is_array($option_fields) ) {

		/* Field loop */
		foreach ($option_fields as $field) {
			
			/* Join counter */
			$counter++;

			/* Set configurations to be a variables */
			$id = isset($field['id']) ? $field['id'] : '';
			$name = isset($field['name']) ? $field['name'] : '';
			$desc = isset($field['desc']) ? $field['desc'] : '';
			$type = isset($field['type']) ? $field['type'] : '';
			$std = isset($field['std']) ? $field['std'] : '';
			$settings = isset($field['settings']) ? $field['settings'] : false;
			$options = isset($field['options']) ? $field['options'] : false;
			$class = isset($field['class']) ? ' '. $field['class'] : '';

			/* If value empty let\'s use standard value. */
			$value = $std;
			if ($type != 'heading' && $type != 'subheading' && $type != 'info') {
				if ( isset( $option_data[($id)]) ) {
					$value = $option_data[($id)];
					
					if (!is_array($value)) {
						$value = stripslashes($value);
					}
				}
			}


			/* Create tab */
			if ($type != 'heading' && $type != 'subheading' && $type != 'info') {
				$section_id = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($id) );
				$section_id = 'fresh_panel_section_' . $section_id;
				$section_class = 'fresh_panel_section fresh_panel_section_'. $type . $class;

				$output .= '<div id="'. esc_attr($section_id) .'" class="'. esc_attr($section_class) .' clearfix">' . "\n";
				if ( $name ) 
				$output .= '<h4 class="fresh_panel_section_heading">'. esc_html($name) .'</h4>'."\n";
				$output .= '<div class="option clearfix">' . "\n";
			}


			/* Switch field type. */
			switch ($type):


				/* Heading */
				case 'heading':
					if ($counter >= 2) {
						$output .= '</div><!-- tab -->';
					}

					$click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($name) );
					$click_hook = 'fresh_panel_option_'. $click_hook;
					
					$output .= '<div class="fresh_panel_tab" id="'. esc_attr($click_hook) .'">';
					$output .= '<h3>'. esc_html($name) .'</h3>';
					break;



				/* Sub Heading. */
				case 'subheading':
					if ($counter >= 2) {
						$output .= '</div><!-- tab -->';
					}
					$click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($name) );
					$click_hook = 'fresh_panel_option_'. $click_hook;
					
					$output .= '<div class="fresh_panel_tab" id="'. esc_attr($click_hook) .'">';
					$output .= '<h3>'. esc_html($name) .'</h3>';
					break;



				/* Info */
				case 'info':
					$output .= '<div class="info">';
					$output .= '<h4>'. $name .'</h4>';
					$output .= '<p>'. $desc .'</p>';
					$output .= '</div>';
					break;



				/* Text Input */
				case 'text':
					$output .= '<input type="text" id="'. esc_attr($id) .'" class="fresh_panel_input fresh_panel_text" name="'. esc_attr($option_name . '['.$id.']') .'" value="'. esc_attr($value) .'" />';
					break;



				/* Textarea */
				case 'textarea':
					$rows = '8';

					if ( isset( $settings['rows'] ) ) {
						$custom_rows = $settings['rows'];

						if ( is_numeric($custom_rows) ) {
							$rows = $custom_rows;
						}
					}
					$output .= '<textarea id="'. esc_attr($id) .'" class="fresh_panel_input fresh_panel_textarea" name="'. esc_attr($option_name .'['. $id .']') .'" rows="'. $rows .'">'. esc_textarea($value) .'</textarea>';
					break;



				/* Select */
				case 'select':
					$output .= '<select id="'. esc_attr($id) .'" class="fresh_panel_input fresh_panel_select" name="'. esc_attr($option_name . '['. $id .']') .'">';
						foreach ($options as $key => $option ) {
							$selected = '';

							if ( $value != '' ) {
								if ($value == $key){
									$selected = ' selected="selected"';
								}
							}
							$output .= '<option'. $selected .' value="'. esc_attr($key) .'">'. esc_html($option) .'</option>';
						}
					$output .= '</select>';
					break;



				/* Radio */
				case 'radio':
					foreach ($options as $key => $option) {
						$input_id = $option_name . '_' . $id .'_'. $key;
						$output .= '<label for="' . esc_attr($input_id) . '"><input type="radio" class="fresh_panel_input fresh_panel_radio" name="'. esc_attr($option_name .'['. $id .']') .'" id="'. esc_attr($input_id) .'" value="'. esc_attr($key) .'" '. checked($value, $key, false) .' /><span>'. esc_html($option) .'</span></label>';
					}
					break;



				/* Checkbox. */
				case 'checkbox':
					$output .= '<label for="'. esc_attr($id) .'"><input id="'. esc_attr($id) .'" class="fresh_panel_input fresh_panel_checkbox" type="checkbox" name="'. esc_attr($option_name .'['. $id .']') .'" '. checked($value, true, false) .' /><span>'. wp_kses($desc, $allowedtags) .'</span></label>';
					break;



				/* Multicheck */
				case 'multicheck':
					foreach ($options as $key => $option) {
						$checked = '';
						$label = $option;
						$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));
						$input_id = $option_name .'-'. $id .'-'. $option;
						$input_name = $option_name .'['. $id .']['. $option .']';

						if ( isset($value[$option]) ) {
							$checked = checked($value[$option], 1, false);
						}

						$output .= '<label for="'. esc_attr($input_id) .'"><input type="checkbox" id="'. esc_attr($input_id) .'" class="fresh_panel_input fresh_panel_checkbox" name="'. esc_attr($input_name) .'" '. $checked .' /><span>'. esc_html($label) .'</span></label>';
					}
					break;



				/* Color Picker */
				case 'color':
					$output .= '<div class="colorwrapper">';
					$output .= '<div class="colorSelector"><div style="'. esc_attr('background-color:'. $value) .'"></div></div>';
					$output .= '<input type="text" name="'. esc_attr($option_name . '['. $id .']' ) .'" id="'. esc_attr($id) .'" class="fresh_panel_input fresh_panel_color" id="'. esc_attr($id) .'" value="'. $value .'">';
					$output .= '</div>';
					break;



				/* Toggle ON/OFF */
				case 'toggle':
					$output .= '<input type="radio" id="'. esc_attr($id) .'_on" class="fresh_panel_input fresh_panel_toggle" name="'. esc_attr($option_name .'['. $id .']') .'" value="on" '. checked($value, 'on', false) .' />';

					$output .= '<input type="radio" id="'. esc_attr($id) .'_off" class="fresh_panel_input fresh_panel_toggle" name="'. esc_attr($option_name .'['. $id .']') .'" value="off" '. checked($value, 'off', false) .' />';

					$on_selected = $value == 'on' ? ' selected' : '';
					$off_selected = $value == 'off' ? ' selected' : '';
					$output .= '<label class="toggle_on'. $on_selected .'" for="'. esc_attr($id) .'_on"><span>'. __('Enable', THEME_FX) .'</span></label>';
					$output .= '<label class="toggle_off'. $off_selected .'" for="'. esc_attr($id) .'_off"><span>'. __('Disable', THEME_FX) .'</span></label>';
					break;



				/* Image Selector */
				case 'images':
					$n = $option_name .'['. $id .']';
					foreach ( $options as $key => $option ) {
						$checked = ( $value == $key ) ? ' checked="checked"' : '';
						$selected = ( $value == $key ) ? ' selected' : '';

						$output .= '<input type="radio" id="'. esc_attr($id .'_'. $key) .'" class="fresh_panel_img_radio" value="' . esc_attr( $key ) .'" name="'. esc_attr($n) .'" '. $checked .' />';
						$output .= '<div class="fresh_panel_img_label">' . esc_html( $key ) .'</div>';
						$output .= '<img src="'. esc_url( $option ) .'" alt="'. $option .'" class="fresh_panel_img_img'. $selected .'" onclick="document.getElementById(\''. esc_attr($id .'_'. $key) .'\').checked=true;" />';
					}
					break;



				/* Slider */
				case 'slider':
					$value = $value != '' ? (int) $value : '0';

					$output .= '<input type="hidden" id="'. esc_attr($id) .'" name="'. esc_attr($option_name .'['. $id .']') .'" class="fresh_panel_slider_input" value="'. esc_attr($value) .'" />';
					$output .= '<div class="fresh_panel_input fresh_panel_slider"></div>';
					$output .= '<div class="fresh_panel_slider_val"><span>'. esc_attr($value) .'</span>px</div>';
					break;



				/* File Uploader */
				case 'upload':

					$uploader_args = array(
						'id' => esc_attr($id),
						'class' => 'fresh_panel_input fresh_panel_upload upload',
						'name' => esc_attr($option_name .'['. $id .']'),
						'value' => $value
					);
					$output .= freshframework_uploader($uploader_args);

					//$output .= freshframework_uploader( $id, $value, null );
					break;



				/* Gallery */
				case 'multiupload':
				
					$output .= '<ul class="multi_upload">';
					$output .= freshframework_multiple_uploader($id, $option_name .'['. $id .'][]', $value);
					$output .= '</ul>';
					$output .= '<a class="add_row button" href="#">'. __('Add Image', THEME_FX) .'</a>';

					break;



				/* Sidebar Manager */
				case 'sidebar':
					$output .= '<input class="fresh_panel_input fresh_panel_text fresh_panel_sidebar_name" name="sidebar_name" type="text" placeholder="'. __('Enter sidebar name', THEME_FX) .'" />';
                    $output .= '<a class="fresh_panel_add_sidebar button button-primary" href="#">'. __('Add Sidebar', THEME_FX) .'</a>';

                    $output .= '<div class="fresh_panel_sidebars">';
                    $output .= '<ul>';
                    $output .= '<li class="hidden"><input type="hidden" id="'. esc_attr($option_name .'['. $id .']') .'" value=""/><a href="#" class="fresh_panel_remove_sidebar">Remove</a></li>';  

                    $sidebars = $value;

                    if(is_array($sidebars) && !empty($sidebars)) {

                    	foreach ($sidebars as $sidebar) {
                    		$output .= '<li><input type="hidden" name="'. esc_attr($option_name .'['. $id .'][]') .'" value="'. $sidebar .'"/><div class="sidebar_item">'. esc_attr($sidebar) .'</div><a href="#" class="button fresh_panel_remove_sidebar">Remove</a></li>';  
                    	}
                    }

                    $output .= '</ul>';
                    $output .= '</div>';
					break;



				/* Background */
				case 'background':
					$bg = $value;
					$bg_color = isset($bg['color']) ? $bg['color'] : '';
					$bg_image = isset($bg['image']) ? $bg['image'] : '';
					$bg_rep = isset($bg['repeat']) ? $bg['repeat'] : '';
					$bg_pos = isset($bg['position']) ? $bg['position'] : '';
					$bg_att = isset($bg['attachment']) ? $bg['attachment'] : '';

					/* Background color */
					$output .= '<div class="colorwrapper">';
					$output .= '<div class="colorSelector"><div style="'. esc_attr('background-color:'. $bg_color).'"></div></div>';
					$output .= '<input type="text" name="'. esc_attr($option_name . '['. $id .'][color]') .'" id="'. esc_attr($id) .'" class="fresh_panel_input fresh_panel_color" id="'. esc_attr($id) .'" value="'. $bg_color .'">';
					$output .= '</div>';

					/* Background image */
					$uploader_args = array(
						'id' => esc_attr($id) . '_image',
						'class' => 'fresh_panel_input fresh_panel_background_image fresh_panel_upload upload',
						'name' => esc_attr($option_name .'['. $id .'][image]'),
						'value' => $bg_image
					);
					$output .= freshframework_uploader($uploader_args);

					/* Background properties */
					$class = 'background_properties fresh_panel_background_properties';
					if ( '' == $bg_image ) {
						$class .= ' hidden';
					}
					$output .= '<div class="'. esc_attr($class) .'">';
						/* Background repeat */
						$output .= '<select class="fresh_panel_input fresh_panel_background fresh_panel_background_repeat" name="'. esc_attr($option_name .'['. $id .'][repeat]') .'" id="'. esc_attr( $id .'_repeat') .'">';
						$repeats = freshframework_recognized_background_repeat();

						foreach ($repeats as $key => $repeat) {
							$output .= '<option value="'. esc_attr($key) .'" '. selected($bg_rep, $key, false) .'>'. esc_html($repeat) . '</option>';
						}
						$output .= '</select>';

						/* Background postition */
						$output .= '<select class="fresh_panel_input fresh_panel_background fresh_panel_background_position" name="'. esc_attr($option_name .'['. $id .'][position]') .'" id="'. esc_attr($id . '_position') .'">';

						$positions = freshframework_recognized_background_position();

						foreach ($positions as $key=>$position) {
							$output .= '<option value="'. esc_attr($key) .'" '. selected( $bg_pos, $key, false ) .'>'. esc_html($position) . '</option>';
						}
						$output .= '</select>';

						/* Background attachment */
						$output .= '<select class="fresh_panel_input fresh_panel_background fresh_panel_background_attachment" name="'. esc_attr($option_name .'['. $id .'][attachment]') .'" id="'. esc_attr($id . '_attachment') .'">';

						$attachments = freshframework_recognized_background_attachment();

						foreach ($attachments as $key=>$attachment) {
							$output .= '<option value="'. esc_attr($key) .'" '. selected($bg_att, $key, false) .'>'. esc_html($attachment) .'</option>';
						}
						$output .= '</select>';
					$output .= '</div>';
					break;



				/* Typography */
				case 'typography':
					unset($font_size, $font_style, $font_face, $font_color);
					$typography_defaults = array('size' => '', 'face' => '', 'style' => '', 'color' => '');
					$typography_stored = wp_parse_args($value, $typography_defaults);
					
					$typography_options = array(
						'color' => true,
						'sizes' => freshframework_recognized_font_sizes(),
						'faces' => freshframework_recognized_font_faces(),
						'styles' => freshframework_recognized_font_styles()
					);

					if ( isset($options) ) {
						$typography_options = wp_parse_args( $options, $typography_options );
					}

					/* Font color */
					if ( $typography_options['color'] ) {
						$font_color = '<div class="colorwrapper"><div class="colorSelector"><div style="'. esc_attr('background-color:'. $typography_stored['color']).'"></div></div><input type="text" name="'. esc_attr($option_name . '['. $id .'][color]') . '" id="'. esc_attr($id) .'_color" class="fresh_panel_input fresh_panel_color fresh_panel_typography_color" id="'. esc_attr($id) .'" value="'. $typography_stored['color'] .'"></div>';
					}

					/* Font size */
					if ( $typography_options['sizes'] ) {
						$font_size = '<select class="fresh_panel_input fresh_panel_typography fresh_panel_typography_size" name="' . esc_attr($option_name . '['. $id .'][size]') .'" id="'. esc_attr($id . '_size') .'">';
						$sizes = $typography_options['sizes'];
						foreach ($sizes as $i) {
							$size = $i . 'px';
							$font_size .= '<option value="'. esc_attr($size) .'" '. selected($typography_stored['size'], $size, false) .'>'. esc_html($size) .'</option>';
						}
						$font_size .= '</select>';
					}

					/* Font face */
					if ( $typography_options['faces'] ) {
						$font_face = '<select class="fresh_panel_input fresh_panel_typography fresh_panel_typography_face" name="'. esc_attr($option_name . '['. $id .'][face]') .'" id="'. esc_attr( $id .'_face' ) .'">';
						$faces = $typography_options['faces'];
						foreach ($faces as $key => $face) {
							$font_face .= '<option value="'. esc_attr($key) . '" '. selected($typography_stored['face'], $key, false) .'>'. esc_html($face) .'</option>';
						}
						$font_face .= '</select>';
					}

					/* Font style */
					if ( $typography_options['styles'] ) {
						$font_style = '<select class="fresh_panel_input fresh_panel_typography fresh_panel_typography_style" name="'.$option_name.'['.$id.'][style]" id="'. $id.'_style">';
						$styles = $typography_options['styles'];
						foreach ( $styles as $key => $style ) {
							$font_style .= '<option value="'. esc_attr($key) . '" ' . selected($typography_stored['style'], $key, false ) .'>'. $style .'</option>';
						}
						$font_style .= '</select>';
					}

					$typography_fields = compact('font_color', 'font_size', 'font_face', 'font_style');
					$typography_fields = apply_filters('fresh_panel_typography_fields', $typography_fields, $typography_stored, $option_name, $value);
					$output .= implode('', $typography_fields);
					break;



				/* WYSIWYG Editor */
				case 'editor':
					$textarea_name = esc_attr( $option_name . '['. $id .']' );
					$default_editor_settings = array(
						'textarea_name' => $textarea_name,
						'media_buttons' => false,
						'tinymce' => array( 'plugins' => 'wordpress' )
					);
					$editor_settings = array();
					if ( isset( $settings ) ) {
						$editor_settings = $settings;
					}
					$editor_settings = array_merge($editor_settings, $default_editor_settings);
					ob_start();
					wp_editor( $value, $id, $editor_settings );
					$output .= ob_get_clean();
					break;



			endswitch; 
			/* Endswitch */


			/* Closing option div */
			if ($type != 'heading' && $type != 'subheading' && $type != 'info') {
				$output .= '</div><!-- option -->';

				if ($type != 'checkbox' && $type != 'info' && $desc != ''){
					$output .= '<div class="explain">'. wp_kses($desc, $allowedtags) .'</div><!-- explain -->';
				}

				$output .= '</div>';
			}

		}

		$output .= '</div><!-- tab -->';
	}
		
	return $output;
}