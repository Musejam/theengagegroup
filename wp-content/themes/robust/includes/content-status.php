<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
	
	<?php if( !is_singular() ) : ?><?php global $more; $more = 0; ?><?php endif; ?>

	<div class="entry-badge">
	    <a href="<?php the_permalink(); ?>"><i class="icon-pushpin"></i></a>
	</div>

	<header class="entry-header">
		<?php if( !is_singular() ) : ?>
	    	<h2 class="entry-title"><a class="reserve" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s',  THEME_FX ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php else : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>

	    <?php if ( 'post' == get_post_type() ) : ?>
		    <div class="entry-meta">
		    	<?php 
				printf( 
				    __('Posted on %1$s by %2$s ', THEME_FX) , 
				    get_the_time('F j, Y'),
				    get_the_author()
				);
				_e('in ', THEME_FX) . the_category(', ');
				_e(' with ', THEME_FX) . comments_popup_link( 'No comments', '1 comment', '% comments', 'comments-link', 'Comments Disabled' );
				?>
		    </div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
	    <?php 
	    if ( is_search() ){
	    	the_excerpt();
    	} else{
    		the_content();
    		wp_link_pages( array('before' => '<div class="page-link"><span>'. __('Pages:', THEME_FX).'</span>', 'after' => '</div>') );
    	} 
	    ?>
	</div>

    <?php if( is_singular() && ft_get_option('author_box') != 'off') get_template_part('includes/author', 'box'); ?>

</article><!-- #post <?php the_ID(); ?> -->