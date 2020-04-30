/*eslint-disable */
import Vue from 'vue';
import Countdown from '../components/Countdown.vue';
import VueYouTubeEmbed from 'vue-youtube-embed';
import Slick from 'vue-slick';
import 'jquery-sticky';
import VueResource from 'vue-resource';
import 'velocity-animate/velocity';
//... some vue component imports ...

Vue.use(VueResource);
Vue.use(VueYouTubeEmbed)

export default {
	init() {

	},
	finalize() {
		const app = new Vue({
			el: '#app',
			components: {
				Countdown,
				Slick
			},
			data: {
				slickOptions: {
					slidesToShow: 2,
					arrows: false,
					dots: true,
					slidesToScroll: 2,
					adaptiveHeight: true,
					// infinite: false,
					// fade: true,
					// Any other options that can be got from plugin documentation
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					]
				},
				coursesFetched: false,
				selectedCourse: 0,
				youtubePlaying: false,
				navOpen: false,
				headerSticky: false,
				highlightDate: false,
				notYetPopup: false
			},
			methods: {
				playing: function() {
					// The player is playing a video.
					this.youtubePlaying = true;
				},
				end: function() {
					this.youtubePlaying = false;
				},
				hamburger: function(){
					this.navOpen = !this.navOpen;
				},
				fetchPricetable: function() {
					//alert(this.$http);
					this.$http.get('wp-json/pkpk/v1/pricetable').then(
						response => {
						// get body data
						if (response.body) {
							this.courses = response.body;
						} else {
							this.courses = null;
						}
						this.coursesFetched = true;
					},
					response => {
						// error callback
					}).then(function(){              
						$('[data-toggle="tooltip"]').tooltip();
					});
				},
				notYet: function() {
					this.notYetPopup = true;
				},
				closeNotYetPopup: function() {
					this.notYetPopup = false;
				},
				bsTooltipReflow: function() {
					setTimeout(function(){
						$('.price-table__item-footer [data-toggle="tooltip"]').tooltip();
					},100);
					// alert('huila');
				},
			},
			computed: {
				bannerClass: function () {
					return {
						'nav-open': this.navOpen,
						'white-logo': !this.navOpen && !this.headerSticky,
					}
				}
			},
			mounted: function() {        
				this.fetchPricetable();

				const header = $("#main-header");

				header.sticky({ topSpacing: 0, zIndex: 9 });

				header.on('sticky-start', function() {
					app.headerSticky = true;
				});

				header.on('sticky-end', function() {
					app.headerSticky = false;
				});

					// setTimeout(() => app.notYetPopup = true, 5000)

					const root = $('html, body');

					$('.home a.brand').on('click', function(e) {
						e.preventDefault();
						e.stopPropagation();

						$('#app').velocity('scroll', {
							duration: 500,
							easing: [ .71,.29,.15,.99 ]
						});
					});

					$('.nav-primary a, .scroll-to-btn').on('click', function(e) {
						const windowWidth = $(window).width();
						let additionalOffset;

						if ( windowWidth < 1024 ) {
							additionalOffset = -60;
						} else {
							additionalOffset = 120 - (windowWidth * 0.5 * 0.076);
						}

						/* eslint-disable no-console */
						// console.log(t);
						/* eslint-enable no-console */
						app.navOpen = false;

						e.preventDefault();
						e.stopPropagation();
					// set target to anchor's "href" attribute
					const target = $(this).attr('href');
					// scroll to each target
					$(target).velocity('scroll', {
						duration: 500,
						offset: additionalOffset,
						easing: [ .71,.29,.15,.99 ]
					});
				});

					if ( typeof wpcf7InitForm !== 'undefined' ) {
						$('div.wpcf7 > form').wpcf7InitForm();
					}

				// $('[data-toggle="tooltip"]').tooltip();
			},
			filters: {
				toFixed: function(value) {
					return Number(Number(value).toFixed(2));
				}
			}
		});

		$('.spin').velocity({  rotateZ: "+=360" }, { duration: 2000, easing: "linear", loop: true});

	},
};
