<?php

/**
 * Fresh Framework Admin Panel
 *
 * @version 1.4
 * @author Rifki Aria Gumelar
 * @copyright 2013, www.rifki.net / www.freshthemes.net
 * 
 **/



/**
 * Initialize Framework
 */
add_action('init', 'freshframework_init' );

function freshframework_init() {

	/* If the user has the appropriate capability */
	if ( current_user_can('edit_theme_options') ) {
		add_action('admin_init', 'freshframework_admin_init'); 
		add_action('admin_menu', 'freshframework_admin_menus');
		add_action('wp_before_admin_bar_render', 'freshframework_adminbar');
	}

}


/**
 * Initialize Admin Panel
 */
function freshframework_admin_init() {

	/* Load options config */
	require_once THEME_PATH . 'functions/theme-options.php';

	/* Include required function file */
	require_once dirname( __FILE__ ) . '/includes/media-uploader.php';
	require_once dirname( __FILE__ ) . '/includes/interface.php';
	require_once dirname( __FILE__ ) . '/includes/sanitize.php';

	/* Get settings */
	$freshframework_settings = get_option('freshthemes');

	/* Updates the unique option id in the database if it has changed */
	freshframework_option_name();

	/* Gets the unique id, returning a default if it isn't defined */
	$option_name = ( isset($freshframework_settings['id']) ) ? $freshframework_settings['id'] : 'freshthemes';

	/* If the option has no saved data, load the defaults */
	if ( !get_option($option_name) ) {
		freshframework_setdefaults();
	}

	/* Registers the settings fields and callback */
	register_setting('freshframework', $option_name, 'freshframework_validate');

	/* If export form submitted */
	if ( isset( $_POST['export'] ) && $_POST['export'] ) {
		freshframework_export_settings();
	}

	/* If import form submitted */
	if ( isset( $_POST['import'] ) && $_POST['import'] ) {
		freshframework_import_settings();
	}

	/* Change the capability */
	add_filter( 'option_page_capability_freshframework', 'freshframework_page_capability' );
}


/**
 * Ensures that a user with the 'edit_theme_options' capability can actually set the options
 * See: http://core.trac.wordpress.org/ticket/14365
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function freshframework_page_capability($capability) {
	return 'edit_theme_options';
}


/**
 * Add Admin Menu
 */
function freshframework_admin_menus() {

	/* Set global so we can load scripts to the correct page */
	global $freshframework_page;

	/* The menu page */
	$freshframework_page = add_menu_page(
		__('Fresh Panel', THEME_FX ), 
		__('Fresh Panel', THEME_FX), 
		'edit_theme_options', 
		'fresh-panel', 
		'freshframework_page', 
		THEME_DIR . 'framework/images/icons/icon.png'
	);

	/* Load scripts & styles */
	add_action('admin_enqueue_scripts', 'freshframework_load_scripts');
	add_action('admin_print_styles-' . $freshframework_page, 'freshframework_load_styles' );
}


/**
 * Add Admin Bar Menu
 */
function freshframework_adminbar() {

	global $wp_admin_bar;
		
	$wp_admin_bar->add_menu( array(
		'id' => 'freshframework_fresh_panel',
		'title' => '<span class="ab-icon"><img src="'.THEME_DIR .'framework/images/icons/adminbar-icon.png" style="position:absolute;" /></span><span class="ab-label">Fresh Panel</span>',
		'href' => admin_url('admin.php?page=fresh-panel')
	));

}


/**
 * Load Admin Styles
 */
function freshframework_load_styles() {

	wp_enqueue_style(
		'colorpicker', 
		THEME_DIR . 'framework/stylesheets/colorpicker.css', 
		false, 
		'2.0'
	);

	wp_enqueue_style(
		'freshframework', 
		THEME_DIR . 'framework/stylesheets/admin.css', 
		false, 
		'2.0'
	);

}


/**
 * Load Admin Scripts
 */
function freshframework_load_scripts($hook) {

	global $freshframework_page;

	/* If it's not admin panel page, do nothing */
	if($hook != $freshframework_page) return;

	wp_enqueue_script(
		'custom_colorpicker', 
		THEME_DIR . 'framework/javascripts/colorpicker.js', 
		false, 
		'2.0', 
		false
	);

	wp_enqueue_script(
		'freshframework', 
		THEME_DIR . 'framework/javascripts/framework.js', 
		false, 
		'2.0', 
		false
	);

	wp_enqueue_script(
		'freshframework_admin', 
		THEME_DIR . 'framework/javascripts/admin.js', 
		array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), 
		'1.3', 
		false
	);

	/* Localize script */
	wp_localize_script(
		'freshframework', 
		'freshframework_l10n', 
		array(
			'show_backup' => __('Backup?', THEME_FX),
			'hide_backup' => __('Hide', THEME_FX),
			'upload' => __('Upload', THEME_FX),
			'remove' => __('Remove', THEME_FX),
			'upload_title' => __('Select Image', THEME_FX),
			'upload_alert' => __('Only image is allowed, please try again!', THEME_FX),
			'confirm_delete' => __('Are you sure?', THEME_FX)
		)
	);

	/* Inline scripts */
	add_action('admin_head', 'freshframework_admin_head');

}


/**
 * Add Custom scripts
 */
function freshframework_admin_head() {
	do_action('freshframework_custom_scripts');
}


/**
 * Admin Panel Page Interface
 */
function freshframework_page() {
	settings_errors();
	$store_url = 'http://www.rifki.net/v/portfolio';
	$profile_url = 'http://www.rifki.net/v/profile';


?>
	<!-- FRESH PANEL -->
	<div id="fresh_panel_wrapper" class="wrap">
		<div id="fresh_panel">

			<!-- FRESH PANEL HEADER -->
			<div id="fresh_panel_header" class="clearfix">
				<div id="fresh_panel_logo"> </div>

				<div class="sep"></div>

				<div id="fresh_panel_theme_info">
					<span class="themename"><?php echo THEME_NAME; ?></span>
					<span class="themeversion">Version: <?php echo THEME_VERSION; ?></span>
				</div>

				<div class="sep"></div>

				<div id="fresh_panel_extra_links">
					<a class="support" href="<?php echo $profile_url; ?>" target="_blank">Support</a>
					<a class="store" href="<?php echo $store_url; ?>" target="_blank">Store</a>
				</div>
			</div>
			<!-- FRESH PANEL HEADER -->

			<!-- FRESH PANEL CONTENT -->
			<div id="fresh_panel_content" class="clearfix">
				<form enctype="multipart/form-data" action="options.php" method="post">
					
					<!-- FRESH PANEL TAB NAVIGATION -->
					<div id="fresh_panel_tab_nav_bg"></div>
					<div id="fresh_panel_tab_nav">
						<span class="shadow"></span>
						<ul>
							<?php echo freshframework_tab_nav(); ?>
						</ul>
					</div>
					<!-- FRESH PANEL TAB NAVIGATION -->
					
					<!-- FRESH PANEL TABS -->
					<div id="fresh_panel_tabs">
						<?php settings_fields('freshframework'); ?>
						<?php echo freshframework_fields(); ?>
					</div>
					<!-- FRESH PANEL TABS -->

					<div class="clear"></div>

					<!-- FRESH PANEL FOOTER -->
					<div id="fresh_panel_footer" class="clearfix">

						<a href="#" id="backup_toggle"><?php _e('Backup?', THEME_FX); ?></a>

						<div style="float:left">
							<input type="submit" class="button reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', THEME_FX ); ?>" onclick="return confirm( '<?php print esc_js( __('Click OK to reset. Any theme settings will be lost!', THEME_FX ) ); ?>' );" />
						</div>

						<div style="float:right">
							<input type="submit" class="button button-primary" name="update" value="<?php _e('Save Options', THEME_FX); ?>" />
						</div>
					</div>
					<!-- FRESH PANEL FOOTER -->

				</form>
			</div>
			<!-- FRESH PANEL CONTENT -->

			<!-- FRESH PANEL BACKUP -->
			<div id="fresh_panel_backup" class="clearfix">

				<div id="fresh_panel_import">
		            <form enctype="multipart/form-data" method="post" action="<?php echo admin_url('admin.php?page=fresh-panel'); ?>">
		                <div id="upload_box">
		                	<input type="file" id="freshframework_import_file" name="freshframework_import_file" />
		                </div>
		                <input id="button_import" name="import" type="submit" class="button" value="<?php _e('Import Settings', THEME_FX ); ?>" />
		            </form>
		        </div>

				<div id="fresh_panel_export">
		            <form enctype="multipart/form-data" method="post" action="<?php echo admin_url('admin.php?page=fresh-panel'); ?>">
		                <input id="button_export" name="export" type="submit" class="button button-primary" value="<?php _e('Export Settings', THEME_FX ); ?>" />
		            </form>
		        </div>

			</div>
			<!-- FRESH PANEL BACKUP -->

		</div>
	</div>
	<!-- FRESH PANEL -->
<?php

}


/**
 * Adds Default Options
 */
function freshframework_setdefaults() {

	/* Get settings */
	$freshframework_settings = get_option('freshthemes');
	$option_name = $freshframework_settings['id'];

	if( isset($freshframework_settings['knowoptions']) ){
		$knownoptions =  $freshframework_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$freshframework_settings['knownoptions'] = $knownoptions;
			update_option('freshthemes', $freshframework_settings);
		}
	}
	else {
		$newoptionname = array($option_name);
		$freshframework_settings['knownoptions'] = $newoptionname;
		update_option('freshthemes', $freshframework_settings);
	}

	/* Gets the default options data from the array in options.php */
	$options = freshframework_options();
	
	/* If the options haven't been added to the database yet, they are added now */
	$values = freshframework_get_default_values();

	/* Add option with default settings */
	if ( isset($values) ) {
		add_option($option_name, $values);
	}

}


/**
 * Validate Options
 */
function freshframework_validate($input) {

	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's options.php
	 * file will be added to the option for the active theme.
	 */

	if ( isset( $_POST['reset'] ) ) {
		add_settings_error(
			'freshframework', 
			'restore_defaults', 
			__( 'Default options restored.', THEME_FX ), 
			'updated fade fresh_panel_msg' 
		);

		return freshframework_get_default_values();
	}
	
	/*
	 * Update Settings
	 *
	 * This used to check for $_POST['update'], but has been updated
	 * to be compatible with the theme customizer introduced in WordPress 3.4
	 */

	$clean = array();
	$options = freshframework_options();
	
	foreach ($options as $option) {
		if ( !isset($option['id'])) {
			continue;
		}
		if ( !isset($option['type']) ) {
			continue;
		}
		$id = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($option['id']));

		/* Set checkbox to false if it wasn't sent in the $_POST */
		if ( 'checkbox' == $option['type'] && !isset($input[$id]) ) {
			$input[$id] = false;
		}

		/* Set each item in the multicheck to false if it wasn't sent in the $_POST */
		if ( 'multicheck' == $option['type'] && !isset($input[$id]) ) {
			foreach ( $option['options'] as $key => $value ) {
				$input[$id][$key] = false;
			}
		}

		/* For a value to be submitted to database it must pass through a sanitization filter */
		if ( has_filter( 'freshframework_sanitize_' . $option['type'] ) ) {
			$clean[$id] = apply_filters( 'freshframework_sanitize_' . $option['type'], $input[$id], $option );
		}
	}

	/* Hook to run after validation */
	do_action('freshframework_after_validate', $clean);
	
	return $clean;
}


/**
 * Display message when options have been saved
 */
function freshframework_save_options_notice() {
	add_settings_error(
		'freshframework', 
		'save_options', 
		__( 'Options saved.', THEME_FX ), 
		'updated fade fresh_panel_msg'
	);
}

add_action( 'freshframework_after_validate', 'freshframework_save_options_notice' );


/**
 * Get default values
 */
function freshframework_get_default_values() {

	$output = array();
	$config = freshframework_options();
	
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter('freshframework_sanitize_' . $option['type']) ) {
			$output[$option['id']] = apply_filters('freshframework_sanitize_' . $option['type'], $option['std'], $option);
		}
	}
	
	return $output;

}


/**
 * Export Settings
 */
function freshframework_export_settings() {
	
	/* Include global "wpdb" */
	global $wpdb;
	
	/* Get settings */
	$freshframework_settings = get_option('freshthemes');
	$database_options = get_option( $freshframework_settings['id'] );
	
	// Error trapping for the export.
	if ($database_options == '' || !$database_options) {
		add_settings_error(
			'freshframework', 
			'error_export', 
			__('There was a problem exporting your settings. Please Try again.', THEME_FX), 
			'error fade fresh_panel_msg'
		);
	}

	/* If option database is not empty */
	if ( !empty($database_options) ) {

		/* Add marker to ensure only valid file when import the settings */
		$database_options['freshframework_backup_validator'] = date( 'Y-m-d h:i:s' );

		/* Create export file */
	    $output = json_encode((array)$database_options );
	    header( 'Content-Description: File Transfer' );
	    header( 'Cache-Control: public, must-revalidate' );
	    header( 'Pragma: hack' );
	    header( 'Content-Type: text/plain' );
	    header( 'Content-Disposition: attachment; filename="' . THEME_FX . '-option-backup-' . date( 'Ymd-His' ) . '.json"' );
	    header( 'Content-Length: ' . strlen( $output ) );
	    echo $output;

	    exit;
	}

}


/**
 * Import Settings
 */
function freshframework_import_settings() {

	/* If upload field empty or error eccurs during uploading */
	if ( $_FILES['freshframework_import_file']['error'] ) {
		
		add_settings_error(
			'freshframework', 
			'import_error', 
			__('No file selected. Please try again.', THEME_FX), 
			'error fade fresh_panel_msg'
		);

	}
	else {

		/* Define the file, set to "null" if file is empty */
		$file = ( isset($_FILES['freshframework_import_file']) ) ? $_FILES['freshframework_import_file']['tmp_name'] : null;

		if( $file != null ) {

			/* Load data from uploaded file */
			$data = file_get_contents($file);
			$data = json_decode($data, true);

			/* File validation */
			if( !isset( $data['freshframework_backup_validator']) ) {
				add_settings_error(
					'freshframework', 
					'import_error', 
					__('It seems you chose the wrong file. Please try again.', THEME_FX), 
					'error fade fresh_panel_msg'
				);
			}
			else {

				/* Throw the validation marker */
				unset( $data['freshframework_backup_validator'] );

				/* Get option settings */
				$freshframework_data = get_option('freshthemes');
				$freshframework_name = $freshframework_data['id'];

				/* Update existing options value with data from uploaded file */
				update_option( $freshframework_name, $data );

			}
		}

	}

} 



/**
 * Get Option
 */
if ( ! function_exists( 'ft_get_option' ) ) {
	function ft_get_option( $name, $default = false ) {
		$prefix = THEME_FX . '_';
		$config = get_option( 'freshthemes' );

		$id = $prefix . $name;
	
		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		$options = get_option( $config['id'] );

		if ( isset( $options[$id] ) ) {
			return $options[$id];
		}

		return $default;
	}
}



/**
 * Create Custom Style & Script
 */
function freshframework_create_custom_js_css( $source, $file) {
	$directory = THEME_PATH . 'framework/includes/frontend/';
	$source_file = $directory . $source;
	$file = $directory . $file;
	
	if ( file_exists( $source_file ) ) {
		ob_start();
		require($source_file);
		$output = ob_get_clean();
		file_put_contents($file, $output, LOCK_EX);
	}
}

freshframework_create_custom_js_css( 'frontend.css.php', 'custom-style.css');
freshframework_create_custom_js_css( 'frontend.js.php', 'custom-script.js');
