(function($,sr){
	"use strict";
	// debouncing function from John Hann
	// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	var debounce = function (func, threshold, execAsap) {
		var timeout;

		return function debounced () {
			var obj = this, args = arguments;
			function delayed () {
				if (!execAsap) {
					func.apply(obj, args);
				}
				timeout = null; 
			}

			if (timeout) {
				clearTimeout(timeout);
			}
			else if (execAsap) {
				func.apply(obj, args);
			}

			timeout = setTimeout(delayed, threshold || 100); 
		};
	};

	jQuery.fn[sr] = function(fn){
		return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); 
	};
})(jQuery,'smartresize');

( function($) {
	"use strict";
	
	var themeScript = {

		/* FlexSlider init */
		initFlexSlider: function(){
			$('.flexslider').imagesLoaded( function() {
				$(this).flexslider({
					controlNav: false,
					directionNav: true,
					prevText: '<span class="icon-chevron-left"></span>',
					nextText: '<span class="icon-chevron-right"></span>'
				});
			});
		},

		/* Superfish menu init */
		initSuperfish: function() {
			var header_wrapper = $('#header-wrapper'),
				menu = $('.sf-menu', header_wrapper);

			menu.superfish({
                autoArrows: false,
                dropShadows: false,
				onInit: function() {
					$(this).find('> li > ul').children('li:first-child').prepend('<span class="triangle"></span>');
				}
			});
		},

		/* Fixed header position */
		fixedHeader: function() {
			var header_wrapper = $('#header-wrapper'),
				header = $('#header', header_wrapper),
				is_small_screen = $(document).width() > 767 ? false : true;

			if ( !is_small_screen && header_wrapper.hasClass('fixed') ) {
				var headerHeight = header.outerHeight(),
					headerRgb = header.css('backgroundColor'),
					headerRgba = themeScript.rgbTorgba(headerRgb, '0.96');

				header.scrollToFixed();

				$(window).scroll(function(){
					if($(window).scrollTop() > headerHeight){
						header.css('backgroundColor', headerRgba);
					}
					else {
						header.css('backgroundColor', headerRgb);
						header.css('top', 0);
					}
				});	
			}
		},

		/* Isotope portfolio filtering */
		isotopeFiltering: function() {
			var filter = $('#portfolio-filter'),
				container = $('.isotope-container');

			container.imagesLoaded( function() {
				container.isotope({ 
					resizable: false,
					itemSelector: '.portfolio-item',
					layoutMode : 'fitRows'
				});
			});

			filter.find('a').click(function(e) {
				var selector = $(this).attr('data-option-value');

				filter.find('a').removeClass('selected');

				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					$(this).addClass('selected');
				}

				container.isotope({
					resizable: false,
					itemSelector: '.portfolio-item',
					layoutMode : 'fitRows',
					filter: selector
				});

				e.preventDefault();	
			});
		},

		/* Portfolio item UI */
		initPortfolioUI: function() {
			var container = $('.portfolio-items'),
				item = container.find('.item', container);

			container.imagesLoaded( function() {
				item.each( function() {
					var overlay = $(this).find('.overlay'),
						bgColor = themeScript.rgbTorgba(overlay.css('backgroundColor'), 0.5);

					overlay.css({
						display: 'block',
						backgroundColor: bgColor,
						opacity: '0'
					});

					overlay.parent().hover( function(){
						overlay.animate({
							opacity: 1
						}, 300);

						overlay.children().show();
					}, 
					function(){
						overlay.animate({
							opacity: 0
						}, 300);

						overlay.children().hide();
					});

					themeScript.toMiddle('.view-link', '.item-thumb');
				});
			});

			themeScript.isotopeFiltering();
		},

		/* PrettyPhoto init */
		initPrettyPhoto: function() {
			$('a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=gif], a[href$=bmp]:has(img), a[class^="prettyPhoto"]').prettyPhoto({
				theme: 'pp_default',
				default_width: 960,
				default_height: 480,
				social_tools: false
			});
		},

		/* Tabs shortcode */
		initTabs: function(){
			$('.tabs-content').each( function(){
				var $this = $(this),
					$tab = $(this).find('.tabs > div'),
					$tabFirst = $(this).find('.tabs > div:first'),
					$tabNav = $(this).find('.tabs-nav li a'),
					$tabNavFirst = $(this).find('.tabs-nav li:first-child a');

				$tab.hide();

				var activetab = '';

				if (typeof(localStorage) !== 'undefined' ) {
					activetab = localStorage.getItem('activetab');
				}

				if (activetab !== '' && $(activetab).length ) {
					$this.find(activetab).fadeIn(0);
				} 
				else {
					$tabFirst.fadeIn(0);
				}

				if (activetab !== '' && $(activetab + '_nav').length ) {
					$this.find(activetab + '_nav').addClass('active');
				}
				else {
					$tabNavFirst.addClass('active');
				}

				$tabNav.click(function(e) {

					$tabNav.removeClass('active');
					$(this).addClass('active').blur();

					var clicked_group = $(this).attr('href');

					if (typeof(localStorage) !== 'undefined' ) {
						localStorage.setItem("activetab", $(this).attr('href'));
					}

					$tab.hide();

					$this.find(clicked_group).fadeIn(0);

					e.preventDefault();

				});
			});
		},

		/* Accordion shortcode */
		initAccordion: function() {
			$('.accordion').each( function(){
				var $this = $(this),
					$pane = $this.find('.pane'),
					$paneFirst = $this.find('.pane:first'),
					$paneTitle = $this.find('.pane-title'),
					$paneTitleFirst = $this.find('.pane-title:first');

				$pane.hide();

				$paneFirst.show();
				$paneTitleFirst.addClass('active');

				$paneTitle.click( function(e){
					if($(this).next().is(':hidden')) {
						$(this).parent().find('.pane-title').removeClass('active').next().slideUp();
						$(this).toggleClass('active').next().slideDown();
					}
					e.preventDefault();
				});
			});
		},

		/* Alert message shortcode */
		alertMessage: function() {
			$('.alert-message').each(function() {
				$(this).append('<span class="close"><i class="icon-remove"></i></span>');
					$(this).children('.close').click(function() {
					$(this).parent().slideUp();
				});
			});
		},

		/* Clear default input value */
		clearInputValue: function() {
			$('input[type=text]').each( function() {
				var defaults = this.value;

				$(this).focus( function() {
					if(this.value === defaults) {
						this.value = '';
					}
				});

				$(this).blur( function() {
					if(this.value === '') {
						this.value = defaults;
					}
				});
			});
		},

		/* Send element to middle position */
		toMiddle: function(el, parent){
			var $this = $(el, parent),
				$thisHeight = $this.outerHeight(),
				$thisWidth = $this.outerWidth();

			$this.css({
				position: 'absolute',
				top: $this.parents(parent).height() / 2,
				left: $this.parents(parent).width() / 2,
				marginTop: $thisHeight / 2 * -1,
				marginLeft: $thisWidth / 2 * -1
			});

			$(window).smartresize( function(){
				themeScript.toMiddle(el, parent);
			});
		},

		/* Convert RGB to RGBA */
		rgbTorgba: function (rgb, opacity) {
			if (rgb === null) {
				return rgb;
			}
			if (typeof opacity === 'undefined') {
				return rgb;
			}
			var newrgb = rgb.replace(')', ', '),
				out = newrgb.replace('rgb', 'rgba');

			return out + opacity + ')';
		},

		/* Collect all function */
		init: function() {
			themeScript.initFlexSlider();
			themeScript.initSuperfish();
			themeScript.initPortfolioUI();
			themeScript.initAccordion();
			themeScript.initTabs();
			themeScript.alertMessage();
			themeScript.initPrettyPhoto();
			themeScript.clearInputValue();
			themeScript.fixedHeader();
		}
	};

	/* Do the magic */
	$( function() {
		themeScript.init();
		
		$(window).smartresize( function(){
			themeScript.initPortfolioUI();
		});
	});

})(jQuery);