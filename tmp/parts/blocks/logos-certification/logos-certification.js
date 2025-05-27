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

		const slides = carouselElement.querySelectorAll('.swiper-slide');

		try {
			const swiperConfig = {
				modules: [Autoplay],
				slidesPerView: 2,
				spaceBetween: 16,
				loop: true,
				loopedSlides: slides.length,
				loopAdditionalSlides: 2,
				loopFillGroupWithBlank: true,
				grabCursor: true,
				speed: 700,
				breakpoints: {
					320: {
						slidesPerView: 1,
						spaceBetween: 16,
					},
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
						spaceBetween: 88,
					},
				},
			};

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
