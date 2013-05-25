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
	add_action( 'widgets_init', 'register_freshthemes_about_widget' );

	function register_freshthemes_about_widget() {
		register_widget( 'freshthemes_about_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_about_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-about', 
				'description' => __( 'A widget to display a little about your company.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-about-widget', 
				THEME_NAME . __(' About', THEME_FX), 
				$widget_ops
			);
		}
		
		// Display the widget
		function widget($args, $instance) {
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			$email = $instance['email'];
			$phone = $instance['phone'];
			$address = $instance['address'];
			$desc = $instance['desc'];
			
			echo $before_widget;
			if ($title) 
			echo $before_title . $title . $after_title; 
			
			if($desc)
				echo '<p>'. $desc .'</p>';
			if($address)
				echo '<div class="address"><i class="icon-map-marker"></i>&nbsp;&nbsp;'. $address .'</div>';
			if($phone)
				echo '<div class="phone"><i class="icon-phone-sign"></i> '. $phone .'</div>';
			if($email)
				echo '<div class="email"><i class="icon-envelope-alt"></i> '. $email .'</div>';

			
			echo $after_widget;
		}
		
		// Update widget options
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['email'] = $new_instance['email'];
			$instance['phone'] = $new_instance['phone'];
			$instance['address'] = $new_instance['address'];
			$instance['desc'] = $new_instance['desc'];
			
			return $instance;
		}
		
		// Widget options form.
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'email' => get_option('admin_email'),
				'phone' => '',
				'address' => '',
				'desc' => ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
            
            <p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo $instance['email']; ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
			</p>
            
            <p>
				<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', THEME_FX) ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" rows="2"><?php echo $instance['address']; ?></textarea>
			</p>
            
            <p>
				<label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Short description:', THEME_FX) ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" rows="5"><?php echo $instance['desc']; ?></textarea>
			</p>
            
			<?php
		}
		
	}