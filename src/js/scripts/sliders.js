import Swiper from 'swiper';
import { Navigation, Autoplay, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

function initSliders() {
	const carousels = document.querySelectorAll('.js-slider');

	if (!carousels.length) {
		return;
	}

	carousels.forEach((carouselElement) => {
		// Read settings from data attributes
		const autoplaySpeed = parseInt(carouselElement.dataset.autoplay, 10) || 0;
		const pauseOnHover = carouselElement.dataset.pauseHover === 'true';
		const slidesPerViewDesktop = parseInt(carouselElement.dataset.slidesPerView, 10) || 'auto';
		const slidesPerViewTablet = slidesPerViewDesktop === 'auto' ? 'auto' : Math.min(2, slidesPerViewDesktop);
		const slidesPerViewMobile = slidesPerViewDesktop === 'auto' ? 'auto' : 1;
		const showNavigation = carouselElement.dataset.showNavigation === 'true';
		const showProgressbar = carouselElement.dataset.showProgressbar === 'true';
		const spaceBetween = parseInt(carouselElement.dataset.spaceBetween, 10) || 16;
		const loop = carouselElement.dataset.loop === 'true';

		// Find navigation and scrollbar elements relative to the carousel element
		const container = carouselElement.closest('.slider__carousel-container');
		const prevButton = container ? container.querySelector('.js-slider-prev') : null;
		const nextButton = container ? container.querySelector('.js-slider-next') : null;
		const progressbarEl = container ? container.querySelector('.js-slider-progressbar') : null;

		try {
			// Dynamically build modules array
			const swiperModules = [Navigation];

			if (autoplaySpeed > 0) {
				swiperModules.push(Autoplay);
			}

			if (showProgressbar && progressbarEl) {
				swiperModules.push(Pagination);
			}

			const swiperConfig = {
				modules: swiperModules,
				slidesPerView: slidesPerViewMobile,
				spaceBetween,
				loop,
				grabCursor: true,
				speed: 700,
				breakpoints: {
					// 768px and up
					768: {
						slidesPerView: slidesPerViewTablet,
						spaceBetween: 24,
					},
					// 1024px and up
					1024: {
						slidesPerView: slidesPerViewDesktop,
					},
				},
			};

			// Add navigation if buttons exist
			if (showNavigation && prevButton && nextButton) {
				swiperConfig.navigation = {
					nextEl: nextButton,
					prevEl: prevButton,
				};
			}

			// Add progressbar configuration if enabled and element exists
			if (showProgressbar && progressbarEl) {
				swiperConfig.pagination = {
					el: progressbarEl,
					type: 'progressbar',
					hide: false, // Keep scrollbar visible
				};
			}

			// Add autoplay configuration if speed is greater than 0
			if (autoplaySpeed > 0) {
				swiperConfig.autoplay = {
					delay: autoplaySpeed,
					disableOnInteraction: false, // Keep playing after user interaction
					pauseOnMouseEnter: pauseOnHover,
				};
			}

			// Initialize Swiper
			const swiper = new Swiper(carouselElement, swiperConfig);

			// Manual hover listeners only if pauseOnHover is true and autoplay is active
			if (autoplaySpeed > 0 && pauseOnHover) {
				carouselElement.addEventListener('mouseenter', () => {
					if (swiper.autoplay && swiper.autoplay.running) {
						swiper.autoplay.stop();
					}
				});

				carouselElement.addEventListener('mouseleave', () => {
					if (swiper.autoplay && !swiper.autoplay.running) {
						swiper.autoplay.start();
					}
				});
			}
		} catch (error) {
			console.error('Swiper initialization error:', error);
		}
	});
}

initSliders();


// // By default Swiper exports only core version without additional modules (like Navigation, Pagination, etc.). So you need to import and configure them:
// import Swiper from 'swiper';
// import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
// // Import Lazyload for looped sliders to avoid image jumping
// import { lazyLoadInstance } from '../libs/lazyLoad';

// const exampleSliderHldAll = document.querySelectorAll('.js-example-slider-hld');
// exampleSliderHldAll.forEach(sliderHld => {
// 	const sliderEl = sliderHld.querySelector('.js-example-slider');
// 	const slider = new Swiper(sliderEl, {
// 		modules: [EffectFade, Navigation, Pagination, Autoplay],
// 		slidesPerView: 3,
// 		spaceBetween: 20,
// 		loop: true,
// 		grabCursor: true,
// 		navigation: {
// 			prevEl: sliderHld.querySelector('.js-example-slider-prev-btn'),
// 			nextEl: sliderHld.querySelector('.js-example-slider-next-btn'),
// 		},
// 		pagination: {
// 			el: sliderHld.querySelector('.js-example-slider-pagination'),
// 			type: 'bullets',
// 			bulletActiveClass: 'is-active',
// 			clickable: true,
// 		},
// 		on: {
// 			slideChange: function() {
// 				lazyLoadInstance.update();
// 			},
// 		},
// 	});
// 	slider;
// });
