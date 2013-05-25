<?php
/**
 *	FreshThemes Recent Posts
 * 	---------------------------------------------------------------------------
 *	@author 	: Rifki Aria Gumelar
 *	@link		: http://www.freshthemes.net
 *	@copyright	: Copyright (c) 2012, http://www.freshthemes.net
 *	--------------------------------------------------------------------------- */
 
/*	Register Widget
 *	---------------------------------------- */
	add_action( 'widgets_init', 'register_freshthemes_tweets_widget' );

	function register_freshthemes_tweets_widget() {
		register_widget( 'freshthemes_tweets_widget' );
	}
	
/*	Widget class
 *	---------------------------------------- */
	class freshthemes_tweets_widget extends WP_Widget {
		
		// The constructor
		function __construct() {
			$widget_ops = array(
				'classname' => 'widget-tweets', 
				'description' => __( 'A widget to displays your tweets.', THEME_FX) 
			);
			
			parent::__construct(
				'freshthemes-tweets', 
				THEME_NAME . __(' Tweets', THEME_FX), 
				$widget_ops
			);
		}
		
		// Display the widget
		function widget($args, $instance) {
			extract($args);
			$title = apply_filters('widget_title', apply_filters('widget_title', empty( $instance['title'] ) ? __('Tweets', THEME_FX) : $instance['title'], $instance, $this->id_base) );
			$id = $instance['id'];
			$count = $instance['count'];
			
			echo $before_widget;
			if ($title) 
			echo $before_title . $title . $after_title; 
			?>
            <div class="tweet tweet_<?php echo $id; ?>"></div>
            
            <script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($){
				$('.tweet_<?php echo $id; ?>').tweet({
					username:'<?php echo $id; ?>',
					join_text:'auto',
					count:'<?php echo $count; ?>',
					template: '{text}'+ '<br/>' +'{time}',
					auto_join_text_reply: null,
					auto_join_text_default: null, 
					auto_join_text_ed: null,
					auto_join_text_ing: null,
					auto_join_text_reply: null,
					auto_join_text_url: null, 
					loading_text: '<?php _e('loading tweets...', THEME_FX); ?>'
				})
			});
			//]]>
			</script>
            
            <?php
			echo $after_widget;
		}
		
		// Update widget options
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['id']	= strip_tags( $new_instance['id'] );
			$instance['count'] = $new_instance['count'];
			
			return $instance;
		}
		
		// Widget options form.
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'id' => '',
				'count' => '2'
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
            
            <p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_FX ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Twitter Username:', THEME_FX) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $instance['id']; ?>" />
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Tweet:', THEME_FX) ?></label>
				<input type="number" class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
			</p>
            
			<?php
		}
		
	}