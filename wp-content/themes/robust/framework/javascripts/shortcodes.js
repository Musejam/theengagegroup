(function($) {
	
	var freshShortcodes = {
		
		generate: function() {
			
			var output = $('#_fresh_shortcodes_output').text(),
				newoutput = output;
				
			$('.fresh-shortcodes-input').each(function() {
				var input = $(this),
					theid = input.attr('id'),
					id = theid.replace('fresh_shortcode_', ''), 
					re = new RegExp('{{'+id+'}}', 'g');
					
				if( input.is(':checkbox') ) {
					var val = ( $(this).is(':checked') ) ? '1' : '0';
					newoutput = newoutput.replace(re, val);
				} 
				else {
					newoutput = newoutput.replace(re, input.val());
				}
			});
			
			$('#_fresh_shortcodes_newoutput').remove();
			$('#fresh-shortcodes-form-table').prepend('<div id="_fresh_shortcodes_newoutput" class="hidden">' + newoutput + '</div>');
			
			freshShortcodes.updatePreview();
			
		},
		
		generateChild : function() {
			
			var output = $('#_fresh_shortcodes_child_output').text(),
				parent_output = '',
				outputs = '';
				
			$('.child-clone-row').each(function() {
				
				var row = $(this),
					row_output = output;
				
				$('.fresh-shortcodes-child-input', this).each(function() {
					var input = $(this),
						theid = input.attr('id'),
						id = theid.replace('fresh_shortcode_', ''), 
						re = new RegExp('{{'+id+'}}', 'g');
					
					if( input.is(':checkbox') ) {
						var val = ( $(this).is(':checked') ) ? '1' : '0';
						row_output = row_output.replace(re, val);
					} 
					else {
						row_output = row_output.replace(re, input.val());
					}
				});
				
				outputs = outputs + row_output + "\n";
			});
			
			$('#_fresh_shortcodes_child_newoutput').remove();
			$('.child-clone-rows').prepend('<div id="_fresh_shortcodes_child_newoutput" class="hidden">' + outputs + '</div>');
			
			this.generate();
			parent_output = $('#_fresh_shortcodes_newoutput').text().replace('{{child}}', outputs);
			
			$('#_fresh_shortcodes_newoutput').remove();
			$('#fresh-shortcodes-form-table').prepend('<div id="_fresh_shortcodes_newoutput" class="hidden">' + parent_output + '</div>');
			
			freshShortcodes.updatePreview();
			
		},
		
		children : function() {
			
			$('.child-clone-rows').appendo({
				subSelect: '> div.child-clone-row:last-child',
				allowDelete: false,
				focusFirst: false
			});
			
			$('.child-clone-row-remove').live('click', function() {
				var	btn = $(this),
				row = btn.parent();
				
				if( $('.child-clone-row').size() > 1 ){
					row.remove();
				}
				else {
					alert('You need a minimum of one row');
				}
				return false;
			});
			
			$('.child-clone-rows').sortable({
				placeholder: 'sortable-placeholder',
				items: '.child-clone-row'
			});
			
		},
		
		updatePreview : function() {
			
			if( $('#fresh-shortcodes-preview').size() > 0 ) {
				
				var	shortcode = $('#_fresh_shortcodes_newoutput').html(),
					iframe = $('#fresh-shortcodes-preview'),
					theiframeSrc = iframe.attr('src'),
					thesiframeSrc = theiframeSrc.split('preview.php'),
					iframeSrc = thesiframeSrc[0] + 'preview.php';
				
				// updates the src value
				iframe.attr( 'src', iframeSrc + '?sc=' + freshShortcodes.htmlEncode(shortcode) );
				
				// update the height
				$('#fresh-shortcodes-preview').height( $('#fresh-shortcodes-popup').outerHeight()-42 );
				
			}
			
		},
		
		resizeTB : function() {
			
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				freshthemesPopup = $('#fresh-shortcodes-popup'),
				no_preview = ($('#_fresh_shortcodes_preview').text() == 'false') ? true : false;
				
			if( no_preview ) {
				ajaxCont.css({
					paddingTop: 0,
					paddingLeft: 0,
					height: (tbWindow.outerHeight()-47),
					overflow: 'scroll',
					width: 562
				});
			
				tbWindow.css({
					width: ajaxCont.outerWidth(),
					marginLeft: -(ajaxCont.outerWidth()/2)
				});
			
				$('#fresh-shortcodes-popup').addClass('no_preview');
			} 
			
			else {
				ajaxCont.css({
					padding: 0,
					// height: (tbWindow.outerHeight()-47),
					height: freshthemesPopup.outerHeight()-15,
					overflow: 'hidden' // IMPORTANT
				});
				
				tbWindow.css({
					width: ajaxCont.outerWidth(),
					height: (ajaxCont.outerHeight() + 30),
					marginLeft: -(ajaxCont.outerWidth()/2),
					marginTop: -((ajaxCont.outerHeight() + 47)/2),
					top: '50%'
				});
			}
			
		},
		
		load : function() {
			
			var	freshShortcodes = this,
				popup = $('#fresh-shortcodes-popup'),
				form = $('#fresh-shortcodes-form', popup),
				output = $('#_fresh_shortcodes_output', form).text(),
				popupType = $('#_fresh_shortcodes_popup', form).text(),
				newoutput = '';
				
			freshShortcodes.resizeTB();
			$(window).resize(function() {
				freshShortcodes.resizeTB();
			});
			
			freshShortcodes.generate();
			freshShortcodes.children();
			freshShortcodes.generateChild();
			
			$('.fresh-shortcodes-child-input', form).live('change', function() {
				freshShortcodes.generateChild();
			});
			
			$('.fresh-shortcodes-input', form).change(function() {
				freshShortcodes.generate();
			});
			
			$('.fresh-shortcodes-insert', form).click(function() {    		 			
				if(window.tinyMCE) {
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_fresh_shortcodes_newoutput', form).html());
					tb_remove();
				}
			});
		},

		htmlEncode: function(html) {
			return $('<div/>').text(html).html();
		}
		
	};
	
	$(document).ready( function() {
		$('#fresh-shortcodes-popup').livequery( function() { 
			freshShortcodes.load();
		});
	});
	
})(jQuery);