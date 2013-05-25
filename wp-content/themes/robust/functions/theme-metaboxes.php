<?php
/**
*   FreshTheme Framework Theme Metaboxes
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @version	: 1.2
*   @copyright	: Copyright (c) 2012, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   @credits	: Devin Price, http://wptheming.com/
*                 WooThemes, http://www.woothemes.com/
*                 Gilles Vauvarin
*   --------------------------------------------------------------------------- */

/*	Metabox Config
 *	--------------------------------------------------------- */
	add_filter( 'freshmetabox', 'freshthemes_theme_metaboxes' );
	
	function freshthemes_theme_metaboxes( array $metaboxes ) {
		
		/* Prefix */
		$fx = 'ft_';

		/* Enable and Disable option */
		$onoff = array('on' => __('Enable', THEME_FX),'off' => __('Disable', THEME_FX) );
		
		/* Background defaults */
		$bg_defaults = array( 
			'color' => '', 
			'image' => '', 
			'repeat' => 'repeat', 
			'position' => 'top center', 
			'attachment' => 'scroll'
		);

		/* Get custom sidebars */
		$sidebarArr = ft_get_option('sidebars');

		$sidebars = array(); 
		$sidebars[''] = 'Default';

		if( is_array($sidebarArr) ) {
			foreach ($sidebarArr as $k => $v) {
				$sidebars[$v] = $v;
			}
		}

		/* Get sliders */
		$sliders_array = array();

		if( class_exists('RevSlider') ) {
			$sliders = new RevSlider();
	    	$sliders_array = $sliders->getArrSlidersShort();
	    }
		
		/* Path to image directory */
		$imagepath =  THEME_DIR . 'framework/images/';
		
		/* Gallery post format option */
		$metaboxes[] = array(
			'id'		 => 'gallery_post_format_options',
			'title'      => __('Gallery Post Format', THEME_FX),
			'pages'      => array('post'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				
				array(
					'id'	=> $fx . 'gallery_images',
					'name'	=> __('Gallery Images', THEME_FX ),
					'desc'	=> __('Upload your images.', THEME_FX),
					'type'	=> 'multiupload',
					'std'	=> ''
				),

				array(
					'id'	=> $fx . 'gallery_image_height',
					'name'	=> __('Image Height', THEME_FX ),
					'desc'	=> __('Set the image height.', THEME_FX),
					'type'	=> 'text',
					'std'	=> '260'
				)
				
			)
		);

		/* Image post format option */
		// $metaboxes[] = array(
		// 	'id'		 => 'image_post_format_options',
		// 	'title'      => __('Image Post Format', THEME_FX),
		// 	'pages'      => array('post'),
		// 	'context'    => 'normal',
		// 	'priority'   => 'high',
		// 	'fields' => array(
				
		// 		array(
		// 			'id'	=> $fx . 'image_height',
		// 			'name'	=> __('Image Height', THEME_FX ),
		// 			'desc'	=> __('Set the image height.', THEME_FX),
		// 			'type'	=> 'text',
		// 			'std'	=> '260'
		// 		)
				
		// 	)
		// );
		
		$metaboxes[] = array(
			'id'		 => 'video_post_format_options',
			'title'      => __('Video Post Format', THEME_FX),
			'pages'      => array('post'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				
				array(
					'id'	=> $fx . 'video_url',
					'name'	=> __('Video URL', THEME_FX ),
					'desc'	=> sprintf(__( 'Paste the video URL here, click %s to see all available video hosts.', THEME_FX ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">here</a>' ),
					'type'	=> 'text',
					'std'	=> ''
				),
				
			)
		);
		
		$metaboxes[] = array(
			'id'		 => 'link_post_format_options',
			'title'      => __('Link Post Format', THEME_FX),
			'pages'      => array('post'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				array(
					'id'	=> $fx . 'link_destination',
					'name'	=> __('Link Destination', THEME_FX ),
					'desc'	=> __('Enter the link destination URL.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),
				array(
					'id'	=> $fx . 'link_display',
					'name'	=> __('Link to Display', THEME_FX ),
					'desc'	=> __('Enter the link URL to display. Sometimes you might add a referral link to the destination URL so that you can modify the link to be displayed in this field.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),

				array(
					'id'	=> $fx . 'link_targeting',
					'name' => __('Link Targeting', THEME_FX ),
					'desc'	=> __('Check this to make the link open in the new tab.', THEME_FX),
					'type'	=> 'checkbox',
					'class' => ''
				),
			)
		);

		$metaboxes[] = array(
			'id'		 => 'quote_post_format_options',
			'title'      => __('Quote Post Format', THEME_FX),
			'pages'      => array('post'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				array(
					'id'	=> $fx . 'quote_author',
					'name'	=> __('Quote Author', THEME_FX ),
					'desc'	=> __('Enter the quote author name.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),
				array(
					'id'	=> $fx . 'quote_author_meta',
					'name'	=> __('Quote Author Meta', THEME_FX ),
					'desc'	=> __('Enter the quote author meta, something like the author job, company or website name.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),
				array(
					'id'	=> $fx . 'quote_text',
					'name'	=> __('Quote Text', THEME_FX ),
					'desc'	=> __('Enter the quote here.', THEME_FX),
					'type'	=> 'textarea',
					'std'	=> ''
				)
			)
		);
		
		$metaboxes[] = array(
			'id'		 => 'audio_post_format_options',
			'title'      => __('Audio Post Format', THEME_FX),
			'pages'      => array('post'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				
				array(
					'id'	=> $fx . 'audio_format',
					'name'	=> __('Format', THEME_FX ),
					'desc'	=> __('Select the audio file format.', THEME_FX),
					'type'	=> 'radio',
					'options' => array(
						'm4a' => __('M4A', THEME_FX),
						'mp3' => __('MP3', THEME_FX),
						'wav' => __('WAV', THEME_FX)
					),
					'std'	=> 'mp3'
				),
				array(
					'id'	=> $fx . 'audio_file',
					'name'	=> __('Audio File', THEME_FX ),
					'desc'	=> __('Upload your audio file or paste the file URL.', THEME_FX),
					'type'	=> 'upload',
					'std'	=> ''
				),
				array(
					'id'	=> $fx . 'audio_optional',
					'name'	=> __('OGG Audio File', THEME_FX ),
					'desc'	=> __('Optional, upload the OGG version of your audio file.', THEME_FX),
					'type'	=> 'upload',
					'std'	=> ''
				)

			)
		);
		
		$metaboxes[] = array(
			'id'		 => 'post_settings',
			'title'      => __('Post Settings', THEME_FX),
			'pages'      => array('post'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(

				array(
					'id'	=> $fx . 'post_sidebar',
					'name'	=> __('Custom Sidebar', THEME_FX ),
					'desc'	=> __('Select a custom sidebar for this post.', THEME_FX ),
					'type'	=> 'select',
					'options' => $sidebars,
					'std'	=> ''
				),
				
			)
		);
		
		$metaboxes[] = array(
			'id'		 => 'portfolio_settings',
			'title'      => __('Portfolio Settings', THEME_FX),
			'pages'      => array('portfolio'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				

				array(
					'id'	=> $fx . 'portfolio_layout',
					'name'	=> __('Layout Style', THEME_FX ),
					'desc'	=> __('Select the layout style.', THEME_FX ),
					'type'	=> 'images',
					'options' => array(
						'right-sidebar' => $imagepath . 'layout/a.png', 
						'left-sidebar' => $imagepath . 'layout/b.png', 
						'fullwidth' => $imagepath . 'layout/c.png'
					),
					'std'	=> 'right-sidebar'
				),

				array(
					'id'	=> $fx . 'portfolio_subtitle',
					'name'	=> __('Subtitle', THEME_FX ),
					'desc'	=> __('The project subtitle.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),

				array(
					'id'	=> $fx . 'portfolio_type',
					'name'	=> __('Project Type', THEME_FX ),
					'desc'	=> __('Select the type.', THEME_FX),
					'type'	=> 'select',
					'options' => array(
						'image' => __('Image', THEME_FX),
						'video' => __('Video', THEME_FX)
					),
					'std'	=> 'image'
				),
				
				array(
					'id'	=> $fx . 'portfolio_video',
					'name'	=> __('Video URL', THEME_FX ),
					'desc'	=> sprintf(__( 'Paste the video URL here, click %s to see all available video hosts.', THEME_FX ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">here</a>' ),
					'type'	=> 'text',
					'std'	=> ''
				),
				
				array(
					'id'	=> $fx . 'portfolio_images',
					'name'	=> __('Project Images', THEME_FX ),
					'desc'	=> __('Upload your project images.', THEME_FX),
					'type'	=> 'multiupload',
					'std'	=> ''
				),
				
				array(
					'id'	=> $fx . 'portfolio_client',
					'name'	=> __('Client', THEME_FX ),
					'desc'	=> __('Enter the client name.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),

				array(
					'id'	=> $fx . 'portfolio_date',
					'name'	=> __('Project Date', THEME_FX ),
					'desc'	=> __('Your project date.', THEME_FX),
					'type'	=> 'date',
					'std'	=> ''
				),

				array(
					'id'	=> $fx . 'portfolio_url',
					'name'	=> __('Project URL', THEME_FX ),
					'desc'	=> __('Your project URL.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				)
			)
		);
		
		$metaboxes[] = array(
			'id'		 => $fx . 'custom_page_settings',
			'title'      => __('Custom Page Settings', THEME_FX),
			'pages'      => array('page'),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields' => array(
				
				array(
					'id'	=> $fx . 'page_layout',
					'name'	=> __('Layout Style', THEME_FX ),
					'desc'	=> __('Select the layout style.', THEME_FX ),
					'type'	=> 'images',
					'options' => array(
						'right-sidebar' => $imagepath . 'layout/a.png', 
						'left-sidebar' => $imagepath . 'layout/b.png', 
						'fullwidth' => $imagepath . 'layout/c.png'
					),
					'std'	=> 'fullwidth'
				),
				
				array(
					'id'	=> $fx . 'page_sidebar',
					'name'	=> __('Custom Sidebar', THEME_FX ),
					'desc'	=> __('Select a custom sidebar for this page.', THEME_FX ),
					'type'	=> 'select',
					'options' => $sidebars,
					'std'	=> ''
				),

				array(
					'id'	=> $fx . 'page_title',
					'name' => __('Page Title', THEME_FX ),
					'desc'	=> __('Check this to hide the page title bar.', THEME_FX),
					'type'	=> 'toggle',
					'std' => 'on',
					'class' => ''
				),
				
				array(
					'id'	=> $fx . 'page_subtitle',
					'name'	=> __('Page Subtitle', THEME_FX ),
					'desc'	=> __('Enter the page subtitle, it will be displayed under the page title.', THEME_FX),
					'type'	=> 'text',
					'std'	=> ''
				),
				
				array(
					'id'	=> $fx . 'enable_slider',
					'name' => __('Enable Slider', THEME_FX ),
					'desc'	=> __('Check this to enable the slider for this page.', THEME_FX),
					'type'	=> 'checkbox',
					'class' => ''
				),

				array(
					'id'	=> $fx . 'rev_slider',
					'name'	=> __('Revolution Slider', THEME_FX ),
					'desc'	=> __('Select a revolution slider.', THEME_FX ),
					'type'	=> 'select',
					'options' => $sliders_array,
					'std'	=> ''
				)

			)
		);

		return $metaboxes;
	}