import LazyLoad from 'vanilla-lazyload';

export const lazyLoadInstance = new LazyLoad({
	elements_selector: '.js-lazy',
	restore_on_error: true,
	threshold: 250,
	// use_native: false,
	// container: document.querySelector('.js-your-smooth-scroll-container'),
});
