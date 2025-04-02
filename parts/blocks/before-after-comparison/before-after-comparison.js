import { gsap } from 'gsap';
import { Draggable } from 'gsap/Draggable';

console.log('Before After Comparison script - Start loading');

if (!gsap.registerPlugin) {
	console.error('GSAP registerPlugin method not found!');
	throw new Error('GSAP not loaded properly');
}

console.log('Before After Comparison - GSAP found, registering Draggable');
gsap.registerPlugin(Draggable);
console.log('Before After Comparison - Draggable registered');

function initBeforeAfterComparison() {
	console.log('Before After Comparison - initBeforeAfterComparison called');
	const containers = document.querySelectorAll('.js-before-after-container');
	console.log('Before After Comparison - Found containers:', containers.length);

	if (!containers.length) {
		console.warn('Before After Comparison - No containers found with class .js-before-after-container');
		return;
	}

	containers.forEach((container) => {
		console.log(`[BA-Comparison] ID: ${container.id} - Found all required elements`);

		const beforeWrapper = container.querySelector('.js-before-wrapper');
		const afterWrapper = container.querySelector('.js-after-wrapper');
		const slider = container.querySelector('.js-comparison-slider');
		const containerId = container.id;
		console.log(`[BA-Comparison] ID: ${containerId} - Container elements:`, {
			beforeWrapper: !!beforeWrapper,
			afterWrapper: !!afterWrapper,
			slider: !!slider,
		});

		const beforeButton = document.querySelector(`.before-after-comparison__btn--before[data-comparison-id="${containerId}"]`);
		const afterButton = document.querySelector(`.before-after-comparison__btn--after[data-comparison-id="${containerId}"]`);
		console.log(`[BA-Comparison] ID: ${containerId} - Container buttons:`, {
			beforeButton: !!beforeButton,
			afterButton: !!afterButton,
		});

		if (!beforeWrapper || !afterWrapper || !slider) {
			console.error(`[BA-Comparison] Error: Missing required elements in ${containerId}`);
			return;
		}

		gsap.set(afterWrapper, { clipPath: 'inset(0 50% 0 0)' });
		gsap.set(slider, { left: '50%' });

		function updateUI(percentage) {
			const insetRight = 100 - percentage;
			gsap.set(afterWrapper, { clipPath: `inset(0 ${insetRight}% 0 0)` });

			if (percentage < 5) {
				beforeButton?.classList.add('is-active');
				afterButton?.classList.remove('is-active');
			} else if (percentage > 95) {
				afterButton?.classList.add('is-active');
				beforeButton?.classList.remove('is-active');
			} else {
				beforeButton?.classList.remove('is-active');
				afterButton?.classList.remove('is-active');
			}
		}

		let draggable = Draggable.create(slider, {
			type: 'x',
			bounds: container,
			inertia: false,
			onDrag: function() {
				const bounds = this.target.getBoundingClientRect();
				const containerBounds = container.getBoundingClientRect();
				const position = bounds.left - containerBounds.left;
				const percentage = (position / containerBounds.width) * 100;

				updateUI(percentage);

				if (Math.round(percentage) % 10 === 0) {
					console.log(`[Comparison] Drag: ${percentage.toFixed(1)}%`);
				}
			},
			onPress: function() {
				console.log(`[Comparison] Press`);
			},
			onRelease: function() {
				const bounds = this.target.getBoundingClientRect();
				const containerBounds = container.getBoundingClientRect();
				const position = bounds.left - containerBounds.left;
				const percentage = (position / containerBounds.width) * 100;

				console.log(`[Comparison] Release: ${percentage.toFixed(1)}%`);

				if (percentage < 5) {
					gsap.to(slider, { left: '0%', duration: 0.3, ease: 'power2.out' });
					gsap.to(afterWrapper, { clipPath: 'inset(0 100% 0 0)', duration: 0.3, ease: 'power2.out' });
					beforeButton?.classList.add('is-active');
					afterButton?.classList.remove('is-active');
				} else if (percentage > 95) {
					gsap.to(slider, { left: '100%', duration: 0.3, ease: 'power2.out' });
					gsap.to(afterWrapper, { clipPath: 'inset(0 0% 0 0)', duration: 0.3, ease: 'power2.out' });
					afterButton?.classList.add('is-active');
					beforeButton?.classList.remove('is-active');
				}
			},
		})[0];

		if (beforeButton && afterButton) {
			console.log(`[BA-Comparison] Click: Before button`);
			beforeButton.addEventListener('click', () => {
				console.log(`[BA-Comparison] Click: Before button`);
				gsap.to(slider, { left: '0%', duration: 0.6, ease: 'power2.out' });
				gsap.to(afterWrapper, { clipPath: 'inset(0 100% 0 0)', duration: 0.6, ease: 'power2.out' });
				beforeButton.classList.add('is-active');
				afterButton.classList.remove('is-active');
				draggable.update();
			});

			afterButton.addEventListener('click', () => {
				console.log(`[BA-Comparison] Click: After button`);
				gsap.to(slider, { left: '100%', duration: 0.6, ease: 'power2.out' });
				gsap.to(afterWrapper, { clipPath: 'inset(0 0% 0 0)', duration: 0.6, ease: 'power2.out' });
				afterButton.classList.add('is-active');
				beforeButton.classList.remove('is-active');
				draggable.update();
			});
		} else {
			console.warn(`[BA-Comparison] Warning: Buttons not found`);
		}

		console.log(`[BA-Comparison] Init: Adding touch event listeners`);
		slider.addEventListener('touchstart', () => {
			console.log(`[BA-Comparison] Touch start`);
			const handle = slider.querySelector('.before-after-comparison__slider-handle');
			if (handle) {
				gsap.to(handle, {
					scale: 1.2,
					duration: 0.3,
					ease: 'power2.out',
				});
			} else {
				console.warn(`[BA-Comparison] Warning: Slider handle not found for touch effect`);
			}
		}, { passive: true });

		slider.addEventListener('touchend', () => {
			console.log(`[BA-Comparison] Touch end`);
			const handle = slider.querySelector('.before-after-comparison__slider-handle');
			if (handle) {
				gsap.to(handle, {
					scale: 1,
					duration: 0.3,
					ease: 'power2.out',
				});
			}
		}, { passive: true });

		console.log(`[BA-Comparison] Init: Setup complete`);
	});

	console.log('Before After Comparison - All containers initialized');
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initBeforeAfterComparison);
} else {
	initBeforeAfterComparison();
}
