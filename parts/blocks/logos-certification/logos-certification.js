import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/autoplay';

function initLogosCarousels() {
	const carousels = document.querySelectorAll('.js-logos-carousel');

	if (!carousels.length) {
		return;
	}

	carousels.forEach((carouselElement, index) => {
		const displayMode = carouselElement.dataset.displayMode;
		const autoplaySpeed = parseInt(carouselElement.dataset.autoplay, 10) || 3000;
		const pauseOnHover = carouselElement.dataset.pauseHover === 'true';
		const slidesPerView = parseInt(carouselElement.dataset.slidesPerView, 10) || 5;

		const prevButton = carouselElement.querySelector('.js-logos-prev');
		const nextButton = carouselElement.querySelector('.js-logos-next');

		const swiperWrapper = carouselElement.querySelector('.swiper-wrapper');
		const slides = carouselElement.querySelectorAll('.swiper-slide');

		try {
			const swiperConfig = {
				modules: displayMode === 'carousel' ? [Navigation, Autoplay] : [],
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
						slidesPerView: slidesPerView,
						spaceBetween: 40,
					},
				},
			};

			if (displayMode === 'carousel') {
				swiperConfig.autoplay = {
					delay: autoplaySpeed,
					disableOnInteraction: pauseOnHover,
					pauseOnMouseEnter: pauseOnHover,
				};

				swiperConfig.navigation = {
					nextEl: nextButton,
					prevEl: prevButton,
				};
			} else {
				swiperConfig.freeMode = {
					enabled: true,
					sticky: false,
				};
				swiperConfig.allowTouchMove = true;
			}

			const swiper = new Swiper(carouselElement, swiperConfig);

			if (displayMode === 'carousel' && pauseOnHover) {
				carouselElement.addEventListener('mouseenter', () => {
					swiper.autoplay.stop();
				});

				carouselElement.addEventListener('mouseleave', () => {
					swiper.autoplay.start();
				});
			}
		} catch (error) {
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
