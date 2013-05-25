var FreshPanel = new function() {

	"use strict";


	/**
	 * Global Variables 
	 *
	 */
	var t = this;
	var $ = jQuery.noConflict();



	/**
	 * Open first tab
	 * 
	 * Open the first tab or last opened tab
	 * 
	 */
	t.openFirstTab = function() {
		var activetab = (typeof(localStorage) !== 'undefined' ) ? localStorage.getItem('activetab') : '';

		$('.fresh_panel_tab').hide();

		if (activetab !== '' && $(activetab).length ) {
			$(activetab + '.fresh_panel_tab').show();

			if( $(activetab + '_trigger').hasClass('icon') ) {
				var trigger = $(activetab + '_trigger'),
					submenu = $(activetab + '_trigger').parent(),
					toplevel = submenu.parent();

				submenu.show().addClass('open');
				toplevel.addClass('current open');
				trigger.addClass('active');
			}
			else {
				$(activetab + '_trigger').addClass('current').addClass('open');
			}
		} 
		else {
			$('.fresh_panel_tab:has(".fresh_panel_section"):first').show();

			if ( $('#fresh_panel_tab_nav ul li:first').hasClass('has_children') ) {
				var firsttoplevel = $('#fresh_panel_tab_nav ul li:first'),
					firstsubmenu = firsttoplevel.find('.submenu');

				firsttoplevel.addClass('current open');
				firstsubmenu.show().addClass('open');
				firstsubmenu.children('li:first').addClass('active');
			}
		}
	};



	/**
	 * Toggle Menu Tab
	 * 
	 * Reveal the sub menu tab when the parent menu clicked
	 * 
	 */
	t.toggleTab = function() {
		$('#fresh_panel_tab_nav li.has_children > a').click( function(e) {
			var clickedGroup = $(this).parent().find('.submenu li a:first').attr('href');

			$('#fresh_panel_tab_nav li.top_level').removeClass('open').removeClass('current');
			$('#fresh_panel_tab_nav li.active').removeClass('active');

			if ( $(this).parents('li').not('.current') ) {
				$('#fresh_panel_tab_nav li .submenu.open').removeClass('open').slideUp().parent().removeClass('current');
				$(this).parent().addClass('open').addClass('current').find('.submenu').slideDown().addClass('open').children('li:first').addClass('active');
			}

			if (clickedGroup !== '') {
				if (typeof(localStorage) !== 'undefined' ) {
					localStorage.setItem('activetab', clickedGroup);
				}
				
				$('.fresh_panel_tab').hide();
				$(clickedGroup).show();
			}

			e.preventDefault();
		});
	};



	/**
	 * Highlight Tab Menu
	 * 
	 * Add current classes to menu tab and open tab.
	 * 
	 */
	t.highlightTab = function() {
		$('#fresh_panel_tab_nav li.top_level').not('.has_children').find('a').click( function(e){
			var thisObj = $(this);
			var clickedGroup = thisObj.attr('href');
			
			if (clickedGroup !== '') {
				if (typeof(localStorage) !== 'undefined' ) {
					localStorage.setItem('activetab', clickedGroup);
				}
				
				$('#fresh_panel_tab_nav .open').removeClass('open');
				$('.submenu').slideUp();
				$('#fresh_panel_tab_nav .active').removeClass('active');
				$('#fresh_panel_tab_nav li.current').removeClass('current');
				thisObj.parent().addClass('current');
				
				$('.fresh_panel_tab').hide();
				$(clickedGroup).show();

				e.preventDefault();
			}
		});

		$('.submenu a').click( function(e) {
			var thisObj = $(this);
			var parentMenu = $(this).parents('li.top_level');
			var clickedGroup = thisObj.attr('href');
			
			if ( $('.submenu li a[href="' + clickedGroup + '"]').hasClass('active') ) {
				e.preventDefault();
			}
			
			if ( clickedGroup !== '' ) {
				if ( typeof(localStorage) !== 'undefined' ) {
					localStorage.setItem('activetab', clickedGroup);
				}
			
				parentMenu.addClass('open');
				$('.submenu li, .flyout_menu li').removeClass('active');
				$(this).parent().addClass('active');
				$('.fresh_panel_tab').hide();
				$(clickedGroup).show();
			}
			
			e.preventDefault();
		});
	};



	/**
	 * Flyout Menu
	 * 
	 * Create a fly out menu / wordpress admin bar menu look alike.
	 * 
	 */
	t.flyoutMenu = function() {
		$('#fresh_panel_tab_nav li.has_children').each( function() {
			$(this).hover( function () {
				if ( $(this).find('.flyout_menu').length === 0 ) {
					var flyoutContents = $(this).find('.submenu').html();
					var flyoutMenu = $('<div />').addClass('flyout_menu').html('<ul>' + flyoutContents + '</ul>');
					$(this).append(flyoutMenu);
				}
			});
		});

		$('.flyout_menu').hover( function() {
			$(this).parents('li').addClass('opensub');
		}, function() {
			$(this).parents('li').removeClass('opensub');
		});
		
		$('.flyout_menu a').live('click', function (e) {
			var parentMenu = $(this).parents('.top_level');
			var clickedGroup = $(this).attr('href');
			
			if (clickedGroup !== '') {
				if (typeof(localStorage) !== 'undefined' ) {
					localStorage.setItem('activetab', clickedGroup);
				}
				
				$('.fresh_panel_tab').hide();
				$(clickedGroup).show();
				$('#fresh_panel_tab_nav li').removeClass('open').removeClass('current').find('.submenu').slideUp().removeClass('open');
				parentMenu.addClass('open').addClass('current').find('.submenu').slideDown().addClass('open');
				$('#fresh_panel_tab_nav li.active').removeClass('active');
				$('#fresh_panel_tab_nav a[href="' + clickedGroup + '"]').parent().addClass('active');
			}
			
			e.preventDefault();
		});
	};



	/**
	 * Toggle Backup
	 * 
	 * Show/hide backup form
	 * 
	 */
	t.toggleBackup = function() {
		$('#backup_toggle').click( function(e){

			if( $(this).hasClass('open') ) {
				$(this).removeClass('open').text( freshframework_l10n.show_backup );
				$('#fresh_panel_import, #fresh_panel_export').hide();
				$('#fresh_panel_footer .button').removeAttr('disabled');
			}
			else {
				$(this).addClass('open').text( freshframework_l10n.hide_backup );
				$('#fresh_panel_import, #fresh_panel_export').show();
				$('#fresh_panel_footer .button').attr('disabled', 'disabled');
			}

			e.preventDefault();
		});
	};



	/**
	 * Sidebar Manager
	 * 
	 */
	t.sidebars = function() {
		$('.fresh_panel_section_sidebar').on('click', '.fresh_panel_add_sidebar', function(e) {

			var sidebarName = $(this).prev('.fresh_panel_sidebar_name'),
				sidebarBox = $(this).next('.fresh_panel_sidebars').find('ul'),
				defaultLi = sidebarBox.find('li.hidden');

			if ( $.trim(sidebarName.val()) === '' ) {
				alert('Please enter sidebar name!');
				e.preventDefault();
			}
			else {
				
				$(sidebarBox).append('<li><input type="hidden" name="'+ $(defaultLi).find('input').attr('id') +'[]" value="'+ sidebarName.val() +'" /><div class="sidebar_item">'+ sidebarName.val() +'</div><a href="#" class="button fresh_panel_remove_sidebar">'+ $(defaultLi).find('a').text() +'</a></li>');
				
				sidebarName.val('');

				e.preventDefault();
			}
			
		});

		$('.fresh_panel_section_sidebar').on('click', '.fresh_panel_remove_sidebar', function(e) {
			if(window.confirm( freshframework_l10n.confirm_delete )) {
				$(this).parent().remove();
			}

			e.preventDefault();
		});
	};


	/**
	 * Do the magic
	 *
	 */
	t.init =  function() {
		t.openFirstTab();
		t.toggleTab();
		t.highlightTab();
		t.flyoutMenu();
		t.toggleBackup();
		t.sidebars();

		/* Init multi upload */
		FreshFramework.multipleUploader();

		/* Init color picker */
		FreshFramework.colorSelect('.colorSelector', '.fresh_panel_color');
		
		/* Init toggle */
		FreshFramework.toggleSwitcher('label.toggle_on', 'label.toggle_off');

		/* Init image select */
		FreshFramework.imageSelector('.fresh_panel_img_img', '.fresh_panel_img_label', '.fresh_panel_img_radio');

		/* Init slider */
		FreshFramework.slider('.fresh_panel_slider', '.fresh_panel_slider_input', '.fresh_panel_slider_val');

		/* Init uploader */
		FreshFramework.mediaUploader('.fresh_panel_section_upload');

		/* Init background image uploader */
		FreshFramework.mediaUploader('.fresh_panel_section_background');

		/* Admin notices */
		$('.fresh_panel_msg').delay(2000).fadeOut();
	};

}


jQuery(document).ready( function() {
	FreshPanel.init();
});