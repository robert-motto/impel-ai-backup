import Swiper from 'swiper';
import { Navigation, Scrollbar, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

function initCarouselSliders() {
	const carousels = document.querySelectorAll('.js-carousel-slider-swiper');

	if (!carousels.length) {
		return;
	}

	carousels.forEach((carouselElement, index) => {
		// Read settings from data attributes
		const autoplaySpeed = parseInt(carouselElement.dataset.autoplay, 10) || 3000;
		const pauseOnHover = carouselElement.dataset.pauseHover === 'true';
		const slidesPerViewDesktop = parseInt(carouselElement.dataset.slidesPerView, 10) || 3;
		const showScrollbar = carouselElement.dataset.showScrollbar === 'true';

		// Find navigation and scrollbar elements relative to the carousel element
		const container = carouselElement.closest('.js-carousel-slider'); // Find the main container
		const prevButton = container ? container.querySelector('.js-carousel-slider-prev') : null;
		const nextButton = container ? container.querySelector('.js-carousel-slider-next') : null;
		const scrollbarEl = container ? container.querySelector('.js-carousel-slider-scrollbar') : null;

		// Get slides for loop logic
		const slides = carouselElement.querySelectorAll('.swiper-slide');
		const useLoop = slides.length > slidesPerViewDesktop;

		try {
			// Dynamically build modules array
			const swiperModules = [Navigation, Autoplay];
			if (showScrollbar && scrollbarEl) {
				swiperModules.push(Scrollbar);
			}

			const swiperConfig = {
				modules: swiperModules,
				slidesPerView: 1, // Start with 1 for mobile
				spaceBetween: 16,
				loop: useLoop,
				loopAdditionalSlides: useLoop ? 2 : 0, // Needed for smooth looping
				grabCursor: true,
				speed: 700,
				breakpoints: {
					// 768px and up
					768: {
						slidesPerView: 2,
						spaceBetween: 24,
					},
					// 1024px and up
					1024: {
						slidesPerView: Math.min(3, slidesPerViewDesktop), // Use 3 or configured value
						spaceBetween: 24,
					},
					// 1280px and up
					1280: {
						slidesPerView: slidesPerViewDesktop, // Use configured desktop value
						spaceBetween: 32,
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
			console.error(`Swiper initialization error for carousel slider ${index}:`, error);
		}
	});
}

function init() {
	initCarouselSliders();
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init(); // Run if already loaded
}
