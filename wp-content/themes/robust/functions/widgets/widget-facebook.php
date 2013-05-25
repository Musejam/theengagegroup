<?php
/**
 *	FreshThemes Facebook Widget
 * 	---------------------------------------------------------------------------
 *	@author 	: Rifki Aria Gumelar
 *	@link		: http://www.freshthemes.net
 *	@copyright	: Copyright (c) 2012, http://www.freshthemes.net
 *	--------------------------------------------------------------------------- */
 
/*	Register Widget
 *	---------------------------------------- */
	add_action( 'widgets_init', 'register_freshthemes_facebook_widget' );

	function register_freshthemes_facebook_widget() {
		register_widget( 'freshthemes_facebook_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_facebook_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-facebook', 
				'description' => __( 'Facebook likebox widget.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-facebook', 
				THEME_NAME . __(' Facebook', THEME_FX), 
				$widget_ops
			);
		}
		
		// Display the widget
		function widget($args, $instance) {
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			$id = $instance['id'];
			
			echo $before_widget;
			if ($title) 
			echo $before_title . $title . $after_title; 
			
			if($id) :
			
			$http_query = http_build_query( 
				array(
					'href' => 'http://www.facebook.com/' . $id,
					'width' => '306',
					'height' => '258',
					'colorscheme' => 'light',
					'show_faces' => 'true',
					'border_color' => '#eaeaea',
					'stream' => 'false',
					'header' => 'false'
				)
			);
			?>
            <div class="facebook-likebox">
            <iframe src="http://www.facebook.com/plugins/likebox.php?<?php echo $http_query; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:306px; height:258px;" allowTransparency="true"></iframe>
            </div>
            <style>.facebook-likebox iframe{width:100%;max-width:100%;height:auto;margin:0;padding:0;}</style>
            <?php
			endif;
			
			echo $after_widget;
		}
		
		// Update widget options
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['id'] = strip_tags($new_instance['id']);
			
			return $instance;
		}
		
		// Widget options form.
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'id' => ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
            
            <p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Facebook Page ID:', THEME_FX) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $instance['id']; ?>" />
			</p>
            
			<?php
		}
		
	}