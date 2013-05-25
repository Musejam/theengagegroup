<?php

/* 	Add support for a variety of post formats
 *	--------------------------------------------------------------------------- */
	add_theme_support('post-formats', array('gallery', 'video', 'link', 'image', 'quote', 'status', 'audio') );

/* 	Add support for editor style
 *	--------------------------------------------------------------------------- */
	add_editor_style( THEME_DIR . 'stylesheets/editor-style.css');
	
/* 	Add automatic feed links
 *	--------------------------------------------------------------------------- */
	if ( ft_get_option('feed_links') == 'on' ) {
		add_theme_support( 'automatic-feed-links' );
	}
	
/* 	Add support for featured image
 *	--------------------------------------------------------------------------- */
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
	}
	
/* 	Add image sizes
 *	--------------------------------------------------------------------------- */
	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'fullwidth', 960, 9999 );
	}

	add_filter( 'widget_text', 'do_shortcode', 11);

/*	Register sidebar widgets area
 *	--------------------------------------------------------------------------- */	
	add_action( 'widgets_init', 'freshthemes_widgets_init' );
	
	function freshthemes_widgets_init() {

		/* Get custom sidebars */
		$freshthemes_sidebars = get_option('freshthemes_sidebars');
		if (!$freshthemes_sidebars) {
			$freshthemes_sidebars = array( 'active' => array() );
		}
		$freshthemes_sidebars = $freshthemes_sidebars['active'];
		
		/* Register main sidebar */
		register_sidebar( array(
			'name'			=> __( 'Sidebar', THEME_FX ),
			'id'			=> 'sidebar',
			'description'	=> __( 'The sidebar widget area', THEME_FX ),
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '<span class="sep"></span></h3>',
		));
		
		/* Register footer widget one */
		register_sidebar( array(
			'name'			=> __( 'Footer Widget 1', THEME_FX ),
			'id'			=> 'sidebar-footer-1',
			'description'	=> __( 'The 1st sidebar widget area for your site footer', THEME_FX ),
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h3 class="widget-title"><span>',
			'after_title'	=> '</span></h3>',
		));
		
		/* Register footer widget two */
		register_sidebar( array(
			'name'			=> __( 'Footer Widget 2', THEME_FX ),
			'id'			=> 'sidebar-footer-2',
			'description'	=> __( 'The 2nd sidebar widget area for your site footer', THEME_FX ),
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h3 class="widget-title"><span>',
			'after_title'	=> '</span></h3>',
		));

		/* Register footer widget three */
		register_sidebar( array(
			'name'			=> __( 'Footer Widget 3', THEME_FX ),
			'id'			=> 'sidebar-footer-3',
			'description'	=> __( 'The 4th sidebar widget area for your site footer', THEME_FX ),
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h3 class="widget-title"><span>',
			'after_title'	=> '</span></h3>',
		));

		/* Register footer widget four */
		register_sidebar( array(
			'name'			=> __( 'Footer Widget 4', THEME_FX ),
			'id'			=> 'sidebar-footer-4',
			'description'	=> __( 'The 3rd sidebar widget area for your site footer', THEME_FX ),
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h3 class="widget-title"><span>',
			'after_title'	=> '</span></h3>',
		));

		/* Register all custom widgets area */
		foreach( $freshthemes_sidebars as $widget ) {
			$temp_widget = array(  
				'name' 			=> $widget,
				'description' 	=> __( 'Dynamic sidebar', THEME_FX),
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s clearfix">',
				'after_widget'	=> '</aside>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '<span class="sep"></span></h3>',
			);
	
			register_sidebar( $temp_widget );
		}
	}

/*	Generate Site Title
 *	---------------------------------------------------------------------------- */
	add_filter( 'wp_title', 'freshthemes_wp_title', 10, 2 );

 	function freshthemes_wp_title($title, $sep) {
		global $page, $paged;
		
		if ( is_feed() )
		return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );
	
		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
	
		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );
	
		return $title;
	}
	
/*	Add browser classes to <body> tag
 *	---------------------------------------- */
	add_filter('body_class', 'freshthemes_browser_detector');

	function freshthemes_browser_detector($class) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
		if($is_lynx) 
		$class[] = 'lynx';
		elseif($is_gecko) 
		$class[] = 'gecko';
		elseif($is_opera) 
		$class[] = 'opera';
		elseif($is_NS4) 
		$class[] = 'ns4';
		elseif($is_safari) 
		$class[] = 'safari';
		elseif($is_chrome) 
		$class[] = 'chrome';
		elseif($is_IE) 
		$class[] = 'ie';
		elseif($is_iphone) 
		$class[] = 'iphone';
		else 
		$class[] = 'unknown';
		
		return $class;
	}
	
/*	Adds the layout type classes to <body> tag
 *	---------------------------------------- */
	add_filter('body_class', 'freshthemes_add_layout_class');

	function freshthemes_add_layout_class($class){
		$class[] = ft_get_option('layout_type');
		
		return $class;
	}

/* 	Load theme styles
 *	--------------------------------------------------------------------------- */
	add_action('wp_enqueue_scripts', 'freshthemes_theme_styles');

	function freshthemes_theme_styles() {
		global $wp_styles;

		// Google fonts array 
		$google_fonts = array_keys( freshthemes_typography_get_google_fonts() );
			
		// Define all the options that possibly have a unique Google font 
		$body_typo = ft_get_option('body_typo', 'Arial, Helvetica, san-serif');
		$heading_typo = ft_get_option('heading_typo', 'Arial, Helvetica, san-serif');
		$primary_menu_typo = ft_get_option('primary_menu_typo', 'Arial, Helvetica, san-serif');
		$footer_menu_typo = ft_get_option('footer_menu_typo', 'Arial, Helvetica, san-serif');
	
		// Get the font face for each option and put it in an array 
		$selected_fonts = array(
			$body_typo['face'],
			$heading_typo['face'],
			$primary_menu_typo['face'],
			$footer_menu_typo['face']
		);
		
		// Remove any duplicates in the list 
		$selected_fonts = array_unique($selected_fonts);
		
		// If it is a Google font, go ahead and call the function to enqueue it 
		foreach ( $selected_fonts as $font ) {
			if ( in_array( $font, $google_fonts ) ) {
				freshthemes_typography_enqueue_google_font($font);
			}
		}

		wp_enqueue_style(
			'base', 
			THEME_DIR . 'stylesheets/base.css', 
			false, 
			THEME_VERSION,
			'all'
		);
		wp_enqueue_style(
			'main', 
			get_stylesheet_uri(), 
			false, 
			THEME_VERSION, 
			'all'
		);
		wp_enqueue_style(
			'prettyPhoto', 
			THEME_DIR . 'stylesheets/prettyPhoto.css', 
			false, 
			THEME_VERSION, 
			'screen'
		);
		wp_enqueue_style(
			'theme-settings', 
			THEME_DIR . 'framework/includes/frontend/custom-style.css', 
			false, 
			THEME_VERSION, 
			'screen'
		);

		if ( ft_get_option('responsive') == 'on') :
		wp_enqueue_style(
			'responsive', 
			THEME_DIR . 'stylesheets/responsive.css', 
			false, 
			THEME_VERSION, 
			'screen'
		);
		endif;
	}

/*	Load theme scripts
 *	--------------------------------------------------------------------------- */
	add_action('wp_enqueue_scripts', 'freshthemes_theme_scripts');

	function freshthemes_theme_scripts() {
		wp_enqueue_script(
			'flexslider', 
			THEME_DIR . 'javascripts/flexslider.min.js', 
			array('jquery'), 
			'2.1', 
			true 
		);
		wp_enqueue_script(
			'isotope', 
			THEME_DIR . 'javascripts/jquery.isotope.min.js', 
			array('jquery'), 
			'1.5.23', 
			true 
		);
		wp_enqueue_script(
			'jplayer', 
			THEME_DIR . 'javascripts/jquery.jplayer.min.js', 
			array('jquery'), 
			'1.4.8', 
			true 
		);
		wp_enqueue_script(
			'superfish', 
			THEME_DIR . 'javascripts/superfish.js', 
			array('jquery'),
			'1.4.8', 
			true 
		);
		wp_enqueue_script(
			'scrolltofixed', 
			THEME_DIR . 'javascripts/jquery-scrolltofixed.js', 
			array('jquery'),
			THEME_VERSION, 
			true 
		);
		wp_enqueue_script(
			'gmap', 
			THEME_DIR . 'javascripts/jquery.gmap.min.js', 
			array('jquery'),
			THEME_VERSION, 
			false 
		);
		wp_enqueue_script(
			'imagesLoaded', 
			THEME_DIR . 'javascripts/jquery.imagesloaded.min.js', 
			array('jquery'),
			'2.1.1', 
			true 
		);
		wp_enqueue_script(
			'prettyPhoto', 
			THEME_DIR . 'javascripts/jquery.prettyPhoto.js', 
			array('jquery'),
			'3.1.5', 
			true 
		);
		wp_enqueue_script(
			'gmap_api', 
			'http://maps.googleapis.com/maps/api/js?sensor=false', 
			array('jquery'),
			THEME_VERSION, 
			false 
		);
		wp_enqueue_script(
			'theme-settings', 
			THEME_DIR . 'framework/includes/frontend/custom-script.js', 
			array('jquery'),
			THEME_VERSION, 
			true 
		);
		wp_enqueue_script(
			'theme-script', 
			THEME_DIR . 'javascripts/theme-script.js', 
			array('jquery'),
			THEME_VERSION, 
			true 
		);

		if ( ft_get_option('responsive') == 'on') {
			wp_enqueue_script(
				'mobilemenu', 
				THEME_DIR . 'javascripts/jquery.mobilemenu.js', 
				array('jquery'),
				THEME_VERSION, 
				false 
			);
		}

		/* If is single and comment is allowed */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	
/*	Add site favicon
 *	--------------------------------------------------------------------------- */	
	function freshthemes_favicon() {
		if ( ft_get_option('ipad_retina_favicon') )
		echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'.ft_get_option('ipad_retina_favicon').'">' . "\n";
		if ( ft_get_option('ipad_favicon') )
		echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'.ft_get_option('ipad_favicon').'">' . "\n";
		if ( ft_get_option('iphone_retina_favicon') )
		echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'.ft_get_option('iphone_retina_favicon').'">' . "\n";
		if ( ft_get_option('iphone_favicon') )
		echo '<link rel="apple-touch-icon-precomposed" href="'.ft_get_option('iphone_favicon').'">' . "\n";
		if ( ft_get_option('favicon') )
		echo '<link rel="shortcut icon" href="'. ft_get_option('favicon').'">';
	}
	
	add_action('wp_head', 'freshthemes_favicon');
	
/*	Head code
 *	--------------------------------------------------------------------------- */	
	function freshthemes_head_code() {
		if ( ft_get_option('head_code') )
		echo "\n" . ft_get_option('head_code') . "\n";
	}
	
	add_action('wp_head', 'freshthemes_head_code');
	
/*	Footer Code
 *	--------------------------------------------------------------------------- */	
	function freshthemes_footer_code() {
		if ( ft_get_option('footer_code') )
		echo "\n" . ft_get_option('footer_code') . "\n";
	}
	
	add_action('wp_footer', 'freshthemes_footer_code');

/* 	Register WP nav menu locations
 *	--------------------------------------------------------------------------- */
	if ( function_exists('register_nav_menus') ) { 
		register_nav_menus(
			array(
				'primary_menu' => __('Primary Menu', THEME_FX), 
				'footer_menu' => __('Footer Menu', THEME_FX),
			)
		);
	}
	
/* 	Clean active menus
 *	--------------------------------------------------------------------------- */
	add_filter('nav_menu_css_class', 'freshthemes_clean_active_menu', 10, 2);

	function freshthemes_clean_active_menu($active, $item) {
		$active = str_replace('current_page_item', 'active', $active);
		$active = str_replace('current-menu-item', 'active', $active);
		// $active = str_replace('current_page_parent', 'active', $active);
		$active = str_replace('current-page-ancestor', 'active', $active);
		// $active = str_replace('current-menu-parent', 'active', $active);
		// $active = str_replace('current-menu-ancestor', 'active', $active);
		
		return $active;
	}

/* 	Class primary menu walker
 * 	----------------------------------------------------- */
	class description_walker extends Walker_Nav_Menu {
		function start_el(&$output, $item, $depth, $args) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="'. esc_attr( $class_names ) . '"';

			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$prepend = '<strong>';
			$append = '</strong>';
			$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

			if($depth != 0) {
				$description = $append = $prepend = "";
			}

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
			$item_output .= $description.$args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

/*	Class portfolio filter walker
 *	--------------------------------------------------------------------------- */
	class FreshThemes_Portfolio_Filter extends Walker_Category {
		function start_el(&$output, $category, $depth, $args) {
   
			$cat_name = esc_attr( $category->name);
			$link = '<a href="#" data-option-value=".'.$category->slug.'">' . $cat_name . '</a>';

			if ( 'list' == $args['style'] ) {
				$output .= '<li';
				$class = 'cat-item cat-item-'.$category->term_id;
				
				if ( isset($current_category) && $current_category && ($category->term_id == $current_category) )
					$class .=  ' current-cat';
				elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) )
					$class .=  ' current-cat-parent';
					
				$output .=  '';
				$output .= ">$link\n";
			} 
			else {
				$output .= "\t$link<br />\n";
			}
		}
	}

/* 	Get attachement id from URL
 * 	----------------------------------------------------- */
	function freshthemes_get_attachement_id($url) {
		global $wpdb;
		$attachment_id = false;
	 
		if (!$url) { return; }
	 
		$upload_dir_paths = wp_upload_dir();

		if ( false !== strpos( $url, $upload_dir_paths['baseurl'] ) ) {
			$url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );
			$url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $url );
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $url ) );
		}
	 
		return $attachment_id;
	}

/*	Get Portfolio Categories
 *	--------------------------------------------------------------------------- */
	function freshthemes_get_portfolio_categories($link = false) {
		global $post;
		
		// get post by post id
		$post = &get_post($post->ID);
		
		// get post type by post
		$post_type = $post->post_type;
		
		// get post type taxonomies
		$taxonomies = get_object_taxonomies($post_type);
		
		foreach ($taxonomies as $taxonomy) {
			$terms = get_the_terms( $post->ID, $taxonomy );
			
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term )
					if ( $link != false ) :
					$out[] = '<a href="'. get_term_link($term->slug, $term->taxonomy) .'" rel="tag">'. $term->name .'</a>';
					else :
					$out[] = $term->name;
					endif;
				return join( ', ', $out );
			}
		}

		return;
	}

/* 	Print post format badge
 * 	----------------------------------------------------- */
	function freshthemes_print_entry_badge($format){
		$out = '';
		$out .= '<div class="entry-badge"><a href="'.get_permalink().'">';
		switch ($format) {
			case 'gallery': $out .= '<i class="icon-picture"></i>'; break;
			case 'video': $out .= '<i class="icon-film"></i>'; break;
			case 'link': $out .= '<i class="icon-link"></i>'; break;
			case 'image': $out .= '<i class="icon-camera-retro"></i>'; break;
			case 'quote': $out .= '<i class="icon-quote-right"></i>'; break;
			case 'status': $out .= '<i class="icon-info-sign"></i>'; break;
			case 'audio': $out .= '<i class="icon-volume-up"></i>'; break;
			default: $out .= '<i class="icon-pencil"></i>'; break;
		}
		$out .= '</a></div>';

		return $out;
	}
	
/*	Modify the tag cloud widget
 *	--------------------------------------------------------------------------- */
	function freshthemes_tag_cloud_args(){
		$size = ft_get_option('body_typo');
		$size = ( isset($size['size']) ) ? str_replace('px', '', $size['size']) : 12;
		return 'smallest='.$size.'&largest='.$size.'&unit=px';
	}
	
	add_filter( 'widget_tag_cloud_args', 'freshthemes_tag_cloud_args' );

/*	Modify the excerpt lenght
 *	--------------------------------------------------------------------------- */	
	function freshthemes_excerpt_length( $length ) {
		$custom = ft_get_option('excerpt_lenght');
		return ( $custom != '' ? $custom : 40 );
	}
	add_filter( 'excerpt_length', 'freshthemes_excerpt_length' );
	
/*	Continue reading link
 *	--------------------------------------------------------------------------- */
	function freshthemes_continue_reading_link() {
		return '<br><a class="more-link button small" href="'. esc_url( get_permalink() ) . '" class="more-link">' .ft_get_option('readmore_label') . '</a>';
	}

	add_filter( 'the_content_more_link', 'freshthemes_continue_reading_link' );
	
/*	Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis.
 *	--------------------------------------------------------------------------- */	
	function freshthemes_auto_excerpt_more( $more ) {
		return ' &hellip; ';
	}
	
	add_filter( 'excerpt_more', 'freshthemes_auto_excerpt_more' );
	
/*	Adds a pretty "Continue Reading" link to custom post excerpts.
 *	--------------------------------------------------------------------------- */	
	function freshthemes_custom_excerpt_more( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= freshthemes_continue_reading_link();
		}
		
		return $output;
	}
	
	add_filter( 'get_the_excerpt', 'freshthemes_custom_excerpt_more' );
	
/*	Function to create custom excerpt lenght
 *	---------------------------------------- */	
	function freshthemes_excerpt($lenght, $morelink = true) {
		$limit = $lenght + 1;
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		array_pop($excerpt);
		$excerpt = implode(' ', $excerpt) . ' ... ';
		
		return $excerpt . ( $morelink != false ? freshthemes_continue_reading_link() : '');
	}
	
/*	Function to create custom title lenght
 *	---------------------------------------- */	
	function freshthemes_title($lenght) {
		$limit = $lenght + 1;
		$title = explode(' ', get_the_title(), $limit);
		array_pop($title);
		$title = implode(' ', $title) . ' ... ';
		
		echo $title;
	}

/*	Add class to next_post_link
 *	--------------------------------------------------------------------------- */
	function freshthemes_class_next_post_link($html){
		$html = str_replace('<a','<a class="button small next"', $html);
		return $html;
	}
	
	add_filter('next_post_link', 'freshthemes_class_next_post_link', 10, 1);

/*	Add class to prev_post_link
 *	--------------------------------------------------------------------------- */
	function freshthemes_class_previous_post_link($html){
		$html = str_replace('<a','<a class="button small prev"', $html);
		return $html;
	}
	
	add_filter('previous_post_link', 'freshthemes_class_previous_post_link', 10, 1);

/* 	Print audio player
 * 	----------------------------------------------------- */
	function freshthemes_print_audio_player($post_id, $format, $file, $optional = ''){
		$supplied = ($optional != '') ? $format .', ogg' : $format;
		$optional_media = ($optional != '') ? ', ogg : "'. $optional .'"' : '';
		$out = '';

		if ( $file ) {
			$out .='<div id="jquery_jplayer_'. $post_id .'" class="jp-jplayer"></div>';
			$out .='<div id="jp_container_'. $post_id .'" class="jp-audio">';
				$out .='<div class="jp-gui jp-interface">';
					$out .='<ul class="jp-controls">';
						$out .='<li><a href="javascript:;" class="jp-play" tabindex="1"><i class="icon-play"></i></a></li>';
						$out .='<li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="icon-pause"></i></a></li>';
						$out .='<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="icon-volume-up"></i></a></li>';
						$out .='<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="icon-volume-off"></i></a></li>';
					$out .='</ul>';

					$out .='<div class="jp-progress">';
						$out .='<div class="jp-seek-bar">';
							$out .='<div class="jp-play-bar"></div>';
						$out .='</div>';
					$out .='</div>';

					$out .='<div class="jp-volume-bar">';
						$out .='<div class="jp-volume-bar-value"></div>';
					$out .='</div>';

					$out .='<div class="jp-time-holder">';
						$out .='<div class="jp-current-time"></div>';
					$out .='</div>';
				$out .='</div>';
			$out .='</div><!-- .jp-audio -->';

			$out .='<script type="text/javascript">
					//<![CDATA[
					jQuery(document).ready(function(){
						jQuery("#jquery_jplayer_'. $post_id .'").jPlayer({
							ready: function (event) {
								jQuery(this).jPlayer("setMedia", {
									'. $format .': "'. $file .'"'. $optional_media .'
								});
							},
							swfPath: "'. THEME_DIR . 'javascripts/' .'",
							cssSelectorAncestor: "#jp_container_'. $post_id .'",
							supplied: "'. $supplied .'"
						});
					});
					//]]>
					</script>';

			return $out;
		}
	}

/* 	Print social links
 * 	----------------------------------------------------- */
	function freshthemes_print_social_links() {
		$socials = array('facebook', 'twitter', 'google-plus', 'linkedin', 'github', 'pinterest');

		foreach ($socials as $social) {
			if( ft_get_option($social) ) {
				echo '<li class="'. $social .'"><a href="'. ft_get_option($social) .'"><i class="icon-'. $social .' icon-large"></i></a></li>';
			}
		}
	}

?>