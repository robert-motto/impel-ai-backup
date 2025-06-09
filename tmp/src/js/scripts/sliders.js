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
		const slidesPerViewDesktop = parseFloat(carouselElement.dataset.slidesPerView, 10) || 'auto';
		const slidesPerViewTablet = slidesPerViewDesktop === 'auto' ? 'auto' : Math.min(2, slidesPerViewDesktop);
		const slidesPerViewMobile = slidesPerViewDesktop === 'auto' ? 'auto' : 1;
		const showNavigation = carouselElement.dataset.showNavigation === 'true';
		const showProgressbar = carouselElement.dataset.showProgressbar === 'true';
		const spaceBetween = parseInt(carouselElement.dataset.spaceBetween, 10) || 16;
		const loop = carouselElement.dataset.loop === 'true';
		const slidesOffsetBefore = parseInt(carouselElement.dataset.slidesOffsetBefore, 10) || 0;
		const linear = carouselElement.dataset.linear === 'true';

		// Find navigation and scrollbar elements relative to the carousel element
		const container = carouselElement.closest('.slider__carousel-container');
		const prevButton = container ? container.querySelector('.js-slider-prev') : null;
		const nextButton = container ? container.querySelector('.js-slider-next') : null;
		const progressbarEl = container ? container.querySelector('.js-slider-progressbar') : null;

		// Add linear transition styling if linear option is enabled
		if (linear) {
			const swiperWrapper = carouselElement.querySelector('.swiper-wrapper');
			if (swiperWrapper) {
				swiperWrapper.style.transitionTimingFunction = 'linear';
			}
		}

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
				breakpoints: {
					// 768px and up
					768: {
						slidesPerView: slidesPerViewTablet,
						spaceBetween: 24,
						slidesOffsetBefore: slidesOffsetBefore / 4,
					},
					// 1024px and up
					1024: {
						slidesPerView: slidesPerViewDesktop,
						slidesOffsetBefore: slidesOffsetBefore / 4,
					},
					// 1280px and up
					1280: {
						slidesPerView: slidesPerViewDesktop,
						slidesOffsetBefore,
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
				if (linear) {
					// Linear autoplay configuration
					swiperConfig.autoplay = {
						delay: 0,
						disableOnInteraction: false,
						pauseOnMouseEnter: pauseOnHover,
					};
					swiperConfig.speed = autoplaySpeed;
				} else {
					// Standard autoplay configuration
					swiperConfig.autoplay = {
						delay: autoplaySpeed,
						disableOnInteraction: false, // Keep playing after user interaction
						pauseOnMouseEnter: pauseOnHover,
					};
				}
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
