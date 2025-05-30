import Swiper from 'swiper';
import { Navigation, Autoplay, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/autoplay';
import 'swiper/css/pagination';

function initGridOfItemsBlock() {
	initGridOfItemsCarousels();
}

function initGridOfItemsCarousels() {
	const carousels = document.querySelectorAll('.js-grid-of-items-swiper');

	if (!carousels.length) {
		return;
	}

	carousels.forEach((carouselElement) => {
		const slidesPerViewDesktop = parseFloat(carouselElement.dataset.slidesPerView) || 3;
		const autoplaySpeed = parseInt(carouselElement.dataset.autoplay, 10) || 0;
		const pauseOnHover = carouselElement.dataset.pauseHover === 'true';
		const showNavigation = carouselElement.dataset.showNavigation === 'true';
		const showProgressbar = carouselElement.dataset.showProgressbar === 'true';

		const container = carouselElement.closest('.grid-of-items__carousel-container');
		const prevButton = container ? container.querySelector('.js-grid-of-items-prev') : null;
		const nextButton = container ? container.querySelector('.js-grid-of-items-next') : null;
		const paginationEl = container ? container.querySelector('.js-grid-of-items-pagination') : null;

		try {
			const swiperModules = [];
			const swiperConfig = {
				slidesPerView: 1,
				spaceBetween: 16,
				loop: false, // Loop will be conditional based on slides count later
				grabCursor: true,
				speed: 700,
				breakpoints: {
					768: {
						slidesPerView: Math.min(2, slidesPerViewDesktop),
						spaceBetween: 24,
					},
					1024: {
						slidesPerView: slidesPerViewDesktop,
						spaceBetween: 24,
					},
				},
			};

			if (showNavigation && prevButton && nextButton) {
				swiperModules.push(Navigation);
				swiperConfig.navigation = {
					nextEl: nextButton,
					prevEl: prevButton,
				};
			}

			if (autoplaySpeed > 0) {
				swiperModules.push(Autoplay);
				swiperConfig.autoplay = {
					delay: autoplaySpeed,
					disableOnInteraction: false,
					pauseOnMouseEnter: pauseOnHover,
				};
			}

			if (showProgressbar && paginationEl) {
				swiperModules.push(Pagination);
				swiperConfig.pagination = {
					el: paginationEl,
					type: 'progressbar',
					hide: false,
				};
			}

			swiperConfig.modules = swiperModules;

			const swiper = new Swiper(carouselElement, swiperConfig);

			// Conditionally enable loop
			const slidesCount = swiper.slides ? swiper.slides.length : 0;
			if (slidesCount > slidesPerViewDesktop) {
				swiper.params.loop = true;
				swiper.update(); // Update swiper instance with new loop parameter
			}

			// Manual hover listeners for pauseOnHover if autoplay is active
			if (swiperConfig.autoplay && pauseOnHover) {
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
			console.error('Swiper initialization error for grid-of-items:', error);
		}
	});
}

initGridOfItemsBlock();
