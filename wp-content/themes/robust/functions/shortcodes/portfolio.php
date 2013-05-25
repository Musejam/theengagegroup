<?php
/**
*   Portfolio Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['portfolio'] = array(
		'no_preview' => true,
		'options' => array(
			'heading' => array(
				'name' => __('Heading Text', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'std' => 'Recent Project'
			),
			'column' => array(
				'name' => __('Column', THEME_FX),
				'desc' => __('Select the number of column.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'2' => __('2 Columns', THEME_FX),
					'3' => __('3 Columns', THEME_FX),
					'4' => __('4 Columns', THEME_FX)
				),
				'std' => '4'
			),
			'number' => array(
				'name' => __('Post Number', THEME_FX),
				'desc' => __('Enter the number of post to show.', THEME_FX),
				'type' => 'text',
				'std' => '4'
			)
		),
		'shortcode' => '[portfolio heading="{{heading}}" column="{{column}}" number="{{number}}"]',
		'popup_title' => __('Insert Portfolio Shortcode', THEME_FX)
	);

/* 	Page builder module config
 * 	----------------------------------------------------- */
	$freshbuilder_modules['portfolio'] = array(
		'name' => __('Portfolio', THEME_FX),
		'size' => 'one_full',
		'options' => array(
			'heading' => array(
				'name' => __('Heading', THEME_FX),
				'desc' => __('Enter the heading text.', THEME_FX),
				'type' => 'text',
				'std' => 'Recent Project',
				'class' => '',
				'is_content' => 0
			),
			'column' => array(
				'name' => __('Column', THEME_FX),
				'desc' => __('Select the number of column.', THEME_FX),
				'type' => 'select',
				'options' => array(
					'2' => __('2 Columns', THEME_FX),
					'3' => __('3 Columns', THEME_FX),
					'4' => __('4 Columns', THEME_FX)
				),
				'std' => '4',
				'class' => '',
				'is_content' => 0
			),
			'number' => array(
				'name' => __('Post Number', THEME_FX),
				'desc' => __('Enter the number of post to show.', THEME_FX),
				'type' => 'text',
				'std' => '4',
				'class' => '',
				'is_content' => 0
			)
		)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('portfolio', 'fresh_shortcode_portfolio');

	function fresh_shortcode_portfolio( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'heading' => 'Recent Project',
			'column' => 4,
			'number' => 4
		), $atts));

		global $post;

		$grid = ' grid one-half';
		if ($column == '3') $grid = ' grid one-third';
		if ($column == '4') $grid = ' grid one-fourth';

		$out = '';
		$i = 0;

		$out .= '<div class="portfolio-items row">';
		if ($heading != '') $out .= '<div class="grid full"><div class="heading"><h3>'.$heading.'</h3><div class="sep"></div></div></div>';

		$number = ($number) ? "&posts_per_page=$number" : '';

		$args = "post_type=portfolio$number";
		$loop = new WP_Query( $args);

		if ( $loop->have_posts() ) :
			while ( $loop->have_posts() ) : $loop->the_post(); $i++;

			$meta = get_post_meta( $post->ID, 'ft_portfolio_subtitle', true) ? get_post_meta( $post->ID, 'ft_portfolio_subtitle', true) : freshthemes_get_portfolio_categories();

			$out .= '<div class="'.$grid.'">';
			$out .= '<article class="item clearfix">
						<figure class="item-thumb">
	                        '.get_the_post_thumbnail($post->ID, '500x360').'
	                        <div class="overlay">
	                            <a class="view-link" href="'.get_permalink().'" rel="bookmark">'.__('View Project', THEME_FX) .'</a>
	                        </div>
	                    </figure>

	                    <header class="item-header">
	                        <h4 class="item-title"><a class="reserve" href="'.get_permalink().'" title="" rel="bookmark">'.get_the_title().'</a></h4>
	                        <div class="item-meta">'. $meta .'</div>
	                    </header>';
			$out .= '</article>';
			$out .= '</div>';

			if( $i == $column ) $out .= '<div class="clear"></div>';

			endwhile;
		endif;
		wp_reset_postdata();
		$out .= '</div>';

		return $out;
	}