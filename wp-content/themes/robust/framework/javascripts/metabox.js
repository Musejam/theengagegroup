var FreshMetabox = new function() {

	"use strict";


	/**
	 * Global Variables 
	 *
	 */
	var t = this;
	var $ = jQuery.noConflict();



	/**
	 * Global Variables 
	 *
	 */
	t.postFormat = function(formats) {
		var group = $('#post-formats-select input');

		for(var i= 0; i < formats.length; i++){
			var box = formats[i][0],
				trigger = formats[i][1],
				format = trigger.replace('#post-format-', '');

			$(box).hide();

			if( $(trigger).is(':checked') ){
				$(box).show();
			}
		};

		group.change( function() {
			for(var i= 0; i < formats.length; i++){
				var box = formats[i][0],
					format = formats[i][1],
					format = format.replace('#post-format-', '');
				
				if ( $(this).val() == format ) {
					$(box).slideDown();
				} else {
					$(box).hide();
				}
			};
		});
	};



	/**
	 * Custom Script
	 *
	 */
	t.custom = function() {

		/* Hide/unhide slider options */
		FreshFramework.checkboxHideUnhide('#ft_enable_slider', '#fresh_metabox_ft_rev_slider');

		/* Hide/unhide page title options */
		FreshFramework.radioHideUnhide('#fresh_metabox_ft_page_title input', '#ft_page_title_on', '#fresh_metabox_ft_page_subtitle');

		/* Hide sidebar options if full width layout selected */
		if( $('#ft_page_layout_fullwidth').is(':checked') ) {
			$('#fresh_metabox_ft_page_sidebar, #fresh_metabox_ft_post_sidebar').hide();
		}

		$('#fresh_metabox_ft_page_layout .fresh_metabox_img_img').click( function() {

			if( $(this).attr('alt') === 'fullwidth' ){
				$('#fresh_metabox_ft_page_sidebar, #fresh_metabox_ft_post_sidebar').hide();
			}

			else {
				$('#fresh_metabox_ft_page_sidebar, #fresh_metabox_ft_post_sidebar').show();
			}

		});


		/* Portfolio type */
		var portolio_type_trigger = $('#ft_portfolio_type'),
			type_image = $('#fresh_metabox_ft_portfolio_images'),
			type_video = $('#fresh_metabox_ft_portfolio_video');

		type_image.hide();
		type_video.hide();

		if ( portolio_type_trigger.val() == 'video') {
			type_video.show();
		}
		else if( portolio_type_trigger.val() == 'image') {
			type_image.show();
		}

		portolio_type_trigger.change( function() {
			if ( portolio_type_trigger.val() == 'video') {
				type_video.show();
				type_image.hide();
			}
			else if( portolio_type_trigger.val() == 'image') {
				type_image.show();
				type_video.hide();
			}
		});

	};



	/**
	 * Do the magic
	 *
	 */
	t.init =  function() {

		var post_formats = [
			['#std_post_format_options','#post-format-0'],
			['#gallery_post_format_options','#post-format-gallery'],
			['#video_post_format_options','#post-format-video'],
			['#link_post_format_options','#post-format-link'],
			['#image_post_format_options','#post-format-image'],
			['#quote_post_format_options','#post-format-quote'],
			['#status_post_format_options','#post-format-status'],
			['#audio_post_format_options','#post-format-audio']
		];

		/* Init post format */
		t.postFormat(post_formats);

		/* Init custom script */
		t.custom();

		/* Init color picker */
		FreshFramework.colorSelect('.colorSelector', '.fresh_metabox_color');

		/* Init date picker */
		FreshFramework.datePicker('.fresh_metabox_date');

		/* Init toggle switcher */
		FreshFramework.toggleSwitcher('label.toggle_on', 'label.toggle_off');

		/* Init image select */
		FreshFramework.imageSelector('.fresh_metabox_img_img', '.fresh_metabox_img_label', '.fresh_metabox_img_radio');

		/* Init slider */
		FreshFramework.slider('.fresh_metabox_slider', '.fresh_metabox_slider_input', '.fresh_metabox_slider_val');

		/* Init uploader */
		FreshFramework.mediaUploader('.fresh_metabox_option_upload');

		/* Init background image uploader */
		FreshFramework.mediaUploader('.fresh_metabox_option_background');

		/* Init multi upload */
		FreshFramework.multipleUploader();

	};

}


jQuery(document).ready( function() {
	FreshMetabox.init();
});