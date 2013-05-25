<?php

/**
 * Fresh Framework Shortcdes
 *
 * @version 1.4
 * @author Rifki Aria Gumelar
 * @copyright 2013, www.rifki.net / www.freshthemes.net
 * 
 **/

/*	Fresh Shortcodes Class
 *	--------------------------------------------------------- */
class FreshShortcodes {

/*	Contruct
 *	--------------------------------------------------------- */
	public function __construct() {
		add_action('admin_enqueue_scripts', array( &$this, 'loads' ));
		add_action('init', array( &$this, 'shortcodes_tinymce' ));
	}

/*	Loads
 *	--------------------------------------------------------- */
	public function loads($hook) {
		if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
			wp_enqueue_style('fresh-shortcodes', THEME_DIR . 'framework/stylesheets/shortcodes.css');
			wp_enqueue_script('jquery-ui-sortable' );
			wp_enqueue_script('fresh-shortcodes-plugins', THEME_DIR . 'framework/javascripts/shortcodes-plugins.js');
			wp_enqueue_script('fresh-shortcodes', THEME_DIR . 'framework/javascripts/shortcodes.js');

			add_action('admin_head', array( &$this, 'shortcodes_admin_head' ));
		}
	}

	public function shortcodes_admin_head() {
		?>
<script type="text/javascript">
/* <![CDATA[ */
var freshthemes_theme_dir = "<?php echo THEME_DIR; ?>", fresh_shortcodes_popup_title = "<?php _e('Insert Shortcode', THEME_FX); ?>";
/* ]]> */
</script>
        <?php
	}

/*	TinyMCE
 *	--------------------------------------------------------- */
	public function shortcodes_tinymce() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array( &$this, 'add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'register_rich_buttons' ) );
		}
	}

	public function add_rich_plugins( $plugins ) {
		$plugins['FreshShortcodes'] = THEME_DIR . 'framework/javascripts/tinymce.js';
		return $plugins;
	}
	
	public function register_rich_buttons( $buttons ) {
		array_push( $buttons, "|", 'FreshShortcodesButton' );
		return $buttons;
	}
}

/*	Initialize Fresh Shortcodes
 *	--------------------------------------------------------- */
	$freshshortcodes = new FreshShortcodes();