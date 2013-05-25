(function($) {
	$(document).ready(function() {

		function freshframework_add_file(event, selector) {
		
			var upload = $(".uploaded-file"), frame;
			var $el = $(this);

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}

			// Create the media frame.
			frame = wp.media({
				// Set the title of the modal.
				title: freshframework_uploader_l10n.title,

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			frame.on('select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first();
				frame.close();
				selector.find('.upload').val(attachment.attributes.url);
				if ( attachment.attributes.type == 'image' ) {
					selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '"><a class="remove_image">Remove</a>').slideDown('fast');
				}
				selector.find('.upload_button').unbind().addClass('remove_file').removeClass('upload_button').val(freshframework_uploader_l10n.remove);
				selector.find('.background_properties').slideDown();
				freshframework_file_bindings();
			});

			// Finally, open the modal.
			frame.open();
		}
        
		function freshframework_remove_file(selector) {
			selector.find('.remove_image').hide();
			selector.find('.upload').val('');
			selector.find('.background_properties').hide();
			selector.find('.screenshot').slideUp();
			selector.find('.remove_file').unbind().addClass('upload_button').removeClass('remove_file').val(freshframework_uploader_l10n.upload);
			// We don't display the upload button if .upload-notice is present
			// This means the user doesn't have the WordPress 3.5 Media Library Support
			if ( $('.fresh_panel_section .upload-notice').length > 0 ) {
				$('.upload_button').remove();
			}
			freshframework_file_bindings();
		}
		
		function freshframework_file_bindings() {
			$('.remove_image, .remove_file').on('click', function() {
				freshframework_remove_file( $(this).parent().parent() );
	        });
	        
	        $('.upload_button').click( function( event ) {
	        	freshframework_add_file(event, $(this).parent().parent() );
	        });
        }
        
        freshframework_file_bindings();
    });
	
})(jQuery);