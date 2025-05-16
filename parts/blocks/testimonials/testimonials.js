import Swiper from 'swiper';
import { Navigation, Scrollbar, Autoplay, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

/**
 * Testimonials Block JavaScript
 */

function initTestimonialsBlock() {
	initTestimonialsCarousels();
}

function initTestimonialsCarousels() {
	const carousels = document.querySelectorAll('.js-testimonials-carousel');

	if (!carousels.length) {
		return;
	}

	carousels.forEach((carouselElement) => {
		// Read settings from data attributes
		const autoplaySpeed = parseInt(carouselElement.dataset.autoplay, 10) || 0;
		const pauseOnHover = carouselElement.dataset.pauseHover === 'true';
		const slidesPerViewDesktop = parseInt(carouselElement.dataset.slidesPerView, 10) || 2;
		const showScrollbar = carouselElement.dataset.showScrollbar === 'true';
		const showProgressbar = carouselElement.dataset.showProgressbar === 'true';

		// Find navigation and scrollbar elements relative to the carousel element
		const container = carouselElement.closest('.testimonials__carousel-container');
		const prevButton = container ? container.querySelector('.js-testimonials-prev') : null;
		const nextButton = container ? container.querySelector('.js-testimonials-next') : null;
		const scrollbarEl = container ? container.querySelector('.js-testimonials-scrollbar') : null;
		const progressbarEl = container ? container.querySelector('.js-testimonials-progressbar') : null;

		try {
			// Dynamically build modules array
			const swiperModules = [Navigation];

			if (autoplaySpeed > 0) {
				swiperModules.push(Autoplay);
			}

			if (showScrollbar && scrollbarEl) {
				swiperModules.push(Scrollbar);
			}

			if (showProgressbar && progressbarEl) {
				swiperModules.push(Pagination);
			}

			const swiperConfig = {
				modules: swiperModules,
				slidesPerView: 1, // Start with 1 for mobile
				spaceBetween: 16,
				loop: false,
				grabCursor: true,
				speed: 700,
				breakpoints: {
					// 768px and up
					768: {
						slidesPerView: Math.min(2, slidesPerViewDesktop), // Use 2 or configured value
						spaceBetween: 24,
					},
					// 1024px and up
					1024: {
						slidesPerView: slidesPerViewDesktop, // Use configured desktop value
					},
				},
			};

			// Add navigation if buttons exist
			if (prevButton && nextButton) {
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

			// Add scrollbar configuration if enabled and element exists
			if (showScrollbar && scrollbarEl) {
				swiperConfig.scrollbar = {
					el: scrollbarEl,
					draggable: true,
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

initTestimonialsBlock();
