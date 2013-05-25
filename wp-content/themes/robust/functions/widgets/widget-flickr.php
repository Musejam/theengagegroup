<?php
/**
 *	FreshThemes Flickr Widget
 * 	---------------------------------------------------------------------------
 *	@author 	: Rifki Aria Gumelar
 *	@link		: http://www.freshthemes.net
 *	@copyright	: Copyright (c) 2012, http://www.freshthemes.net
 *	--------------------------------------------------------------------------- */
 
/*	Register Widget
 *	---------------------------------------- */
	add_action( 'widgets_init', 'register_freshthemes_flickr_widget' );

	function register_freshthemes_flickr_widget() {
		register_widget( 'freshthemes_flickr_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_flickr_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-flickr', 
				'description' => __( 'Flickr photo stream widget.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-flickr', 
				THEME_NAME . __(' Flickr', THEME_FX), 
				$widget_ops
			);
		}
		
		// Display the widget
		function widget($args, $instance) {
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			$id = $instance['id'];
			$count = $instance['count'];
			
			echo $before_widget;
			if ($title) 
			echo $before_title . $title . $after_title; 
			
			if($id) :
			?>
            <div id="flickr-<?php echo str_replace('@', '', $id) ; ?>" class="flickr-photos">
            	<ul></ul>
            </div>
            
            <script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($) {
				$('#flickr-<?php echo str_replace('@', '', $id); ?> ul').jflickrfeed({
					limit: <?php echo $count; ?>,
					qstrings: {
						id: '<?php echo $id; ?>'
					},
					itemTemplate: '<li><a href="{{link}}"><img class="flickr" src="{{image_s}}" alt="{{title}}"></a></li>'
				});	
            });	
			//]]>
			</script>
            <?php
			endif;
			
			echo $after_widget;
		}
		
		// Update widget options
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['id'] = strip_tags($new_instance['id']);
			$instance['count'] = strip_tags($new_instance['count']);
			
			return $instance;
		}
		
		// Widget options form.
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'id' => '',
				'count' => '8'
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
            
            <p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr User ID:', THEME_FX) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $instance['id']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of photo:', THEME_FX) ?></label>
				<input type="number" class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
			</p>
            
			<?php
		}
		
	}