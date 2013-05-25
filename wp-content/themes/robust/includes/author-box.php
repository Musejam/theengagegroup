<section id="author-box" class="author-info clearfix">
 	
	<div class="heading">
		<h3><?php echo ft_get_option('author_box_heading'); ?></h3>
		<div class="sep"></div>
	</div>

	<div class="author-box-inner">
	 	<figure class="author-avatar">
	        <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>">
				<?php echo get_avatar( get_the_author_meta('user_email'), '45', '' ); ?>
	        </a>
	    </figure>
	    
	    <div class="author-description">
	    	<h3><?php the_author_posts_link(); ?></h3>
	        <p><?php the_author_meta('description'); ?></p>
	    </div>
	</div>

</section>