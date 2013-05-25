<?php
 
/*	Option name
 *	------------------------------------------------------------------- */
	function freshframework_option_name() {
		// This gets the theme name from the stylesheet
		$themename = THEME_FX;
		$freshthemes_settings = get_option( 'freshthemes' );
		$freshthemes_settings['id'] = $themename;
		update_option( 'freshthemes', $freshthemes_settings );
	}

/*	Options array
 *	------------------------------------------------------------------- */
	function freshframework_options() {
		$prefix = THEME_FX . '_';
		
		/* Enable - Disable options. */
		$onoff = array('on' => __('Enable', THEME_FX),'off' => __('Disable', THEME_FX) );
		
		/* If using image, define a directory path */
		$imagepath =  THEME_DIR . 'framework/images/';
		
		/* Background defaults */
		$background_defaults = array(
			'color' => '',
			'image' => '',
			'repeat' => 'repeat',
			'position' => 'top center',
			'attachment'=>'scroll' 
		);
		
		/* Typography Defaults */
		$typography_defaults = array(
			'size' => '14px',
			'face' => 'Source Sans Pro, sans-serif',
			'color' => '#696763'
		);
	
		/* Mixed fonts */
		$typography_mixed_fonts = array_merge( 
			freshthemes_typography_get_os_fonts() , 
			freshthemes_typography_get_google_fonts() 
		);
		asort($typography_mixed_fonts);
		
		/* WP Editor Settings */
		$wp_editor_settings = array(
			'wpautop' => true, // Default
			'textarea_rows' => 8,
			'tinymce' => array( 'plugins' => 'wordpress' )
		);
		
		/* Pull all the categories into an array for multicheck option */
		$options_categories_multicheck = array();
		$options_categories_multicheck_obj = get_categories();
		foreach ($options_categories_multicheck_obj as $category) {
			$options_categories_multicheck[$category->cat_ID] = $category->cat_name;
		}
		
		/* Options start */
		$options = array();

		/* ----------------------------------------------------------
		 * General Settings
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('General', THEME_FX),
			'type' => 'heading',
			'icon' => 'home'
		);

			/* Logo */
			$options[] = array(
				'name' => __('Logo', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'logo',
					'name' => __('Logo', THEME_FX),
					'desc' => __('Upload your custom logo image', THEME_FX),
					'type' => 'upload',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'logo_top_margin',
					'name' => __('Logo Top Margin', THEME_FX),
					'desc' => __('Logo top margin value', THEME_FX),
					'type' => 'slider',
					'std'  => '40',
					'class' => 'last'
				);

			/* Favicons */
			$options[] = array(
				'name' => __('Favicons', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'favicon',
					'name' => __('Favicon', THEME_FX),
					'desc' => __('Upload your favicon (16x16).', THEME_FX),
					'type' => 'upload',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'iphone_favicon',
					'name' => __('iPhone Favicon', THEME_FX),
					'desc' => __('Upload your favicon (57x57) for iPhone device.', THEME_FX),
					'type' => 'upload',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'iphone_retina_favicon',
					'name' => __('iPhone Retina Favicon', THEME_FX),
					'desc' => __('Upload your favicon (114x114) for iPhone device  with retina display.', THEME_FX),
					'type' => 'upload',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'ipad_favicon',
					'name' => __('iPad Favicon', THEME_FX),
					'desc' => __('Upload your favicon (72x72) for iPad device.', THEME_FX),
					'type' => 'upload',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'ipad_retina_favicon',
					'name' => __('iPad Retina Favicon', THEME_FX),
					'desc' => __('Upload your favicon (144x144) for iPad device with retina display.', THEME_FX),
					'type' => 'upload',
					'std'  => '',
					'class' => 'last'
				);

			/* Favicons */
			$options[] = array(
				'name' => __('Info', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'top_info',
					'name' => __('Top Info', THEME_FX),
					'desc' => __('Enter your top info content, HTML tags are allowed.', THEME_FX),
					'type' => 'textarea',
					'settings' => array('rows' => 5),
					'std'  => 'Your info goes here!',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'call_us',
					'name' => __('Call Us', THEME_FX),
					'desc' => __('Enter your call us content, HTML tags are allowed.', THEME_FX),
					'type' => 'textarea',
					'settings' => array('rows' => 5),
					'std'  => 'Toll Free Number: (123) 456-7890 - Email: hello@robust.com',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'copyright_text',
					'name' => __('Copyright', THEME_FX),
					'desc' => __('Enter your copyright text content, HTML tags are allowed.', THEME_FX),
					'type' => 'textarea',
					'settings' => array('rows' => 5),
					'std'  => '',
					'class' => 'last'
				);

			/* Integration */
			$options[] = array(
				'name' => __('Integration', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'feed_links',
					'name' => __('Automatic Feed Links', THEME_FX),
					'desc' => __('Enable/disable automatically feed links in the <code>&lt;head&gt;</code> section.', THEME_FX),
					'type' => 'toggle',
					'std'  => 'on',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'head_code',
					'name' => __('Head Code', THEME_FX),
					'desc' => __('You can use this field to insert additional codes to be placed in the <code>wp_head()</code>. e.g. Custom script, analytic code, advertising code etc.', THEME_FX),
					'type' => 'textarea',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_code',
					'name' => __('Footer Code', THEME_FX),
					'desc' => __('You can use this field to insert additional codes to be placed in the <code>wp_footer()</code>. e.g. Custom script, analytic code, advertising code etc.', THEME_FX),
					'type' => 'textarea',
					'std'  => '',
					'class' => 'last'
				);

		/* ----------------------------------------------------------
		 * Styling
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('Customization', THEME_FX),
			'type' => 'heading',
			'icon' => 'appearance'
		);

			/* Global */
			$options[] = array(
				'name' => __('Global', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'layout_type',
					'name' => __('Layout Type', THEME_FX),
					'desc' => __('Select the preferred layout type.', THEME_FX),
					'type' => 'radio',
					'options' => array(
						'wide' => __('Wide', THEME_FX), 
						'boxed' => __('Boxed', THEME_FX)
					),
					'std'  => 'wide',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'responsive',
					'name' => __('Responsive', THEME_FX),
					'desc' => __('Enable/disable the responsive layout.', THEME_FX),
					'type' => 'toggle',
					'std'  => 'on',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'body_bg',
					'name' => __('Body Background', THEME_FX),
					'desc' => __('Customize your site background, this option only for boxed layout type.', THEME_FX),
					'type' => 'background', 
					'std'  => $background_defaults,
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'color_scheme',
					'name' => __('Color Scheme', THEME_FX),
					'desc' => __('Select a color for global color scheme.', THEME_FX),
					'type' => 'color', 
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'custom_css',
					'name' => __('Custom CSS', THEME_FX),
					'desc' => __('The quick and save way to add your custom CSS code.', THEME_FX),
					'type' => 'textarea',
					'settings' => array('rows' => 12),
					'std'  => '',
					'class' => 'last'
				);

			/* Top Header */
			$options[] = array(
				'name' => __('Top Header', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'top_header',
					'name' => __('Top Header', THEME_FX),
					'desc' => __('Enable/disable the top header bar.', THEME_FX),
					'type' => 'toggle',
					'std'  => 'on',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'top_header_bg',
					'name' => __('Background', THEME_FX),
					'desc' => __('Select a color for the top header background.', THEME_FX),
					'type' => 'color',
					'std'  => '#f2f2f2',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'top_header_border_top_color',
					'name' => __('Top Border Color', THEME_FX),
					'desc' => __('Select a color for top border.', THEME_FX),
					'type' => 'color',
					'std'  => '#94ba65',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'top_header_border_bottom_color',
					'name' => __('Bottom Border Color', THEME_FX),
					'desc' => __('Select a color for bottom border.', THEME_FX),
					'type' => 'color',
					'std'  => '#ebebea',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'top_header_text_color',
					'name' => __('Text Color', THEME_FX),
					'desc' => __('Select a color for the top header bar text.', THEME_FX),
					'type' => 'color',
					'std'  => '#696763',
					'class' => 'last'
				);

			/* Header */
			$options[] = array(
				'name' => __('Header', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'header_bg',
					'name' => __('Background', THEME_FX),
					'desc' => __('Customize your header background.', THEME_FX),
					'type' => 'background',
					'std'  => $background_defaults,
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'header_type',
					'name' => __('Header Type', THEME_FX),
					'desc' => __('Select the preferred header type', THEME_FX),
					'type' => 'select',
					'options' => array( '' => __('Normal', THEME_FX), 'fixed' => __('Fixed', THEME_FX) ),
					'std'  => 'normal',
					'class' => 'last'
				);

			/* Page Title */
			$options[] = array(
				'name' => __('Page Title', THEME_FX),
				'type' => 'subheading',
			);

				$options[] = array(
					'id'   => $prefix . 'page_title_bg',
					'name' => __('Background', THEME_FX),
					'desc' => __('Change the page title background.', THEME_FX),
					'type' => 'background',
					'std'  => array(
						'color' => '#f2f2f2',
						'image' => '',
						'repeat' => 'repeat',
						'position' => 'top center',
						'attachment'=>'scroll' 
					),
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'page_title_border_color',
					'name' => __('Border Color', THEME_FX),
					'desc' => __('Select a color for the page title border.', THEME_FX),
					'type' => 'color',
					'std'  => '#ebebea',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'page_title_heading_color',
					'name' => __('Heading Color', THEME_FX),
					'desc' => __('Select a color for the page title heading.', THEME_FX),
					'type' => 'color',
					'std'  => '#4a4845',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'page_title_desc_color',
					'name' => __('Description Color', THEME_FX),
					'desc' => __('Select a color for the page title description.', THEME_FX),
					'type' => 'color',
					'std'  => '#696763',
					'class' => ''
				);

				$options[] = array(
					'id'   => $prefix . 'page_title_searchform',
					'name' => __('Search Form', THEME_FX),
					'desc' => __('Enable/disable the search form in page title bar.', THEME_FX),
					'type' => 'toggle',
					'std'  => 'on',
					'class' => 'last'
				);

			/* Menu */
			$options[] = array(
				'name' => __('Menu', THEME_FX),
				'type' => 'subheading',
			);

				$options[] = array(
					'id'   => $prefix . 'menu_link_color',
					'name' => __('Menu Item Link Color', THEME_FX),
					'desc' => __('Select a color for the menu item link.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'menu_link_desc_color',
					'name' => __('Menu Item Description Color', THEME_FX),
					'desc' => __('Select a color for the menu item description.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'menu_link_indicator_color',
					'name' => __('Menu Item Link Color', THEME_FX),
					'desc' => __('Select a color for the menu item link indicator (hover & active).', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => 'last'
				);

			/* Footer Widgets */
			$options[] = array(
				'name' => __('Footer Widgets Area', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'footer_widgets_bg',
					'name' => __('Background', THEME_FX),
					'desc' => __('Change your footer widgets area background.', THEME_FX),
					'type' => 'background',
					'std'  => $background_defaults,
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_widgets_top_border_color',
					'name' => __('Top Border Color', THEME_FX),
					'desc' => __('Select a color for the footer widgets area top border.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_widgets_title_color',
					'name' => __('Widget Title Color', THEME_FX),
					'desc' => __('Select a color for the footer widget title.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_widgets_text_color',
					'name' => __('Widget Text Color', THEME_FX),
					'desc' => __('Select a color for the footer widget text.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_widgets_link_color',
					'name' => __('Widget Link Color', THEME_FX),
					'desc' => __('Select a color for the footer widget link text.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_widgets_link_hover_color',
					'name' => __('Widget Link Hover Color', THEME_FX),
					'desc' => __('Select a color for the footer widget link text hover.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => 'last'
				);

			/* Footer Bottom */
			$options[] = array(
				'name' => __('Footer Bottom', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'footer_bottom_bg',
					'name' => __('Background', THEME_FX),
					'desc' => __('Change your footer bottom area background.', THEME_FX),
					'type' => 'background',
					'std'  => $background_defaults,
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_bottom_top_border_color',
					'name' => __('Top Border Color', THEME_FX),
					'desc' => __('Select a color for the footer bottom area top border.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_bottom_text_color',
					'name' => __('Text Color', THEME_FX),
					'desc' => __('Select a color for the footer bottom area text.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_bottom_link_color',
					'name' => __('Link Color', THEME_FX),
					'desc' => __('Select a color for the footer bottom area link text.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'footer_bottom_link_hover_color',
					'name' => __('Link Hover Color', THEME_FX),
					'desc' => __('Select a color for the footer bottom area link text hover.', THEME_FX),
					'type' => 'color',
					'std'  => '',
					'class' => 'last'
				);

		/* ----------------------------------------------------------
		 * Typography
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('Typography', THEME_FX),
			'type' => 'heading',
			'icon' => 'post'
		);
			$options[] = array(
				'id'   => $prefix . 'body_typo',
				'name' => __('Body Font', THEME_FX),
				'desc' => __('The global text style.', THEME_FX),
				'type' => 'typography',
				'options' => array( 'faces' => $typography_mixed_fonts, 'styles' => false, 'cases' => false ),
				'std'  => $typography_defaults,
				'class' => ''
			);
			$options[] = array(
				'id'   => $prefix . 'heading_typo',
				'name' => __('Heading Font', THEME_FX),
				'desc' => __('The heading tags (h1 - h6) text styles.', THEME_FX),
				'type' => 'typography',
				'options' => array( 'faces' => $typography_mixed_fonts, 'styles' => false, 'sizes' => false, 'cases' => false ),
				'std'  => array( 'face' => 'Source Sans Pro, sans-serif', 'color' => '#4a4845'),
				'class' => ''
			);
			$options[] = array(
				'id'   => $prefix . 'primary_menu_typo',
				'name' => __('Primary Menu', THEME_FX),
				'desc' => __('Primary menu text style.', THEME_FX),
				'type' => 'typography',
				'options' => array( 'faces' => $typography_mixed_fonts, 'styles' => false, 'color' => false ),
				'std'  => array( 'face' => 'Source Sans Pro, sans-serif', 'size' => '16px', 'case' => 'none'),
				'class' => ''
			);
			$options[] = array(
				'id'   => $prefix . 'footer_menu_typo',
				'name' => __('Footer Menu', THEME_FX),
				'desc' => __('Footer menu text style.', THEME_FX),
				'type' => 'typography',
				'options' => array( 'faces' => $typography_mixed_fonts, 'styles' => false, 'color' => false ),
				'std'  => array( 'face' => 'Source Sans Pro, sans-serif', 'size' => '14px', 'case' => 'none'),
				'class' => 'last'
			);

		/* ----------------------------------------------------------
		 * Blog
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('Blog', THEME_FX),
			'type' => 'heading',
			'icon' => 'page'
		);
			$options[] = array(
				'id'   => $prefix . 'readmore_label',
				'name' => __('Read More Label', THEME_FX),
				'desc' => __('Enter the readmore button text label.', THEME_FX),
				'type' => 'text',
				'std'  => __('Read more &rarr;', THEME_FX),
				'class' => ''
			);
			$options[] = array(
				'id'   => $prefix . 'author_box',
				'name' => __('Author Info', THEME_FX),
				'desc' => __('Enable/disable the author info.', THEME_FX),
				'type' => 'toggle',
				'std'  => 'on',
				'class' => ''
			);
			$options[] = array(
				'id'   => $prefix . 'author_box_heading',
				'name' => __('Author Info Heading Text', THEME_FX),
				'desc' => __('Enter the author information box heading text.', THEME_FX),
				'type' => 'text',
				'std'  => __('About the Author', THEME_FX),
				'class' => 'last'
			);

		/* ----------------------------------------------------------
		 * Portfolio
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('Portfolio', THEME_FX),
			'type' => 'heading',
			'icon' => 'portfolio'
		);

			/* Overview Portfolio */
			$options[] = array(
				'name' => __('Items Overview', THEME_FX),
				'type' => 'subheading',
			);

				$options[] = array(
					'id'   => $prefix . 'portfolio_filter',
					'name' => __('Portfolio Filter', THEME_FX),
					'desc' => __('Enable/disable the portfolio filter.', THEME_FX),
					'type' => 'toggle',
					'std'  => 'on',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'portfolio_slug',
					'name' => __('Portfolio Slug', THEME_FX),
					'desc' => __('Please save the permalink settings after changing this option.', THEME_FX),
					'type' => 'text',
					'std'  => 'portfolio',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'portfolio_posts_per_page',
					'name' => __('Items Per Page', THEME_FX),
					'desc' => __('Enter the number of items you want to show on portfolio page overview.', THEME_FX),
					'type' => 'text',
					'std'  => '12',
					'class' => 'last'
				);

			/* Single Portfolio */
			$options[] = array(
				'name' => __('Single Item', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'portfolio_description_heading',
					'name' => __('Portfolio Description Heading', THEME_FX),
					'desc' => __('Enter the portfolio description heading text.', THEME_FX),
					'type' => 'text',
					'std'  => __('Project Description', THEME_FX),
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'portfolio_details_heading',
					'name' => __('Portfolio Details Heading', THEME_FX),
					'desc' => __('Enter the portfolio details heading text.', THEME_FX),
					'type' => 'text',
					'std'  => __('Project Details', THEME_FX),
					'class' => 'last'
				);

			/* Related Portfolio */
			$options[] = array(
				'name' => __('Related Items', THEME_FX),
				'type' => 'subheading',
			);
				$options[] = array(
					'id'   => $prefix . 'enable_portfolio_related',
					'name' => __('Related Portfolio', THEME_FX),
					'desc' => __('Enable/disable the related portfolio section on the single portfolio page.', THEME_FX),
					'type' => 'toggle',
					'std'  => 'on',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'portfolio_related_heading',
					'name' => __('Related Portfolio Heading', THEME_FX),
					'desc' => __('Enter the related portfolio heading text.', THEME_FX),
					'type' => 'text',
					'std'  => __('Related Projects', THEME_FX),
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'portfolio_related_number',
					'name' => __('Related Portfolio Post Number', THEME_FX),
					'desc' => __('The number of portfolio item to show.', THEME_FX),
					'type' => 'text',
					'std'  => '4',
					'class' => ''
				);
				$options[] = array(
					'id'   => $prefix . 'portfolio_related_column',
					'name' => __('Related Portfolio Column', THEME_FX),
					'desc' => __('Select the portfolio item column.', THEME_FX),
					'type' => 'select',
					'options' => array('2' => 'Two Columns', '3' => 'Three Columns', '4' => 'Four Columns'),
					'std'  => '4',
					'class' => 'last'
				);

		/* ----------------------------------------------------------
		 * Sidebar Manager
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('Sidebars', THEME_FX),
			'type' => 'heading',
			'icon' => 'layout'
		);

			$options[] = array(
				'id'   => $prefix . 'sidebars',
				'name' => __('Custom Sidebars', THEME_FX),
				'type' => 'sidebar',
				'class' => 'last'
			);

		/* ----------------------------------------------------------
		 * Social Profiles
		 * ---------------------------------------------------------- */
		 
		$options[] = array(
			'name' => __('Social Profiles', THEME_FX),
			'type' => 'heading',
			'icon' => 'social'
		);
		$options[] = array(
			'id'   => $prefix . 'facebook',
			'name' => __('Facebook', THEME_FX),
			'desc' => __('Paste your facebook profile url.', THEME_FX),
			'type' => 'text',
			'std'  => '',
			'class' => 'half odd'
		);
		$options[] = array(
			'id'   => $prefix . 'twitter',
			'name' => __('Twitter', THEME_FX),
			'desc' => __('Paste your twitter profile url.', THEME_FX),
			'type' => 'text',
			'std'  => '',
			'class' => 'half even'
		);
		$options[] = array(
			'id'   => $prefix . 'google-plus',
			'name' => __('Google+', THEME_FX),
			'desc' => __('Paste your google+ profile url.', THEME_FX),
			'type' => 'text',
			'std'  => '',
			'class' => 'half odd'
		);
		$options[] = array(
			'id'   => $prefix . 'linkedin',
			'name' => __('Linkedin', THEME_FX),
			'desc' => __('Paste your linkedin profile url.', THEME_FX),
			'type' => 'text',
			'std'  => '',
			'class' => 'half even'
		);
		$options[] = array(
			'id'   => $prefix . 'github',
			'name' => __('Github', THEME_FX),
			'desc' => __('Paste your github profile url.', THEME_FX),
			'type' => 'text',
			'std'  => '',
			'class' => 'half odd last'
		);
		$options[] = array(
			'id'   => $prefix . 'pinterest',
			'name' => __('Pinterest', THEME_FX),
			'desc' => __('Paste your pinterest profile url.', THEME_FX),
			'type' => 'text',
			'std'  => '',
			'class' => 'half even last'
		);

		return $options;
	
	}
	
/*	Custom Scripts
 *	------------------------------------------------------------------- */
 
	add_action('freshthemes_custom_scripts', 'fresh_panel_custom_script');
	
	function fresh_panel_custom_script(){
		?>
		<script type="text/javascript">
        jQuery(document).ready(function($) {

        
        });
        </script>
        <?php
	}