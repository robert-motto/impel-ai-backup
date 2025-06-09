import { gsap } from 'gsap';
import { Draggable } from 'gsap/Draggable';

if (!gsap.registerPlugin) {
	throw new Error('GSAP not loaded properly');
}

gsap.registerPlugin(Draggable);

function initBeforeAfterComparison() {
	const containers = document.querySelectorAll('.js-before-after-container');

	if (!containers.length) {
		return;
	}

	containers.forEach((container) => {
		const beforeWrapper = container.querySelector('.js-before-wrapper');
		const afterWrapper = container.querySelector('.js-after-wrapper');
		const slider = container.querySelector('.js-comparison-slider');
		const containerId = container.id;

		const beforeButton = document.querySelector(`.before-after-comparison__btn--before[data-comparison-id="${containerId}"]`);
		const afterButton = document.querySelector(`.before-after-comparison__btn--after[data-comparison-id="${containerId}"]`);

		if (!beforeWrapper || !afterWrapper || !slider) {
			console.error(`[BA-Comparison] Error: Missing required elements in ${containerId}`);
			return;
		}

		// Initialize positions - set initial state without conflicting transforms
		gsap.set(slider, {
			left: '50%',
			x: '-50%', // This replaces the CSS transform to avoid conflicts
		});
		gsap.set(afterWrapper, { clipPath: 'inset(0 50% 0 0)' });

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
				const containerRect = container.getBoundingClientRect();
				const sliderRect = this.target.getBoundingClientRect();
				const sliderCenter = sliderRect.left + (sliderRect.width / 2);
				const containerLeft = containerRect.left;
				const position = sliderCenter - containerLeft;
				const percentage = Math.max(0, Math.min(100, (position / containerRect.width) * 100));

				updateUI(percentage);
			},
			onRelease: function() {
				const containerRect = container.getBoundingClientRect();
				const sliderRect = this.target.getBoundingClientRect();
				const sliderCenter = sliderRect.left + (sliderRect.width / 2);
				const containerLeft = containerRect.left;
				const position = sliderCenter - containerLeft;
				const percentage = Math.max(0, Math.min(100, (position / containerRect.width) * 100));

				if (percentage < 5) {
					gsap.to(slider, {
						left: '0%',
						x: '0%',
						duration: 0.3,
						ease: 'power2.out',
					});
					gsap.to(afterWrapper, { clipPath: 'inset(0 100% 0 0)', duration: 0.3, ease: 'power2.out' });
					beforeButton?.classList.add('is-active');
					afterButton?.classList.remove('is-active');
				} else if (percentage > 95) {
					gsap.to(slider, {
						left: '100%',
						x: '-100%',
						duration: 0.3,
						ease: 'power2.out',
					});
					gsap.to(afterWrapper, { clipPath: 'inset(0 0% 0 0)', duration: 0.3, ease: 'power2.out' });
					afterButton?.classList.add('is-active');
					beforeButton?.classList.remove('is-active');
				}
			},
		})[0];

		if (beforeButton && afterButton) {
			beforeButton.addEventListener('click', () => {
				gsap.to(slider, {
					left: '0%',
					x: '0%',
					duration: 0.6,
					ease: 'power2.out',
				});
				gsap.to(afterWrapper, { clipPath: 'inset(0 100% 0 0)', duration: 0.6, ease: 'power2.out' });
				beforeButton.classList.add('is-active');
				afterButton.classList.remove('is-active');
				draggable.update();
			});

			afterButton.addEventListener('click', () => {
				gsap.to(slider, {
					left: '100%',
					x: '-100%',
					duration: 0.6,
					ease: 'power2.out',
				});
				gsap.to(afterWrapper, { clipPath: 'inset(0 0% 0 0)', duration: 0.6, ease: 'power2.out' });
				afterButton.classList.add('is-active');
				beforeButton.classList.remove('is-active');
				draggable.update();
			});
		}

		slider.addEventListener('touchstart', () => {
			const handle = slider.querySelector('.before-after-comparison__slider-handle');
			if (handle) {
				gsap.to(handle, {
					scale: 1.2,
					duration: 0.3,
					ease: 'power2.out',
				});
			}
		}, { passive: true });

		slider.addEventListener('touchend', () => {
			const handle = slider.querySelector('.before-after-comparison__slider-handle');
			if (handle) {
				gsap.to(handle, {
					scale: 1,
					duration: 0.3,
					ease: 'power2.out',
				});
			}
		}, { passive: true });
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initBeforeAfterComparison);
} else {
	initBeforeAfterComparison();
}
