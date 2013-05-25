<?php
/**
 *	FreshThemes Recent Portfolio Widget
 * 	---------------------------------------------------------------------------
 *	@author 	: Rifki Aria Gumelar
 *	@link		: http://www.freshthemes.net
 *	@copyright	: Copyright (c) 2012, http://www.freshthemes.net
 *	--------------------------------------------------------------------------- */
 
/*	Register Widget
 *	---------------------------------------- */
	add_action( 'widgets_init', 'register_freshthemes_recent_portfolio_widget' );

	function register_freshthemes_recent_portfolio_widget() {
		register_widget( 'freshthemes_recent_portfolio_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_recent_portfolio_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-recent-portfolio', 
				'description' => __( 'The most recent portfolio on your site.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-recent-portfolio', 
				THEME_NAME . __(' Recent Portfolio', THEME_FX), 
				$widget_ops
			);
		}
		
		// Display the widget
		function widget($args, $instance) {
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			$post_num = $instance['post_num'];
			
			echo $before_widget;
			if ($title) 
			echo $before_title . $title . $after_title; 
			
			if($post_num) :
			?>
				<ul>
        		<?php $query = new WP_Query( 'post_type=portfolio&posts_per_page='.$post_num ); ?>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s',  THEME_FX ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo get_the_post_thumbnail(get_the_id(), '150x150'); ?></a></li>
                    <?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				</ul>
            <?php
			endif;
			
			echo $after_widget;
		}
		
		// Update widget options
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['post_num'] = $new_instance['post_num'];
			
			return $instance;
		}
		
		// Widget options form.
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'post_num' => '8'
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
            
            <p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('post_num'); ?>"><?php _e('Number of item:', THEME_FX) ?></label>
				<input type="number" class="widefat" id="<?php echo $this->get_field_id('post_num'); ?>" name="<?php echo $this->get_field_name('post_num'); ?>" value="<?php echo $instance['post_num']; ?>" />
			</p>
            
			<?php
		}
		
	}