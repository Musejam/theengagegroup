(function() {

	tinymce.create('tinymce.plugins.FreshShortcodes', {

		init: function(ed, url) {
			ed.addCommand('FreshShortcodesPopup', function(a, params) {
				var popup = params.identifier;
				tb_show( fresh_shortcodes_popup_title, freshthemes_theme_dir + 'framework/includes/popup.php?popup=' + popup + '&width=' + 800);
			});
		},
		createControl: function(btn, e) {
			if (btn == 'FreshShortcodesButton') {
				var a = this;

				// adds the tinymce button
				btn = e.createSplitButton('FreshShortcodesButton', {
					title: 'Insert Shortcode',
					image: freshthemes_theme_dir + 'framework/images/icons/shortcodes.png',
					icons: false
				});

				// adds the dropdown to the button
				btn.onRenderMenu.add(function(c, b) {
					b.add({title : 'Fresh Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					a.addWithPopup( b, 'Accordion', 'accordion' );
					a.addWithPopup( b, 'Alert', 'alert' );
					a.addWithPopup( b, 'Button', 'button' );
					a.addWithPopup( b, 'Call Out', 'callout' );
					a.addWithPopup( b, 'Client Box', 'client_box' );
					a.addWithPopup( b, 'Columns', 'columns' );
					a.addWithPopup( b, 'Content Box', 'content_box' );
					a.addWithPopup( b, 'Divider', 'divider' );
					a.addWithPopup( b, 'Dropcap', 'dropcap' );
					a.addWithPopup( b, 'Entries', 'entries' );
					a.addWithPopup( b, 'Heading', 'heading' );
					a.addWithPopup( b, 'Icon', 'icon' );
					a.addWithPopup( b, 'Intro', 'intro' );
					a.addWithPopup( b, 'Lead Paragraph', 'leadp' );
					a.addWithPopup( b, 'List Icons', 'list_icons' );
					a.addWithPopup( b, 'Map', 'gmap' );
					a.addWithPopup( b, 'Portfolio', 'portfolio' );
					a.addWithPopup( b, 'Pricing', 'pricing' );
					a.addWithPopup( b, 'Profile', 'profile' );
					a.addWithPopup( b, 'Social Links', 'social_links' );
					a.addWithPopup( b, 'Tabs', 'tabs' );
					a.addWithPopup( b, 'Teaser', 'teaser' );
					a.addWithPopup( b, 'Testimonial', 'testimonial' );
					a.addWithPopup( b, 'Video', 'video' );
				});

				return btn;
			}
  
			return null;
		},

		addWithPopup: function(ed, title, id) {
			ed.add({
				title: title,
				onclick: function() {
					tinyMCE.activeEditor.execCommand('FreshShortcodesPopup', false, {
						title: title,
						identifier: id
					});
				}
			});
		},

		addImmediate: function(ed, title, sc) {
			ed.add({
				title: title,
				onclick: function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, sc);
				}
			});
		},

		getInfo: function() {
			return {
				longname: 'Fresh Shortcodes',
				author: 'Rifki A.G',
				authorurl: 'http://themeforest.net/user/rifki/',
				infourl: 'http://wiki.moxiecode.com/',
				version: '1.0'
			};
		}

	});
	
	tinymce.PluginManager.add('FreshShortcodes', tinymce.plugins.FreshShortcodes);

})();