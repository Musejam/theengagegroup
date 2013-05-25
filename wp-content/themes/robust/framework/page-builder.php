<?php

/**
 * Fresh Framework Page Builder
 *
 * @version 1.4
 * @author Rifki Aria Gumelar
 * @copyright 2013, www.rifki.net / www.freshthemes.net
 * 
 **/

/**
 * Initialize Page Builder
 */
add_action('admin_init', 'freshbuilder_init');

function freshbuilder_init() {
	add_action( 'add_meta_boxes', 'freshbuilder_register' );
	add_action( 'admin_enqueue_scripts', 'freshbuilder_load_assets', 10, 1 );
}



/**
 * Register Page Builder
 */
function freshbuilder_register() {
	add_meta_box( 
		'freshbuilder', 
		__('Page Builder', THEME_FX), 
		'freshbuilder_editor', 
		'page', 
		'normal', 
		'high' 
	);
}



/**
 * Load Assets
 */
function freshbuilder_load_assets($hook) {
	if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
		wp_enqueue_script('jquery-json', THEME_DIR . 'framework/javascripts/jquery.json.js');
		wp_enqueue_script(
			'freshbuilder', 
			THEME_DIR . 'framework/javascripts/page-builder.js', 
			array('jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-resizable')
		);
		wp_localize_script(
			'freshbuilder', 
			'freshbuilder_l10n', 
			array(
				'remove' => __('Remove', THEME_FX),
				'confirm' => __('Are you sure?', THEME_FX),
				'yes' => __('Yes', THEME_FX),
				'no' => __('No', THEME_FX)
			)
		);

		wp_enqueue_style('freshbuilder', THEME_DIR . 'framework/stylesheets/page-builder.css');
	}
}



/**
 * Page Builder Editor
 */
function freshbuilder_editor() {
	global $post, $freshbuilder_modules;

	$meta_shortcode = get_post_meta( $post->ID, 'freshbuilder_data_shortcode', true );
	$meta_html = get_post_meta( $post->ID, 'freshbuilder_data_html', true );
	?>
	<div id="freshbuilder_editor_wrapper" class="clearfix">
		<input type="hidden" name="wp_freshbuilder_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>" />
		<textarea id="freshbuilder_data_shortcode" name="freshbuilder_data_shortcode" class="hidden" cols="50" rows="12"><?php echo $meta_shortcode; ?></textarea>
		<textarea id="freshbuilder_data_html" name="freshbuilder_data_html" class="hidden" cols="50" rows="12"><?php echo $meta_html; ?></textarea>

		<div id="freshbuilder_modules">
			<?php if ( isset($freshbuilder_modules) && is_array($freshbuilder_modules) ) : ?>
				<select id="freshbuilder_select_module" name="select_module" class="freshbuilder_select_module" >
					<option selected="selected" value=""><?php _e('Select module', THEME_FX) ?></option>
					<?php foreach($freshbuilder_modules as $module => $settings) : ?>
						<option value="<?php echo $module; ?>"><?php echo $settings['name']; ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
			<button id="add_module" class="button button-primary"><?php _e('Add Module', THEME_FX); ?></button>
		</div>

		<div id="freshbuilder_placeholder_wrapper" class="clearfix">
			<div id="freshbuilder_placeholder" class="clearfix">
				<?php 
				if ($meta_html) {
					echo html_entity_decode( html_entity_decode($meta_html) );
				} ?>
			</div>
		</div>
	</div>

	<div id="freshbuilder_lightbox">
		<div class="freshbuilder_lightbox_loader loader"></div>
		<div id="freshbuilder_lightbox_inner">
		</div>
	</div>

	<div class="clear"></div>
	<?php
}



/**
 * Save 
 */
add_action('save_post', 'freshbuilder_save_data');

function freshbuilder_save_data($post_id) {
	if ( !isset($_POST['wp_freshbuilder_nonce']) || !wp_verify_nonce($_POST['wp_freshbuilder_nonce'], basename(__FILE__)) ) {
		return $post_id;
	}
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	
	if ('page' == $_POST['post_type']) {
		if ( !current_user_can('edit_page', $post_id) ) {
			return $post_id;
		}
	}
	else {
		if ( !current_user_can('edit_post', $post_id )) {
			return $post_id;
		}
	}

	$freshbuilder_data = array('freshbuilder_data_shortcode', 'freshbuilder_data_html');

	foreach ($freshbuilder_data as $data ) {
		$old = get_post_meta($post_id, $data, true);
		$new = isset( $_POST[$data] ) ? $_POST[$data] : null;
			
		if ($new && $new != $old) {
			update_post_meta($post_id, $data, $new);
		} 
		elseif ('' == $new && $old) {
			delete_post_meta($post_id, $data, $old);
		}
	}
}



/**
 * Generate Module
 */
function freshbuilder_generate_module($item){
	if (!$item) return;

	global $freshbuilder_modules;

	$module_sizes = array(
		'one_fifth' => '( 1/5 )',
		'one_fourth' => '( 1/4 )',
		'one_third' => '( 1/3 )',
		'two_fifth' => '( 2/5 )',
		'one_half' => '( 1/2 )',
		'three_fifth' => '( 3/5 )',
		'two_third' => '( 2/3 )',
		'three_fourth' => '( 3/4 )',
		'four_fifth' => '( 4/5 )',
		'one_full' => '( 1/1 )', 
	);

	$id = 'module_'. rand(0, 100000);
	$module = $freshbuilder_modules[$item];
	$size = ( isset($module['size']) ) ? $module['size'] : 'one_full';
	$class = "module module_$item module_$size";
	$class = ( isset($module['child']) ) ? "$class has_child" : $class;

	ob_start();
	?>

	<div id="<?php echo $id; ?>" class="<?php echo $class; ?>" data-module="<?php echo $item; ?>" data-size="<?php echo $size; ?>">
		<span class="module_name"><?php echo $module['name']?></span>
		<span class="module_size"><?php echo $module_sizes[$size]?></span>
		<span class="increase_module" title="<?php _e('Increase Size', THEME_FX); ?>">+</span>
		<span class="decrease_module" title="<?php _e('Decrease Size', THEME_FX); ?>">-</span>
		<span class="edit_module" title="<?php _e('Edit Module', THEME_FX); ?>">e</span>
		<span class="remove_module" title="<?php _e('Remove Module', THEME_FX); ?>">x</span>

		<div class="data_settings hidden">
			<?php
			foreach ( $module['options'] as $key => $val ){
				$std = ( isset($val['std']) ) ? $val['std'] : '';
				$class = ( isset($val['is_content']) && $val['is_content'] ) ? ' class="is_content"' : '';

				if ( $key != 'info')
				echo '<div data-option="'.$key.'"'.$class.'>'.$std.'</div>';
			}
			?>
		</div>
		<?php
		if ( isset($module['child']) ){
			echo '<div class="child_data_settings hidden" data-code="'.$module['child_code'].'">';
				echo '<div class="child_data_setting is_default">';
					foreach ( $module['child'] as $key => $val ){
						$std = ( isset($val['std']) ) ? $val['std'] : '';
						$class = ( isset($val['is_content']) && $val['is_content'] ) ? ' class="is_content"' : '';
						echo '<div data-option="'.$key.'"'.$class.'>'.$std.'</div>';
					}
				echo '</div>';
			echo '</div>'; 
		}
		?>
	</div>

	<?php
	return ob_get_clean();
}



/**
 * Get Clean Module
 */
function freshbuilder_print_module($item) {
	return freshbuilder_generate_module($item);
}



/**
 * Ajax Get Clean Module
 */
add_action('wp_ajax_freshbuilder_print_module', 'freshbuilder_ajax_print_module');

function freshbuilder_ajax_print_module() {
	echo freshbuilder_print_module($_POST['module']);
	exit;
}



/**
 * Get Module Options Value
 */
function freshbuilder_get_option_val($html, $option, $is_child = false){
	$jSon = stripslashes($html);
	$jSon = json_decode($jSon);

	if ($is_child) {
		return $jSon[0]->childs;
	}
	else {
		return $jSon[0]->$option;
	}
}




/**
 * Ajax Generate Module Options
 */
add_action( 'wp_ajax_freshbuilder_show_module_options', 'freshbuilder_show_module_options' );
function freshbuilder_show_module_options(){
	echo freshbuilder_generate_module_option($_POST['id'], $_POST['module'], $_POST['settings']);
	exit;
}



/**
 * Generate Module Options
 */
function freshbuilder_generate_module_option($id, $module, $settings){
	global $freshbuilder_modules;

	$module = $freshbuilder_modules[$module];
	?>
	<div class="module_setting" data-target="#<?php echo $id; ?>">
		<a href="#" class="close_lightbox" title="<?php _e('Done editing?', THEME_FX); ?>">X</a>

		<div class="module_setting_title">
			<?php echo $module['name'].' '.__('Settings', THEME_FX); ?>
		</div>

		<?php 
		if ( isset($module['options']) ) {
			foreach ($module['options'] as $key => $option) {
				
				$val = '';
				if ( $option['type'] != 'info')
				$val = freshbuilder_get_option_val($settings, $key);
				$class = ( isset($option['class']) ) ? ' ' . $option['class'] . ' ': '';
				$desc = ( isset($option['desc']) ) ? $option['desc'] : '';
				$is_content = ( isset($option['is_content']) && $option['is_content'] == 1) ? ' is_content' : '';

				switch ($option['type']) {
					case 'text':
						echo '<div class="module_setting_row'.$class.' clearfix">';
						echo '<div class="module_setting_label">'.$option['name'].'</div>';
						echo '<div class="module_setting_option">';
						echo '<input type="text" name="freshbuilder_input_'.$key.'" value="'.$val.'" class="freshbuilder_input'.$is_content.'"/>';
						echo '</div>';

						if ( $desc != '' ) {
							echo '<div class="module_setting_desc">'.$desc.'</div>';
						}
						
						echo '</div>';
						break;

					case 'textarea':
						echo '<div class="module_setting_row'.$class.' clearfix">';
						echo '<div class="module_setting_label">'.$option['name'].'</div>';
						echo '<div class="module_setting_option">';
						echo '<textarea name="freshbuilder_input_'.$key.'" class="freshbuilder_input'.$is_content.'" rows="8">'.$val.'</textarea>';
						echo '</div>';

						if ( $desc != '' ) {
							echo '<div class="module_setting_desc">'.$desc.'</div>';
						}
						
						echo '</div>';
						break;

					case 'checkbox':
						$desc = (isset($option['desc'])) ? $option['desc'] : '';
						$checked = ($val == '1') ? ' checked="checked"' : '';

						echo '<div class="module_setting_row'.$class.' clearfix">';
						echo '<div class="module_setting_label">'.$option['name'].'</div>';
						echo '<div class="module_setting_option">';
						echo '<label><input type="checkbox" name="freshbuilder_input_'.$key.'" class="freshbuilder_input'.$is_content.'"'. $checked .'/><span>'. $desc .'</span></label>';
						echo '</div>';
						echo '</div>';
						break;

					case 'select':
						echo '<div class="module_setting_row'.$class.' clearfix">';
						echo '<div class="module_setting_label">'.$option['name'].'</div>';
						echo '<div class="module_setting_option">';
						echo '<select name="freshbuilder_input_'.$key.'" class="freshbuilder_input'.$is_content.'">';
						foreach( $option['options'] as $k => $v ) {
							$selected = ($val == $k) ? ' selected="selected"' : '';
							echo '<option'.$selected.' value="'.$k.'">'.$v.'</option>';
						}
						echo '</select>';
						echo '</div>';

						if ( $desc != '' ) {
							echo '<div class="module_setting_desc">'.$desc.'</div>';
						}
						
						echo '</div>';
						break;

					case 'info':
						echo '<div class="module_setting_row'. $class .' clearfix">';
						echo '<div class="module_setting_info">'. $option['desc'] .'</div>';
						echo '</div>';
						break;
				}
			}
		}

		if ( isset($module['child']) ) {
			echo '<div class="child_module_setting" data-code="'.$module['child_code'].'">';
				echo '<a href="#" class="clone_child_module_setting button button-primary">'. __('Add ', THEME_FX) . ucwords($module['child_code']) .'</a>';
				echo '<ul class="child_module_setting_list clearfix">';
					$array = freshbuilder_get_option_val($settings, '', true);
					freshbuilder_generate_child($module, $array);
				echo '</ul>';
			echo '</div>';
		}
		?>
	</div>

	<?php
}



/**
 * Generate Module Child Options
 */
function freshbuilder_generate_child($module, $arrays){

	foreach ($arrays as $array) {
		echo '<li' . ( isset($array->class) ? ' class="default"' : '' ) . '>';
			echo '<div class="child_module_setting_box">';
				echo '<a href="#" class="remove_child">x</a>';
				foreach ($module['child'] as $key => $option) {
					$val = '';
					if ( $option['type'] != 'info')
					$val = $array->$key;
					$class = ( isset($option['class']) ) ? ' ' . $option['class'] . ' ': '';
					$desc = ( isset($option['desc']) ) ? $option['desc'] : '';
					$is_content = ( isset($option['is_content']) && $option['is_content'] == 1) ? ' is_content' : '';

					switch ($option['type']) {
						case 'text':
							echo '<div class="child_module_setting_row'.$class.' clearfix">';
							echo '<div class="child_module_setting_label">'.$option['name'].'</div>';

							echo '<div class="child_module_setting_option">';
							echo '<input type="text" name="freshbuilder_input_'. $key.'" value="'.$val.'" class="freshbuilder_child_input'.$is_content.'"/>';
							echo '</div>';
							
							if ( $desc != '' ) {
								echo '<div class="child_module_setting_desc">'.$desc.'</div>';
							}

							echo '</div>';
							break;

						case 'textarea':
							echo '<div class="child_module_setting_row'.$class.' clearfix">';
							echo '<div class="child_module_setting_label">'.$option['name'].'</div>';

							echo '<div class="child_module_setting_option">';
							echo '<textarea name="freshbuilder_input_'.$key.'" class="freshbuilder_child_input'.$is_content.'" rows="5">'.$val.'</textarea>';
							echo '</div>';
							
							if ( $desc != '' ) {
								echo '<div class="child_module_setting_desc">'.$desc.'</div>';
							}

							echo '</div>';
							break;

						case 'checkbox':
							$desc = (isset($option['desc'])) ? $option['desc'] : '';
							$checked = ($val == '1') ? ' checked="checked"' : '';

							echo '<div class="child_module_setting_row'.$class.' clearfix">';
							echo '<div class="child_module_setting_label">'.$option['name'].'</div>';

							echo '<div class="child_module_setting_option">';
							echo '<label><input type="checkbox" name="freshbuilder_input_'.$key.'" class="freshbuilder_child_input'.$is_content.'"'. $checked .'/><span>'. $desc .'</span></label>';
							echo '</div>';

							echo '</div>';
							break;

						case 'select':
							echo '<div class="child_module_setting_row'.$class.' clearfix">';
							echo '<div class="child_module_setting_label">'.$option['name'].'</div>';

							echo '<div class="child_module_setting_option">';
							echo '<select name="freshbuilder_input_'.$key.'" class="freshbuilder_child_input'.$is_content.'">';
							foreach( $option['options'] as $k => $v ) {
								$selected = ($val == $k) ? ' selected="selected"' : '';
								echo '<option'.$selected.' value="'.$k.'">'.$v.'</option>';
							}
							echo '</select>';
							echo '</div>';
							
							if ( $desc != '' ) {
								echo '<div class="child_module_setting_desc">'.$desc.'</div>';
							}

							echo '</div>';
							break;

						case 'info':
							echo '<div class="child_module_setting_row'.$class.' clearfix">';
							echo '<div class="module_setting_info">'.$desc .'</div>';
							echo '</div>';
							break;
					}
				}
			echo '</div>';
		echo '</li>';
	}
}