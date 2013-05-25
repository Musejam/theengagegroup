<?php
 
/*	Register Portfolio Post Type
 *	---------------------------------------- */	
	function portfolio_register() {
		
		$labels = array(
			'name' => __( 'Portfolio Items', THEME_FX ), 
			'singular_name' => __('Portfolio', THEME_FX ),
			'all_items' => __('All Portfolio Items', THEME_FX ),
			'add_new' => _x('Add New', THEME_FX ), 
			'edit_item' => __('Edit Portfolio Item', THEME_FX ),
			'new_item' => __('New Portfolio Item', THEME_FX ), 
			'view_item' => __('View Portfolio', THEME_FX ),
			'search_items' => __('Search Portfolio', THEME_FX ), 
			'not_found' =>  __('No Portfolio Items Found', THEME_FX ),
			'not_found_in_trash' => __('No Portfolio Items Found In Trash', THEME_FX ),
			'parent_item_colon' => '' 
		);
	
		$slug = ft_get_option('portfolio_slug') ? ft_get_option('portfolio_slug') : 'portfolio';
		
		$args = array(
			'labels' => $labels, 
			'public' => true, 
			'publicly_queryable' => true, 
			'show_ui' => true, 
			'query_var' => true, 
			'rewrite' => array( 'slug'=> $slug, 'with_front'=>true ),
			'capability_type' => 'post', 
			'hierarchical' => false, 
			'menu_position' => 5, 
			'supports' => array('title', 'thumbnail', 'excerpt', 'editor', 'comments'),
			'menu_icon' => THEME_DIR . 'framework/images/icons/portfolio.png'
		);
	
		register_post_type( __( 'portfolio', THEME_FX) , $args );
		
	}
	
	add_action('init', 'portfolio_register');

/*	Create Custom Message
 *	---------------------------------------- */
	function portfolio_messages($messages) {
		global $post;
		
		$messages[__( 'portfolio', THEME_FX)] = array(
			0 => '',
			1 => sprintf(__('Portfolio Updated. <a href="%s">View portfolio</a>', THEME_FX ), esc_url(get_permalink($post->ID))),
			2 => __('Custom Field Updated.', THEME_FX),
			3 => __('Custom Field Deleted.', THEME_FX),
			4 => __('Portfolio Updated.', THEME_FX),
			5 => isset($_GET['revision']) ? sprintf( __('Portfolio Restored To Revision From %s', THEME_FX ), wp_post_revision_title((int)$_GET['revision'],false)) : false,
			6 => sprintf(__('Portfolio Published. <a href="%s">View Portfolio</a>', THEME_FX ), esc_url(get_permalink($post->ID))),
			7 => __('Portfolio Saved.', THEME_FX),
			8 => sprintf(__('Portfolio Submitted. <a target="_blank" href="%s">Preview Portfolio</a>', THEME_FX ), esc_url( add_query_arg('preview','true',get_permalink($post->ID)))),
			9 => sprintf(__('Portfolio Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Portfolio</a>', THEME_FX ),date_i18n( __( 'M j, Y @ G:i', THEME_FX ),strtotime($post->post_date)), esc_url(get_permalink($post->ID))),
			10 => sprintf(__('Portfolio Draft Updated. <a target="_blank" href="%s">Preview Portfolio</a>', THEME_FX ), esc_url( add_query_arg('preview','true',get_permalink($post->ID)))),
		);
		
		return $messages;
	}
	
	add_filter('post_updated_messages', 'portfolio_messages');

/*	Register Portfolio Taxonomy
 *	---------------------------------------- */
	function portfolio_taxonomy() {
	
		register_taxonomy(__( "portfolio_category", THEME_FX  ), 
			array(__( "portfolio", THEME_FX  )), 
			array(
				"hierarchical" => true, 
				"label" => __( "Categories", THEME_FX  ), 
				"singular_label" => __( "Categories", THEME_FX  ), 
				"rewrite" => array(
					'slug' => 'portfolio-category', 
					'hierarchical' => true
				)
			)
		); 
		
	}
	
	add_action('init', 'portfolio_taxonomy', 0 );
	
/*	Add more columns
 *	---------------------------------------- */
	function portfolio_prod_edit_columns($columns) {
		
		$newcolumns = array(
			"cb" => "<input type=\"checkbox\" />",
			"thumb column-comments" => __('Image', THEME_FX),	
			"title" => "Title",
			"type column-date" => "Type",
			"portfolio_category" => "Category"
		);
	
		$columns = array_merge($newcolumns, $columns);
	
		return $columns;
	}
	
	add_filter('manage_edit-portfolio_columns', 'portfolio_prod_edit_columns');

/*	Add more columns
 *	---------------------------------------- */	
	function portfolio_prod_custom_columns($column) {
		global $post;
		switch ($column) {
			case "thumb column-comments":
				if (has_post_thumbnail($post->ID)){
					echo get_the_post_thumbnail($post->ID, '50x50');
				}
				break;
	
			case "description":
				the_excerpt();
				break;
		
			case "portfolio_category":
				echo get_the_term_list($post->ID, 'portfolio_category', '', ', ','');
				break;
				
			case "type column-date":
				echo ucwords( get_post_meta( get_the_ID(), THEME_FX . 'project_type', true) );
				break;
		}
	}
	
	add_action('manage_portfolio_posts_custom_column',  'portfolio_prod_custom_columns');
	
?>