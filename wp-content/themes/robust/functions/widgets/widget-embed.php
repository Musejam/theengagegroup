<?php
/**
 *	FreshThemes Embed Widget
 * 	---------------------------------------------------------------------------
 *	@author 	: Rifki Aria Gumelar
 *	@link		: http://www.freshthemes.net
 *	@copyright	: Copyright (c) 2012, http://www.freshthemes.net
 *	--------------------------------------------------------------------------- */
 
/*	Register Widget
 *	---------------------------------------- */
	add_action( 'widgets_init', 'register_freshthemes_embed_widget' );

	function register_freshthemes_embed_widget() {
		register_widget( 'freshthemes_embed_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_embed_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-embed', 
				'description' => __( 'A video/audio embed widget.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-embed', 
				THEME_NAME . __(' Embed', THEME_FX), 
				$widget_ops
			);
		}
		
		// Display the widget
		function widget($args, $instance) {
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			$code = $instance['code'];
			
			echo $before_widget;
			if ($title) 
			echo $before_title . $title . $after_title; 
			
			if($code) :
			?>
			<div class="video-container">
        	<?php echo stripslashes($code); ?>
			</div>
            <?php
			endif;
			
			echo $after_widget;
		}
		
		// Update widget options
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['code'] = $new_instance['code'];
			
			return $instance;
		}
		
		// Widget options form.
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'code' => ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
            
            <p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
            
            <p>
				<label for="<?php echo $this->get_field_id('code'); ?>"><?php _e('Embed Code:', THEME_FX) ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" rows="5"><?php echo $instance['code']; ?></textarea>
			</p>
            
			<?php
		}
		
	}