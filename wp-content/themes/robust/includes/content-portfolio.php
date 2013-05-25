<article id="item-<?php the_ID(); ?>" <?php post_class('item clearfix'); ?>>
	<figure class="item-thumb">
		<?php echo get_the_post_thumbnail($post->ID, '500x360'); ?>
		
		<div class="overlay">
			<a class="view-link" href="<?php echo get_permalink(); ?>" rel="bookmark"><?php _e('View Project', THEME_FX); ?></a>
		</div>
	</figure>

	<header class="item-header">
		<h4 class="item-title"><a class="reserve" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s',  THEME_FX ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<div class="item-meta">
			<?php 
			if( get_post_meta( get_the_id(), 'ft_portfolio_subtitle', true) ) :
				echo get_post_meta( get_the_id(), 'ft_portfolio_subtitle', true);
			else :
				echo freshthemes_get_portfolio_categories();
			endif; 
			?>
		</div>
	</header>
</article><!-- #item <?php the_ID(); ?> -->