<?php
/**
 *	FreshThemes Dribble Widget
 * 	---------------------------------------------------------------------------
 *	@author 	: Rifki Aria Gumelar
 *	@link		: http://www.freshthemes.net
 *	@copyright	: Copyright (c) 2012, http://www.freshthemes.net
 *	--------------------------------------------------------------------------- */
 
/*	Register Widget
 *	---------------------------------------- */
	add_action( 'widgets_init', 'register_freshthemes_dribbble_widget' );

	function register_freshthemes_dribbble_widget() {
		register_widget( 'freshthemes_dribbble_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_dribbble_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-dribbble', 
				'description' => __( 'Dribbble shots widget.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-dribbble', 
				THEME_NAME . __(' Dribbble', THEME_FX), 
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
            <div id="dribbble-<?php echo str_replace('@', '', $id) ; ?>" class="dribbble-shots">
            	<ul></ul>
            </div>
            
            <script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($) {
				$.jribbble.getShotsByPlayerId('<?php echo $id; ?>', function (playerShots) { 
					var html = [];
					$.each(playerShots.shots, function (i, shot) {
						html.push('<li><a href="' + shot.url + '">');
						html.push('<img src="' + shot.image_teaser_url + '" ');
						html.push('title="' + shot.title + '"></a></li>');
					});
			
					$('#dribbble-<?php echo $id; ?> ul').html(html.join(''));
				}, {page: 1, per_page: <?php echo $count; ?>});    
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
				<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Dribbble Username:', THEME_FX) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $instance['id']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of photo:', THEME_FX) ?></label>
				<input type="number" class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
			</p>
            
			<?php
		}
		
	}