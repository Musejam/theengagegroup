<?php
/**
*   Entries Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['entries'] = array(
		'no_preview' => true,
		'options' => array(
			'heading' => array(
				'name' => __('Heading Text', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'std' => 'Recent Posts'
			),
			'column' => array(
				'name' => __('Column', THEME_FX),
				'desc' => __('Select the number of column.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'1' => __('1 Column', THEME_FX),
					'2' => __('2 Columns', THEME_FX),
					'3' => __('3 Columns', THEME_FX),
					'4' => __('4 Columns', THEME_FX),
					'5' => __('5 Columns', THEME_FX)
				),
				'std' => '4'
			),
			'number' => array(
				'name' => __('Post Number', THEME_FX),
				'desc' => __('Enter the number of post to show.', THEME_FX),
				'type' => 'text',
				'std' => '4'
			),
			'cat' => array(
				'name' => __('Category', THEME_FX),
				'desc' => __('Optional you can sort by a category.', THEME_FX),
				'type' => 'select',
				'options' => $options_categories,
				'std' => ''
			),
			'excerpt_lenght' => array(
				'name' => __('Excerpt Lenght', THEME_FX),
				'desc' => __('The post excerpt word lenght.', THEME_FX),
				'type' => 'text',
				'std' => '30'
			),
		),
		'shortcode' => '[entries heading="{{heading}}" column="{{column}}" number="{{number}}" cat="{{cat}}" excerpt_lenght="{{excerpt_lenght}}"]',
		'popup_title' => __('Insert Entries Shortcode', THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['entries'] = array(
		'name' => __('Entries', THEME_FX),
		'size' => 'one_full',
		'options' => array(
			'heading' => array(
				'name' => __('Heading', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'std' => 'Recent Posts',
				'class' => '',
				'is_content' => '0'
			),
			'column' => array(
				'name' => __('Column', THEME_FX),
				'desc' => __('Select the number of column.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'1' => __('1 Column', THEME_FX),
					'2' => __('2 Columns', THEME_FX),
					'3' => __('3 Columns', THEME_FX),
					'4' => __('4 Columns', THEME_FX),
					'5' => __('5 Columns', THEME_FX)
				),
				'std' => '4',
				'class' => '',
				'is_content' => '0'
			),
			'number' => array(
				'name' => __('Post Number', THEME_FX),
				'desc' => __('Enter the number of post to show.', THEME_FX),
				'type' => 'text',
				'std' => '4',
				'class' => '',
				'is_content' => '0'
			),
			'cat' => array(
				'name' => __('Category', THEME_FX),
				'desc' => __('Optional you can sort by a category.', THEME_FX),
				'type' => 'select',
				'options' => $options_categories,
				'std' => '',
				'class' => '',
				'is_content' => '0'
			),
			'excerpt_lenght' => array(
				'name' => __('Excerpt Lenght', THEME_FX),
				'desc' => __('The post excerpt word lenght.', THEME_FX),
				'type' => 'text',
				'std' => '30',
				'class' => '',
				'is_content' => '0'
			)
		)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('entries', 'fresh_shortcode_entries');

	function fresh_shortcode_entries( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'heading' => 'Recent Posts',
			'column' => '4',
			'number' => '4',
			'cat' => '',
			'excerpt_lenght' => '30'
		), $atts));

		$grid = ' grid full';
		if ($column == '2') $grid = ' grid one-half';
		if ($column == '3') $grid = ' grid one-third';
		if ($column == '4') $grid = ' grid one-fourth';
		if ($column == '5') $grid = ' grid one-fifth';

		$out = '';
		$i = 0;

		$out .= '<div class="row">';
		if ($heading != '') $out .= '<div class="grid full"><div class="heading"><h3>'.$heading.'</h3><div class="sep"></div></div></div>';

		$number = ($number) ? "&posts_per_page=$number" : '';
		$cat = ($cat) ? "&cat=$cat" : '';

		$args = "post_type=post$number$cat";
		$loop = new WP_Query( $args);

		if ( $loop->have_posts() ) :
			while ( $loop->have_posts() ) : $loop->the_post(); $i++;

			$out .= '<div class="'.$grid.'">';
			$out .= '<article class="recent-entry clearfix">';
				$out .= freshthemes_print_entry_badge(get_post_format());
				$out .= '<header class="recent-entry-header">';
					$out .= '<h3 class="recent-entry-title"><a class="reserve" href="'.get_permalink().'" title="" rel="bookmark">'.get_the_title().'</a></h3>';
					$out .= '<div class="recent-entry-meta">'. get_the_time( get_option('date_format') ) .' - '. get_the_time('G:i a') .'</div>';
				$out .= '</header>';

				$out .= '<div class="recent-entry-summary">';
				$out .= freshthemes_excerpt($excerpt_lenght, false);
				$out .= '</div>';
			$out .= '</article>';
			$out .= '</div>';

			if( $i == $column ) $out .= '<div class="clear"></div>';

			endwhile;
		endif;
		wp_reset_postdata();
		$out .= '</div>';

		return $out;
	}