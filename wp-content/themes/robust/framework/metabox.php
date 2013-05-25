<?php

/**
 * Fresh Framework Metabox
 *
 * @version 1.4
 * @author Rifki Aria Gumelar
 * @copyright 2013, www.rifki.net / www.freshthemes.net
 * 
 **/

/**
 * Initialize Fresh Metabox
 */

add_action('init', 'fresh_metabox_init', 9999);

function fresh_metabox_init() {


	/**
	 * Registers Metaboxes
	 */
	if( class_exists('FreshMetabox') ) {

		/* Include meta box configurations */
		$config = THEME_PATH . '/functions/theme-metaboxes.php';

		if( file_exists($config) ) {
			require_once $config;
		}

		/* Init metaboxes */
		$metaboxes = array();
		$metaboxes = apply_filters('freshmetabox', $metaboxes);

		foreach ($metaboxes as $metabox) {
			$theme_metaboxes = new FreshMetabox($metabox);
		}

	}



	/**
	 * Load Styles & Scripts
	 */
	add_action('admin_enqueue_scripts', 'fresh_metabox_load_scripts');

	function fresh_metabox_load_scripts($hook) {

		if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
			
			/* Load scripts */
			wp_enqueue_script(
				'freshframework', 
				THEME_DIR . 'framework/javascripts/framework.js', 
				false, 
				'2.0', 
				false
			);
			wp_enqueue_script(
				'custom_colorpicker', 
				THEME_DIR . 'framework/javascripts/colorpicker.js', 
				false, 
				'2.0', 
				false
			);
			wp_enqueue_script(
				'freshmetabox', 
				THEME_DIR . 'framework/javascripts/metabox.js', 
				array(
					'jquery', 
					'jquery-ui-core', 
					'jquery-ui-slider', 
					'jquery-ui-datepicker'
				)
			);
			wp_localize_script(
				'freshframework', 
				'freshframework_l10n', 
				array(
					'upload' => __('Upload', THEME_FX),
					'remove' => __('Remove', THEME_FX),
					'upload_title' => __('Select Image', THEME_FX),
					'upload_alert' => __('Only image is allowed, please try again!', THEME_FX),
					'confirm_delete' => __('Are you sure?', THEME_FX)
				)
			);
			

			/* Load styles */
			wp_enqueue_style(
				'colorpicker', 
				THEME_DIR . 'framework/stylesheets/colorpicker.css', 
				false, 
				'2.0'
			);
			wp_enqueue_style(
				'freshmetabox', 
				THEME_DIR . 'framework/stylesheets/metabox.css', 
				array('thickbox')
			);
		}

	}

}



/**
 * Fresh Metabox Class
 *
 */

class FreshMetabox {

	protected $_metabox;


	/**
	 * Construct
	 */
	public function __construct($metabox) {

		if( !is_admin() ) 
			return;

		$this->_metabox = $metabox;

		add_action('add_meta_boxes', array(&$this, 'register'));
		add_action('save_post', array(&$this, 'save'));

	}


	/**
	 * Register Metabox
	 */
	public function register() {
		$this->_metabox['context'] = empty($this->_metabox['context']) ? 'normal' : $this->_metabox['context'];
		$this->_metabox['priority'] = empty($this->_metabox['priority']) ? 'high' : $this->_metabox['priority'];
		
		foreach ( $this->_metabox['pages'] as $page ) {
			add_meta_box(
				$this->_metabox['id'], 
				$this->_metabox['title'], 
				array(&$this, 'show'), 
				$page, 
				$this->_metabox['context'], 
				$this->_metabox['priority']
			);
		}
	}


	/**
	 * Show Metabox Fields
	 */
	public function show() {
		global $post, $allowedtags;

		/* Create nonce verification */
		echo '<input type="hidden" name="wp_freshmetabox_nonce" value="'. wp_create_nonce( basename(__FILE__) ) .'" />';

		/* Begin fields loop */
		echo '<table class="form-table fresh_metabox">';


		foreach ($this->_metabox['fields'] as $field) {

			/* Set configurations to be a variables */
			$id 	= $field['id'];
			$name 	= $field['name']; 
			$desc 	= (isset($field['desc'])) ? $field['desc'] : ''; 
			$std 	= (isset($field['std'])) ? $field['std'] : '';
			$class 	= 'fresh_metabox_input fresh_metabox_' . $field['type'];
			$class 	= ( isset($field['class']) ) ? $class . ' ' . $field['class'] : $class; 
			$settings = (isset($field['settings'])) ? $field['settings'] : '';
			$options = (isset($field['options'])) ? $field['options'] : '';

			/* If value empty let\'s use standard value. */
			$meta 	= $std;
			if( get_post_meta($post->ID, $id, true) ) {
				$meta 	= get_post_meta($post->ID, $id, true);
				if (!is_array($meta)) {
					$meta = stripslashes($meta);
				}
			}

			/* Begin fields loop */
			echo '<tr id="fresh_metabox_'. esc_attr($id) .'">';
				echo '<th><label for="'. esc_attr($id) .'">'. esc_html($name) .'</label></th>';

				echo '<td>';

				echo '<div class="fresh_metabox_option fresh_metabox_option_'. $field['type'] .'">';
				/* Switch field type */
				switch( $field['type'] ) :


					/* Text */
					case 'text':
						echo '<input type="text" id="'. esc_attr($id) .'" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'" value="'. $meta .'" />';
						break;


					/* Textarea */
					case 'textarea':
						$rows = '5';

						if ( isset( $settings['rows'] ) ) {
							$custom_rows = $settings['rows'];
							if ( is_numeric( $custom_rows ) ) {
								$rows = $custom_rows;
							}
						}

						$meta = stripslashes($meta);
						
						echo '<textarea id="'. esc_attr($id) .'" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'" rows="'. $rows .'">'. esc_textarea($meta) .'</textarea>';
						break;


					/* Checkbox */
					case 'checkbox':
						echo '<label><input type="checkbox" id="'. esc_attr($id) .'" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'"'. checked(!empty($meta), true, false) .'/><span>'. wp_kses($desc, $allowedtags) .'</span></label>';
						break;


					/* Select */
					case 'select':
						echo '<select id="'. esc_attr($id) .'" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'">';
							foreach ($field['options'] as $key => $val) {
								$selected = ( $meta == $key ) ? ' selected="selected"' : '';
								echo '<option'. $selected .' value="'. esc_attr($key) .'">'. esc_html($val) .'</option>';
							}
						echo '</select>';
						break;


					/* Radio */
					case 'radio':
						foreach ( $field['options'] as $key => $val ) {
							$checked = ( $meta == $key ) ? ' checked="checked"' : '';
							echo '<label><input type="radio" id="'. $id .'_'. esc_attr($key) .'" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'" value="'. esc_attr($key) .'"'. $checked .'/><span>'. esc_html($val) .'</span></label>';
						}
						break; 


					case 'toggle':
						echo '<input type="radio" id="'. esc_attr($id) .'_on" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'" value="on" '. checked($meta, 'on', false) .' />';

						echo '<input type="radio" id="'. esc_attr($id) .'_off" class="'. esc_attr($class) .'" name="'. esc_attr($id) .'" value="off" '. checked($meta, 'off', false) .' />';

						$on_selected = $meta == 'on' ? ' selected' : '';
						$off_selected = $meta == 'off' ? ' selected' : '';
						echo '<label class="toggle_on'. $on_selected .'" for="'. esc_attr($id) .'_on"><span>'. __('Enable', THEME_FX) .'</span></label>';
						echo '<label class="toggle_off'. $off_selected .'" for="'. esc_attr($id) .'_off"><span>'. __('Disable', THEME_FX) .'</span></label>';
						break;


					/* Color */
					case 'color':
						echo '<div class="colorwrapper">';
						echo '<div class="colorSelector"><div style="'. esc_attr('background-color:'. $meta) .'"></div></div>';
						echo '<input type="text" name="'. esc_attr($id) .'" id="'. esc_attr($id) .'" class="'. esc_attr($class) .'" value="'. $meta .'">';
						echo '</div>';
						break;


					/* Date */
					case 'date':
						$format = ( isset($field['format']) ) ? $field['format'] : 'MM d, yy';
						echo '<input type="text" id="'. esc_attr($id) .'" class="'. esc_attr($class) .'" name="'. $id .'" rel="'. $format .'" value="'. $meta .'" size="40" />';
						break;


					/* Image Selector */
					case 'images':
						$n = $id;
						foreach ( $options as $key => $option ) {
							$checked = ( $meta == $key ) ? ' checked="checked"' : '';
							$selected = ( $meta == $key ) ? ' selected' : '';

							echo '<input type="radio" id="'. esc_attr($id .'_'. $key) .'" class="fresh_metabox_img_radio" value="' . esc_attr( $key ) .'" name="'. esc_attr($n) .'" '. $checked .' />';
							echo '<div class="fresh_metabox_img_label">' . esc_html( $key ) .'</div>';
							echo '<img src="'. esc_url( $option ) .'" alt="'. $key .'" class="fresh_metabox_img_img'. $selected .'" onclick="document.getElementById(\''. esc_attr($id .'_'. $key) .'\').checked=true;" />';
						}
						break;


					/* Slider */
					case 'slider':
						$meta = $meta != '' ? $meta : '0';

						echo '<input type="hidden" id="'. esc_attr($id) .'" name="'. esc_attr($id) .'" class="fresh_metabox_slider_input" value="'. esc_attr($meta) .'" />';
						echo '<div class="'. esc_attr($class) .'"></div>';
						echo '<div class="fresh_metabox_slider_val"><span>'. esc_attr($meta) .'</span>px</div>';
						break;


					/* Upload */
					case 'upload':
						$uploader_args = array(
							'id' => esc_attr($id),
							'class' => esc_attr($class) . ' upload',
							'name' => esc_attr($id),
							'value' => $meta
						);
						echo freshframework_uploader($uploader_args);
						break;


					/* Gallery */
					case 'multiupload':

						echo '<ul class="multi_upload">';
						echo freshframework_multiple_uploader($id, $id . '[]', $meta);
						echo '</ul>';
						echo '<a class="add_row button" href="#">Add Image</a>';

						break;


					/* Background */
					case 'background' :
						$bg = array();
						if($meta) $bg = $meta;

						$color = (isset($bg['color']) ) ? $bg['color'] : '';
						$image = (isset($bg['image']) ) ? $bg['image'] : '';
						$repeat = (isset($bg['repeat']) ) ? $bg['repeat'] : '';
						$position = (isset($bg['position']) ) ? $bg['position'] : '';
						$attachment = (isset($bg['attachment']) ) ? $bg['attachment'] : '';

						/* Background color */
						echo '<div class="colorwrapper">';
						echo '<div class="colorSelector"><div style="'. esc_attr('background-color:'. $color) .'"></div></div>';
						echo '<input type="text" name="'. esc_attr($id) .'[color]" id="'. esc_attr($id) .'_background_color" class="'. esc_attr($class) .' fresh_metabox_color fresh_metabox_background_color" value="'. $color .'">';
						echo '</div>';

						/* Background Image */
						$uploader_args = array(
							'id' => esc_attr($id) . '_image',
							'class' => esc_attr($class) . ' fresh_metabox_background_image upload',
							'name' => esc_attr($id) . '[image]',
							'value' => $image
						);
						echo freshframework_uploader($uploader_args);


						/* Background properties */
						echo '<div class="fresh_metabox_background_properties background_properties'.( $image != '' ? '' : ' hidden' ).'">';

							/* Background repeat */
							echo '<select id="'.$id.'_background_repeat" class="'. $class .' fresh_metabox_background_repeat" name="'.$id.'[repeat]">';
							$repeat_array = array(
								'repeat' => __('Repeat All', THEME_FX),
								'no-repeat' => __('No Repeat', THEME_FX),
								'repeat-x' => __('Repeat Horizontally', THEME_FX),
								'repeat-y' => __('Repeat Vertically', THEME_FX),
							);
							
							foreach ($repeat_array as $key => $val) {
								echo '<option', $repeat == $key ? ' selected="selected"' : '', ' value="'.$key.'">'.$val.'</option>';
							}
							echo '</select>';

							/* Background position */
							echo '<select name="'.$id.'[position]" id="'.$id.'_background_position" class="'. $class .' fresh_metabox_background_position">';
							$position_array = array(
								'top center' => __('Top Center', THEME_FX),
								'top left' => __('Top Left', THEME_FX),
								'top right' => __('Top Right', THEME_FX),
								'center center' => __('Middle Center', THEME_FX),
								'center left' => __('Middle Left', THEME_FX),
								'center right' => __('Middle Right', THEME_FX),
								'bottom center' => __('Bottom Center', THEME_FX),
								'bottom left' => __('Bottom Left', THEME_FX),
								'bottom right' => __('Bottom Right', THEME_FX)
							);
							
							foreach ($position_array as $key => $val) {
								echo '<option', $position == $key ? ' selected="selected"' : '', ' value="'.$key.'">'.$val.'</option>';
							}
							echo '</select>';

							/* Background attachment */
							echo '<select name="'.$id.'[attachment]" id="'.$id.'_background_attachment" class="'. $class .' fresh_metabox_background_attachment">';
							$attachment_array = array(
								'fixed' => __('Fixed', THEME_FX),
								'scroll' => __('Scroll', THEME_FX)
							);
							
							foreach ($attachment_array as $key => $val) {
								echo '<option', $attachment == $key ? ' selected="selected"' : '', ' value="'.$key.'">'.$val.'</option>';
							}
							echo '</select>';
						echo '</div>';
						break;


				endswitch;
				echo '<div class="clear"></div></div>';

				if ($desc != '' && $field['type'] != 'checkbox') {
					echo '<div class="description">'. wp_kses($desc, $allowedtags) .'</div>';
				}


				echo '</td>';
			echo '</tr>';

		}

		echo '</table>';
	}


	/**
	 * Save Metabox Fields
	 */
	public function save($post_id) {

		/* Security check */
		if ( !isset($_POST['wp_freshmetabox_nonce']) || !wp_verify_nonce( $_POST['wp_freshmetabox_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}

		/* Auto save */
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return $post_id;
		}

		/* Check permission */
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can('edit_page', $post_id) ) {
				return $post_id;
			}
			elseif ( !current_user_can('edit_post', $post_id )) {
				return $post_id;
			}
		}

		/* Save meta data */
		foreach ( $this->_metabox['fields'] as $field ) {
			$old = get_post_meta($post_id, $field['id'], true);

			$new = isset( $_POST[$field['id']] ) ? $_POST[$field['id']] : null;
			
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} 
			elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}

	}

}