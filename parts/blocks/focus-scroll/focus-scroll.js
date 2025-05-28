import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register the ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

initFocusScroll();

function initFocusScroll() {
	const focusScrollWrappers = document.querySelectorAll('.js-focus-scroll-wrapper');

	if (!focusScrollWrappers.length) return;


	focusScrollWrappers.forEach((wrapper) => {
		const innerWrapper = wrapper.querySelector('.focus-scroll-inner-wrapper');
		const focusScroll = wrapper.querySelector('.focus-scroll');
		const items = wrapper.querySelectorAll('.focus-scroll__item');
		const mediaItems = wrapper.querySelectorAll('.focus-scroll__img, .focus-scroll__video');

		if (!items.length || !mediaItems.length || !focusScroll) return;

		// Initialize all media items with the proper styles
		mediaItems.forEach((item, index) => {
			// Set initial styles for transition
			gsap.set(item, {
				opacity: 0,
				display: 'block',
				position: 'absolute',
				top: 0,
				left: 0,
				width: '100%',
				zIndex: 0,
			});

			// For videos, preload but don't autoplay yet
			const videoPlayer = item.querySelector('video');
			if (videoPlayer) {
				videoPlayer.preload = 'auto';
			}
		});

		// Make the first image/video visible initially
		if (mediaItems[0]) {
			gsap.set(mediaItems[0], {
				opacity: 1,
				zIndex: 1,
			});

			// If first item is a video, start playing it
			const firstVideo = mediaItems[0].querySelector('video');
			if (firstVideo) {
				firstVideo.play().catch(error => console.log('Video play failed:', error));
			}
		}

		// Keep track of the current active index
		let currentActiveIndex = 0;

		// Create a ScrollTrigger for each section
		ScrollTrigger.create({
			trigger: wrapper,
			start: 'top top',
			end: 'bottom bottom',
			pin: innerWrapper,
			pinSpacing: false,
			scrub: true,
			onUpdate: (self) => {
				// Calculate which item should be active based on scroll progress
				const itemCount = items.length;
				const sectionProgress = self.progress;
				const itemStep = 1 / itemCount;

				const activeIndex = Math.min(
					Math.floor(sectionProgress / itemStep),
					itemCount - 1,
				);

				// Only update if the active index changed
				if (activeIndex !== currentActiveIndex) {
					// Update active state for items
					items.forEach((item, index) => {
						// Remove active class from all items
						item.classList.remove('focus-scroll__item--active');
					});

					// Add active class to current item
					if (items[activeIndex]) {
						items[activeIndex].classList.add('focus-scroll__item--active');
					}

					// Transition from current to new media item
					if (mediaItems[currentActiveIndex] && mediaItems[activeIndex]) {
						// Get the video elements if they exist
						const currentVideo = mediaItems[currentActiveIndex].querySelector('video');
						const nextVideo = mediaItems[activeIndex].querySelector('video');

						// Start playing the next video if it exists
						if (nextVideo) {
							nextVideo.play().catch(error => console.log('Video play failed:', error));
						}

						// Fade out current item
						gsap.to(mediaItems[currentActiveIndex], {
							opacity: 0,
							duration: 0,
							onComplete: () => {
								mediaItems[currentActiveIndex].style.zIndex = 0;

								// Pause the current video once it's fully hidden
								if (currentVideo) {
									currentVideo.pause();
								}
							},
						});

						// Fade in new item
						mediaItems[activeIndex].style.zIndex = 1;
						gsap.to(mediaItems[activeIndex], {
							opacity: 1,
							duration: 0.4,
						});
					}

					// Update current active index
					currentActiveIndex = activeIndex;
				}

				let topValue = 96;
				let bottomValue = 'auto';

				if (sectionProgress < 0.01) {
					topValue = 96;
					bottomValue = 'auto';
				} else if (sectionProgress > 0.99) {
					topValue = 'auto';
					bottomValue = 0;
				} else {
					topValue = 32;
					bottomValue = 32;
				}

				gsap.to(focusScroll, {
					top: topValue,
					bottom: bottomValue,
					duration: 0.4,
					overwrite: true,
				});
			},
		});

		// Add click event listeners to items
		items.forEach((item, index) => {
			item.addEventListener('click', () => {
				const bounds = wrapper.getBoundingClientRect();
				const wrapperTop = bounds.top + window.scrollY;

				let offset = 0;
				if (index === 0) {
					offset = 50;
				} else if (index === items.length - 1) {
					offset = -100;
				}

				const to = wrapperTop + ((bounds.height / 3) * index) + offset;

				// Scroll to position
				window.scrollTo({
					top: to,
					behavior: 'smooth',
				});
			});
		});
	});
}

