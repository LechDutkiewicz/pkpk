(function($) {

 	/*=============================================
	=            Enable Magnific Popup            =
	=============================================*/
	
	var enableMagnific = function( $el ) {

		if (typeof $.fn.magnificPopup === 'function') {
			// Initialize magnific popup for video attachments for read more buttons
			// Read more at http://dimsemenov.com/plugins/magnific-popup/

			$el = $el || $(".popup__video:not(.bound), .popup__gmaps:not(.bound)");

			$el.addClass("bound").magnificPopup({
				disableOn: 700,
				type:'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false,

				iframe: {
					markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" frameborder="0" allowautoplay allowfullscreen></iframe>'+
					'</div>',

					patterns: {
						youtube: {
							index: 'youtube.com/',

							id: 'v=',

							src: '//www.youtube.com/embed/%id%?autoplay=1&hd=1'
						},
						vimeo: {
							index: 'vimeo.com/',
							id: '/',
							src: '//player.vimeo.com/video/%id%?autoplay=1'
						},
						gmaps: {
							index: '//maps.google.',
							src: '%id%&output=embed'
						}

					},

					srcAction: 'iframe_src',
				},
			});
		}
	};

	$(document).ready(function($) {

		/*----------  Magnific popup  ----------*/

		if ( typeof enableMagnific === "function" && typeof acf === "object" ) {

			/*----------  mfp for popup links for video documentation section  ----------*/

			enableMagnific();

			acf.add_action('append', function( $el ){

				var $link = $el.find('.popup__video');

				enableMagnific( $link );
			});
		}

	});

})(jQuery);