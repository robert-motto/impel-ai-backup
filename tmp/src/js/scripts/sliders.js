// By default Swiper exports only core version without additional modules (like Navigation, Pagination, etc.). So you need to import and configure them:
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
// Import Lazyload for looped sliders to avoid image jumping
import { lazyLoadInstance } from '../libs/lazyLoad';

const exampleSliderHldAll = document.querySelectorAll('.js-example-slider-hld');
exampleSliderHldAll.forEach(sliderHld => {
	const sliderEl = sliderHld.querySelector('.js-example-slider');
	const slider = new Swiper(sliderEl, {
		modules: [EffectFade, Navigation, Pagination, Autoplay],
		slidesPerView: 3,
		spaceBetween: 20,
		loop: true,
		grabCursor: true,
		navigation: {
			prevEl: sliderHld.querySelector('.js-example-slider-prev-btn'),
			nextEl: sliderHld.querySelector('.js-example-slider-next-btn'),
		},
		pagination: {
			el: sliderHld.querySelector('.js-example-slider-pagination'),
			type: 'bullets',
			bulletActiveClass: 'is-active',
			clickable: true,
		},
		on: {
			slideChange: function() {
				lazyLoadInstance.update();
			},
		},
	});
	slider;
});
