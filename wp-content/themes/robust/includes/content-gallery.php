<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>

	<?php if( !is_singular() ) : ?><?php global $more; $more = 0; ?><?php endif; ?>

	<div class="entry-badge">
	    <a href="<?php the_permalink(); ?>"><i class="icon-picture"></i></a>
	</div>

	<?php
	$images = get_post_meta($post->ID, 'ft_gallery_images', true);
	$image_height = get_post_meta($post->ID, 'ft_gallery_image_height', true);
	$image_size = ($image_height) ? '548x' . $image_height : 'fullwidth';
		if ($images) : ?>
		<div class="entry-asset asset-gallery flexslider">
	        <ul class="slides">
	        	<?php
		        foreach ( $images as $image ) {

		        	if( !is_numeric($image) ) {
                        $image_id = freshthemes_get_attachement_id($image);
                    }
                    else {
                        $image_id = $image;
                    }
                    
					if( $image_id ) {
						echo '<li><a href="'. wp_get_attachment_url($image_id) .'" rel="prettyPhoto[pp_gal]">'. wp_get_attachment_image( $image_id, $image_size ) .'</a></li>';
					}
		        }
		        ?>
		    </ul>
    	</div>
	<?php endif; ?>

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