var FreshFramework = new function() {

	"use strict";

	/**
	 * Global Variables 
	 *
	 */
	var t = this;
	var $ = jQuery.noConflict();



	/**
	 * Color Picker
	 * 
	 * @param "selector"
	 * @param "target"
	 */
	t.colorSelect = function(selector, target) {
		$(selector).each(function(){
			var Othis = this;
			var initialColor = $(Othis).next(target).val();

			$(Othis).ColorPicker({
				color: initialColor,
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex) {
					$(Othis).children('div').css('backgroundColor', '#' + hex);
					$(Othis).next(target).attr('value', '#' + hex);
				}
			});
		});
	};



	/**
	 * Date Picker
	 * 
	 * @param "selector"
	 */
	t.datePicker = function(selector) {
		var format = $(selector).attr('rel');

		$(selector).datepicker( {
			dateFormat: format
		});
	};



	/**
	 * Toggle Switcher
	 * 
	 * @param "on"
	 * @param "off"
	 */
	t.toggleSwitcher = function(on, off) {
		$(on).click(function(){
			var $this = $(this),
				parent = $this.parent();

			if( !$this.hasClass('selected') ){
				$this.addClass('selected');
				$(off, parent).removeClass('selected');
			} 
		});

		$(off).click(function(){
			var $this = $(this),
				parent = $this.parent();

			if( !$this.hasClass('selected') ){
				$this.addClass('selected');
				$(on, parent).removeClass('selected');
			} 
		});
	};



	/**
	 * Image Selector
	 * 
	 * @param "img"
	 * @param "radio"
	 * @param "label"
	 */
	t.imageSelector = function(img, radio, label) {
		$(img).click(function(){
			$(this).parent().find(img).removeClass('selected');
			$(this).addClass('selected');		
		});
			
		$(label).hide();
		$(img).show();
		$(radio).hide();
	};



	/**
	 * UI Slider
	 * 
	 * @param "selector"
	 * @param "input"
	 * @param "val"
	 */
	t.slider = function(selector, input, val) {
		$(selector).slider({
			animate: true,
			range: 'min',
			value: $(input).val(),
			min: 0,
			max: 99,
			step: 1,

			slide: function( event, ui ) {
				$(this).next(val).find('span').text(ui.value);
				$(this).prev(input).val(ui.value);
			},

			change: function(event, ui) {
				$(this).next(val).find('span').text(ui.value);
				$(this).prev(input).val( ui.value);
			}
		});
	};



	/**
	 * Chechkbox Hide / Unhide
	 * 
	 * @param "trigger"
	 * @param "options"
	 */
	t.checkboxHideUnhide = function(trigger, options) {

		if ( !$(trigger).is(':checked') ) {
			$(options).hide();
		}

		$(trigger).change( function() {
			if( $(this).is(':checked') ){
				$(options).show();
			}
			else {
				$(options).hide();
			}
		});
		
	};



	/**
	 * Radio Hide / Unhide
	 * 
	 * @param "trigger_group"
	 * @param "trigger"
	 * @param "options"
	 */
	t.radioHideUnhide = function(trigger_group, trigger, options) {

		if ( !$(trigger).is(':checked') ) {
			$(options).hide();
		}

		$(trigger_group).change( function() {
			if ( $(this).val() === 'on' ) {
				$(options).show();
			}
			else {
				$(options).hide();
			}
		}); 
		
	};



	/**
	 * New Media Uploader
	 * 
	 * @param "selector"
	 * @param "multiple"
	 */
	var newMediaUploader = function(selector, multiple) {

		/* Media library params */
		var frame = wp.media({
			title : freshframework_l10n.upload_title,
			button : { 
				text: 'Insert'
			}
		});

		/* On select even */
		frame.on('select', function(){

			var attachment = frame.state().get('selection').first();

			/* If is not multiple uploader */
			if( !multiple ) {

				var screenshot = $(selector).find('.screenshot'),
					btn = $(selector).find('.upload_button'),
					bgProperties = $(selector).find('.background_properties');

				/* Send attachment url to uploader text input */
				$(selector).find('.upload').val( attachment.attributes.url );	

				/* If attachment type = image */
				if ( attachment.attributes.type === 'image' ) {

					/* Show image screenshot */
					if( screenshot ) {
						screenshot.empty().hide().append('<img src="' + attachment.attributes.url + '">').slideDown('fast');
					}

					/* Show background properties */
					if( bgProperties ) {
						bgProperties.slideDown();
					}
				}

				/* Button */
				if( btn ) {
					btn.unbind().addClass('remove_file').removeClass('upload_button').val(freshframework_l10n.remove);
				}

			}

			/* Is multiple uploader */
			else {

				/* Define default item */
				var li = $(selector).find('li.hidden');

				/* Multiple uploader only allows image */
				if ( attachment.attributes.type === 'image' ) {
					$(selector).append(
						'<li>' +
						'<input type="hidden" id="' + li.find('input').attr('data-id') +'" name="' + li.find('input').attr('data-name') +'" value="' + attachment.attributes.id + '" />' +
						'<img src="' + attachment.attributes.sizes.thumbnail.url + '" alt="" />' +
						'<a class="remove_image">'+ freshframework_l10n.remove +'</a>' +
						'</li>'
					);
				}

				/* Show alert notification if user inserting non-image file */
				else {
					alert( freshframework_l10n.upload_alert );
				}
			}
		});
		
		/* Open Media Uploader */
		frame.open();

	};



	/**
	 * Old Media Uploader
	 * 
	 * @param "selector"
	 * @param "multiple"
	 */
	var oldMediaUploader = function(selector, multiple){

		/* Media uploader params */
		var post_id = $('#post_ID').val();

		if ( !post_id || post_id === undefined || post_id === '' ){
			var post_id = '0';
		}

		var params = 'type=image&amp;post_id=' + post_id + '&amp;TB_iframe=true';

		console.log(params);

		/* Open media uploader */
		tb_show( freshframework_l10n.upload_title, 'media-upload.php?' + params);

		/* Send callback when insert button clicked */
		window.send_to_editor = function(html) {

			/* Remove media uploader */
			tb_remove();

			/* File params */
			var file = $(html).attr('href');
			if(!file || file === undefined || file === '') {
				var file = $('img', html).attr('src');
			}

			/* Image checker */
			var is_image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;

			/* If is not multiple uploader */
			if( !multiple ) {

				var screenshot = $(selector).find('.screenshot'),
					btn = $(selector).find('.upload_button'),
					bgProperties = $(selector).find('.background_properties');

				/* Send attachment url to uploader text input */
				$(selector).find('.upload').val(file);
				

				/* If attachment is an image */
				if(file.match(is_image)) {
					
					/* Show image screenshot */
					if( screenshot ) {
						screenshot.empty().hide().append('<img src="' + file + '">').slideDown('fast');
					}

					/* Show background properties */
					if(bgProperties) {
						bgProperties.slideDown();
					}
				}

				/* Button */
				if(btn) {
					btn.unbind().addClass('remove_file').removeClass('upload_button').val( freshframework_l10n.remove );
				}

			}

			/* Is multiple uploader */
			else {

				/* If attachment is an image */
				if(file.match(is_image)) {
					
					/* File params */
					var htmlClass = $(html).attr('class');
					if(!htmlClass || htmlClass === undefined || htmlClass === "") {
						var htmlClass = $('img', html).attr('class');
					}

					var htmlArr = htmlClass.split(' '),
						attID = htmlArr[2].replace('wp-image-', ''),
						li = $(selector).find('li.hidden');

					/* Append new item */
					$(selector).append(
						'<li>' +
						'<input type="hidden" id="' + li.find('input').attr('data-id') +'" name="' + li.find('input').attr('data-name') +'" value="' + attID + '" />' +
						'<img src="' + file + '" alt="" />' +
						'<a class="remove_image">'+ freshframework_l10n.remove +'</a>' +
						'</li>'
					);
				}

				/* Show alert notification if user inserting non-image file */
				else{
					alert( freshframework_l10n.upload_alert );
				}

			}

		};
	};



	/**
	 * Media Uploader
	 * 
	 * @param "selector"
	 */
	t.mediaUploader = function(selector) {
		

		/* On click upload button */
		$(selector).on('click', '.upload_button', function(e) {

			if( typeof wp !== 'undefined' && typeof wp.media !== 'undefined' ) {
				newMediaUploader($(this).parents(selector), false);
			}
			else {
				oldMediaUploader($(this).parents(selector), false);
			}

			e.preventDefault();
		});


		/* On click remove button */
		$(selector).on('click', '.remove_image, .remove_file',  function() {
			$(this).parents(selector).find('.remove_image').hide();
			$(this).parents(selector).find('.upload').val('');
			$(this).parents(selector).find('.background_properties').hide();
			$(this).parents(selector).find('.screenshot').slideUp();
			$(this).parents(selector).find('.remove_file').unbind().addClass('upload_button').removeClass('remove_file').val( freshframework_l10n.upload );
        });
	};



	/**
	 * Multiple Image Uploader
	 * 
	 */
	t.multipleUploader = function() {
		var addBtn = $('.add_row'),
			selector = addBtn.prev('ul.multi_upload');


		/* On click add new image */
		$(addBtn).click( function(e) {
			if( typeof wp !== 'undefined' && typeof wp.media !== 'undefined' ) {
				newMediaUploader(selector, true);
			}
			else {
				oldMediaUploader(selector, true);
			}

			e.preventDefault();
		});


		/* On click remove button */
		$(selector).on('click', '.remove_image', function() {
			if(window.confirm( freshframework_l10n.confirm_delete )) {
				$(this).parent().remove();
			}
		});
	};

}();