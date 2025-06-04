import Swiper from 'swiper';
import { Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/autoplay';

function initLogosCarousels() {
	const carousels = document.querySelectorAll('.js-logos-carousel');

	if (!carousels.length) {
		return;
	}

	carousels.forEach((carouselElement, index) => {
		const autoplaySpeed = parseInt(carouselElement.dataset.autoplay, 10) || 3000;
		const pauseOnHover = carouselElement.dataset.pauseHover === 'true';
		const slidesPerViewDesktop = parseInt(carouselElement.dataset.slidesPerView, 10) || 5;

		const slides = carouselElement.querySelectorAll('.swiper-slide');
		const shouldLoop = slides.length > slidesPerViewDesktop;

		try {
			const swiperConfig = {
				modules: [Autoplay],
				slidesPerView: 1,
				spaceBetween: 16,
				loop: shouldLoop,
				grabCursor: true,
				speed: 700,
				centeredSlides: false,
				watchOverflow: true,
				normalizeSlideIndex: true,
				breakpoints: {
					480: {
						slidesPerView: 2,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 3,
						spaceBetween: 24,
					},
					1024: {
						slidesPerView: 4,
						spaceBetween: 30,
					},
					1280: {
						slidesPerView: slidesPerViewDesktop,
						spaceBetween: 88,
					},
				},
			};

			if (shouldLoop) {
				swiperConfig.loopAdditionalSlides = Math.max(slidesPerViewDesktop * 2, 6);
			}

			swiperConfig.autoplay = {
				delay: autoplaySpeed,
				disableOnInteraction: pauseOnHover,
				pauseOnMouseEnter: pauseOnHover,
			};

			const swiper = new Swiper(carouselElement, swiperConfig);

			if (pauseOnHover) {
				carouselElement.addEventListener('mouseenter', () => {
					swiper.autoplay.stop();
				});

				carouselElement.addEventListener('mouseleave', () => {
					swiper.autoplay.start();
				});
			}
		} catch (error) {
			console.error(`Swiper initialization error for carousel ${index}:`, error);
		}
	});
}

function init() {
	initLogosCarousels();
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
