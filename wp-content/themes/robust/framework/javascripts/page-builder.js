var FreshBuilder = new function() {

	"use strict";


	/**
	 * Global Variables 
	 *
	 */
	var t = this;
	var $ = jQuery.noConflict();



	/**
	 * Add Module
	 *
	 */
	t.addModule = function() {

		/* On click add module button */
		$('#add_module').click( function(e) {
			$.post(
				ajaxurl, 
				{
					'action': 'freshbuilder_print_module',
					'module': $('#freshbuilder_modules select').val()
				}, 
				function(data) {

					/* Append module to placeholder */
					$('#freshbuilder_placeholder').append(data);

					/* Save data */
					t.saveData();
				}
			);

			e.preventDefault();
		});

	};



	/**
	 * Remove Module
	 *
	 */
	t.removeModule = function() {
		$('#freshbuilder').on('click', 'span.remove_module', function() {
			
			var parent = $(this).closest('.module'),
				message = freshbuilder_l10n.remove + ' <strong>' + parent.find('.module_name').text() + '</strong>?';

			/* Confirm remove */
			t.confirmDialog(message, function(){

				/* Remove module */
				parent.remove();

				/* Save data */
				t.saveData();

			}, function() {
				return false;
			});

		});
	};



	/**
	 * Change Module Size
	 *
	 */
	t.changeModuleSize = function() {
		var moduleSizes = [
				['1/5','module_one_fifth','one_fifth'],
				['1/4','module_one_fourth','one_fourth'],
				['1/3','module_one_third','one_third'],
				['2/5','module_two_fifth','two_fifth'],
				['1/2','module_one_half','one_half'],
				['3/5','module_three_fifth','three_fifth'],
				['2/3','module_two_third','two_third'],
				['3/4','module_three_fourth','three_fourth'],
				['4/5','module_four_fifth','four_fifth'],
				['1/1','module_one_full','one_full']
			];

		/* On click increase button */
		$('#freshbuilder').on('click', 'span.increase_module', function(){
			var module = $(this).parent('.module');
			var is_upper_size = false;
			var current_size = '';

			for(var i=0; i < moduleSizes.length - 1; i++){
				if(module.hasClass(moduleSizes[i][1])){ 
					is_upper_size = true; 
					current_size = moduleSizes[i][1];
				}
				if( is_upper_size ){
					if( i < moduleSizes.length-2 ){
						module.removeClass(current_size).addClass(moduleSizes[i+1][1]);
						module.find('.module_size').html('( '+ moduleSizes[i+1][0] +' )');
						module.attr('data-size', moduleSizes[i+1][2]);
					}
					else if( i === moduleSizes.length-2){
						module.removeClass(current_size).addClass(moduleSizes[i+1][1]);
						module.find('.module_size').html('( '+ moduleSizes[i+1][0] +' )');
						module.attr('data-size', moduleSizes[i+1][2]);
					}
					break;
				}
			}
			
			t.saveData();
		});

		/* On click decrease button */
		$('#freshbuilder').on('click', 'span.decrease_module', function(){
			var module = $(this).parent('.module');
			var is_lower_size = false;
			var current_size = '';

			for( var i = moduleSizes.length - 1; i > 0; i--){
				if( module.hasClass(moduleSizes[i][1]) ){ 
					is_lower_size = true; 
					current_size = moduleSizes[i][1];
				}
				if( is_lower_size ){
					if( i > 1 ){
						module.removeClass(current_size).addClass(moduleSizes[i-1][1]);
						module.find('.module_size').html('( '+ moduleSizes[i-1][0] +' )');
						module.attr('data-size', moduleSizes[i-1][2]);
					}
					else if( i === 1){
						module.removeClass(current_size).addClass(moduleSizes[i-1][1]);
						module.find('.module_size').html('( '+ moduleSizes[i-1][0] +' )');
						module.attr('data-size', moduleSizes[i-1][2]);
					}
					break;
				}
			}
			
			t.saveData();
		});
	};



	/**
	 * Open Lightbox
	 *
	 */
	t.openLightbox = function() {

		$('#freshbuilder').on('click', 'span.edit_module', function(){
			
			var editor = $('#freshbuilder_editor_wrapper'),
				lightbox = $('#freshbuilder_lightbox'),
				module = $(this).closest('.module'),
				settings = module.find('.data_settings'),
				json = [], json_params = {}, i = 0;


			/* Hide editor and show it immediately */
			editor.hide(function(){
				$(this).css('position','absolute');
				$('#freshbuilder .inside').addClass('overflow_hidden');
				$(this).show();
			});

			/* Show loader */
			lightbox.find('.loader').show();

			/* Show lightbox */
			lightbox.fadeIn(300);

			/* Setting up module option */
			settings.children().each( function(){
				json_params[$(this).attr('data-option')] = $(this).html();
			});

			/* Setting up module child option */
			if( module.hasClass('has_child') ){
				var json_child_params = {};

				json_params['childs'] = json_child_params;

				module.find('.child_data_settings .child_data_setting').each( function() {
					var child = {};
					i++;

					json_child_params['child_' + i] = child;

					$(this).children().each( function() {
						child[$(this).attr('data-option')] = $(this).html();
					});

					if ( $(this).hasClass('is_default')){
						child['class'] = 'default';
					}
				});
			}

			json.push(json_params);

			/* Ajax */
			$.post(
				ajaxurl, 
				{
					'action': 'freshbuilder_show_module_options',
					'id': module.attr('id'),
					'module': module.attr('data-module'),
					'settings': $.toJSON(json)
				}, 
				function(data) {
					lightbox.find('.loader').fadeOut(600, function() {
						lightbox.find('#freshbuilder_lightbox_inner').append(data);
						$('html:not(:animated),body:not(:animated)').animate({ 
							scrollTop: $('#freshbuilder').offset().top 
						}, 600);
					});

					t.saveData();
				}
			);

		});

		t.child();
		t.closeLightbox();

	};



	/**
	 * Close Lightbox
	 *
	 */
	t.closeLightbox = function() {

		$('#freshbuilder_lightbox').on('click', '.close_lightbox', function(e){
			var target = $(this).parent().attr('data-target'),
				data = '', 
				data_child = '';

			$('#freshbuilder_lightbox').find('.module_setting .freshbuilder_input').each( function() {
				var moduleClass = ( $(this).hasClass('is_content') ) ? ' class="is_content"' : '';

				data += '<div data-option="' + $(this).attr('name').replace('freshbuilder_input_','') + '"'+ moduleClass +'>';
						
				if( $(this).is(':checkbox') ) {
					var val = ( $(this).is(':checked') ) ? '1' : '0';
					data += val;
				} 
				else {
					data += $(this).val();
				}

				data += '</div>';
			});

			$(target).find('.data_settings').empty();
			$(target).find('.data_settings').append(data);

			if ( $(target).hasClass('has_child') ) {
				$('#freshbuilder_lightbox').find('.child_module_setting_list li').each( function() {
					var $this = $(this),
						$class = ( $this.hasClass('default') ) ? ' is_default' : '';

					data_child += '<div class="child_data_setting' + $class + '">';
					
					$this.find('.freshbuilder_child_input').each( function() {
						$class = ( $(this).hasClass('is_content') ) ? ' class="is_content"' : '';
						data_child += '<div data-option="' + $(this).attr('name').replace('freshbuilder_input_','') + '"'+ $class +'>';
						
						if( $(this).is(':checkbox') ) {
							var val = ( $(this).is(':checked') ) ? '1' : '0';
							data_child += val;
						} 
						else {
							data_child += $(this).val();
						}

						data_child += '</div>';
					});

					data_child += '</div>';
				});

				$(target).find('.child_data_settings').empty();
				$(target).find('.child_data_settings').append(data_child);
			}

			$('#freshbuilder_lightbox').find('.module_setting').remove();

			$('#freshbuilder_editor_wrapper').hide(0, function(){
				$(this).css('position','relative');

				$('#freshbuilder .inside').removeClass('overflow_hidden');
				
				$('#freshbuilder_lightbox').hide();
				
				$('html:not(:animated),body:not(:animated)').animate({ 
					scrollTop: $('#freshbuilder').offset().top 
				}, 10);

				$(this).show();
			});

			t.saveData();
			e.preventDefault();
		});

	};



	/**
	 * Child Settings
	 *
	 */
	t.child = function() {

		var wrapper = $('#freshbuilder');

		wrapper.on('click', '.clone_child_module_setting', function(e){
			var $this = $(this),
				$target = $this.parent().find('ul.child_module_setting_list'),
				$clone = $target.find('li.default').clone();

			$clone.removeAttr('class').appendTo( $target );
			
			t.changeInputValue();
			e.preventDefault();
		});

		wrapper.on('click', '.remove_child', function(e){
			var $this = $(this),
				$parent = $this.closest('li');

			t.confirmDialog(freshbuilder_l10n.confirm, function(){
				$parent.remove();
				t.saveData();
			}, function() {
				return;
			});

			e.preventDefault();
		});

	};



	/**
	 * Confirm Dialog
	 *
	 */
	t.confirmDialog = function(msg, yes, no) {
		var html = '<div id="freshbuilder_confirm_box"><div id="freshbuilder_confirm"><div class="message"></div><span class="yes">'+ freshbuilder_l10n.yes +'</span><span class="no">'+ freshbuilder_l10n.no +'</div></div></div>';

		$('#freshbuilder').find('.inside').append(html);

		var box = $('#freshbuilder_confirm_box'),
			inner = box.find('#freshbuilder_confirm');

		box.find('.message').html(msg);

		box.find('.yes, .no').unbind().click( function(){
			box.remove();
			$('html:not(:animated),body:not(:animated)').animate({ 
				scrollTop: $('#freshbuilder').offset().top
			}, 600);
		});

		box.find('.yes').click(yes);
		box.find('.no').click(no);
		box.fadeIn();

		inner.css({
			marginTop: inner.outerHeight() /2 * -1,
			marginLeft: inner.outerWidth() /2 * -1
		});

		box.find('> div').fadeIn();

		$('html:not(:animated),body:not(:animated)').animate({ 
			scrollTop: $('#freshbuilder_confirm').offset().top - inner.outerHeight()
		}, 600);
	};



	/**
	 * Init UI
	 *
	 */
	t.initUI = function() {

		var lightbox_width = $('#freshbuilder').width(),
			lightbox_inner_width = $('#freshbuilder_lightbox_inner').width() + 16;

		$('#freshbuilder_placeholder').sortable({
			forcePlaceholderSize: true,
			placeholder: 'module_placeholder',
			cursor: 'move',
			distance: 2,
			start: function(event, ui) {
				ui.placeholder.text( ui.item.find('.module_name').text() );
				ui.placeholder.css({
					width: ui.item.outerWidth() - '0.5',
					lineHeight: ui.item.outerHeight() + 'px',
					padding: 0
				});
			},
			stop: function(event, ui) {
				t.saveData();
			}
		});

		var pos = lightbox_width - lightbox_inner_width;

		$('#freshbuilder_lightbox_inner').css({
			marginLeft: pos / 2,
			marginRight: pos / 2
		});

	};



	/**
	 * Generate HMTL
	 *
	 */
	t.generateHTML = function(html) {

		var output = '';

		html.find('.module').each( function(){
			var $this = $(this),
				$class = 'module module_'+ $this.attr('data-module') +' module_'+ $this.attr('data-size');

			if ( $this.hasClass('has_child')) {
				$class = $class + ' has_child';
			}

			output += '<div id="'+ $this.attr('id') +'" class="'+ $class +'" data-module="'+ $this.attr('data-module') +'" data-size="'+ $this.attr('data-size') +'">';
			output += '<span class="module_name">'+ $this.find('.module_name').text() +'</span>';
			output += '<span class="module_size">'+ $this.find('.module_size').text() +'</span>';
			output += '<span class="increase_module" title="'+ $this.find('.increase_module').attr('title') +'">e</span>';
			output += '<span class="decrease_module" title="'+ $this.find('.decrease_module').attr('title') +'">x</span>';
			output += '<span class="edit_module" title="'+ $this.find('.edit_module').attr('title') +'">e</span>';
			output += '<span class="remove_module" title="'+ $this.find('.remove_module').attr('title') +'">x</span>';
			output += '<div class="data_settings hidden">';
			output += $this.find('.data_settings').html();
			output += '</div>';
			if ( $this.hasClass('has_child')) {
			output += '<div class="child_data_settings hidden" data-code="'+ $this.find('.child_data_settings').attr('data-code') +'">';
				output += $this.find('.child_data_settings').html();
			output += '</div>';
			}
			output += '</div>';

		});

		return t.htmlEncode(output);
	};



	/**
	 * Generate Shortcode
	 *
	 */
	t.generateShortcode = function(html) {

		var output = '';

		html.find('.module').each( function(){
			var $this = $(this),
				module = $this.attr('data-module'),
				module_size = $this.attr('data-size'),
				module_content = '';

			if( $this.hasClass('module_column') ) {
				output += '[' + module_size + ']';
				$this.find('.data_settings div').each( function(){
					if( $(this).hasClass('is_content') ) {
						module_content = $(this).html();
					}
				});
				output += module_content + '[/' + module_size + ']' + '\n';
			} 
			else if ( $this.hasClass('has_child') ) {
				var $children = $this.find('.child_data_settings'),
					children_code = $children.attr('data-code');

				output += '[' + module_size + ']' + '\n';
				output += '[' + module;
				$this.find('.data_settings div').each( function(){
					if( $(this).hasClass('is_content') ) {
						module_content = $(this).html();
					} 
					else {
						output += ' ' + $(this).attr('data-option') + '="' + $(this).html() + '"';
					}
				});
				if ((output.charAt(output.length-1) !== ']')) {
					output += ']' + '\n';
				}
				$children.find('.child_data_setting').not('.is_default').each( function() {
					var $child = $(this);

					output += '[' + children_code;
					$child.find('div').each( function(){
						if( $(this).hasClass('is_content') ) {
							module_content = $(this).html();
						} 
						else {
							output += ' ' + $(this).attr('data-option') + '="' + $(this).html() + '"';
						}
					});
					if ((output.charAt(output.length-1) !== ']')) {
						output += ']' + '\n';
					}
					output += module_content + '[/' + children_code + ']' + '\n';
				});
				output += '[/' + module + ']' + '\n';
				output += '[/' + module_size + ']' + '\n';
			}
			else {
				output += '[' + module_size + ']' + '\n';
				output += '[' + module;
				$this.find('.data_settings div').each( function(){
					if( $(this).hasClass('is_content') ) {
						module_content = $(this).html();
					} 
					else {
						output += ' ' + $(this).attr('data-option') + '="' + $(this).html() + '"';
					}
				});
				if ((output.charAt(output.length-1) !== ']')) {
					output += ']' + '\n';
				}
				output += module_content + '[/' + module + ']' + '\n';
				output += '[/' + module_size + ']' + '\n';
			}
		});

		return output;

	};



	/**
	 * Save Data
	 *
	 */
	t.saveData = function() {

		var html_editor =  t.generateHTML( $('#freshbuilder_placeholder') ),
			shortcode = t.generateShortcode( $('#freshbuilder_placeholder') );

		$('#freshbuilder').bind('freshbuilder_data', function() {
			$('#freshbuilder').find('#freshbuilder_data_shortcode').val( shortcode );
			$('#freshbuilder').find('#freshbuilder_data_html').val( html_editor );
		}).trigger('freshbuilder_data');

	};



	/**
	 * Init UI
	 *
	 */
	t.initModule = function() {

		t.addModule();
		t.removeModule();
		t.changeModuleSize();
		t.openLightbox();
		t.changeInputValue();

	};



	/**
	 * HTML Encode
	 *
	 */
	t.htmlEncode = function(html) {
		return $('<div/>').text(html).html();
	};



	/**
	 * Change Input Value
	 *
	 */
	t.changeInputValue = function() {
		var wrapper = $('#freshbuilder');

		$('.freshbuilder_input, .freshbuilder_child_input', wrapper).change().trigger('freshbuilder_data');
	};



	/**
	 * Init
	 *
	 */
	t.init = function() {
		t.initUI();
		t.initModule();
	};


}();

jQuery(document).ready(function(){
	FreshBuilder.init();
});

jQuery(window).resize(function(){
	FreshBuilder.initUI();
});