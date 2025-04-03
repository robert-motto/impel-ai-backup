/**
 * Testimonials Block JavaScript
 * Handles modal video functionality
 */

function initTestimonialsBlock() {
	const testimonialSections = document.querySelectorAll('.js-testimonials');

	if (!testimonialSections.length) {
		return;
	}

	testimonialSections.forEach((section) => {
		const videoTriggers = section.querySelectorAll('.js-video-trigger');
		const videoModal = section.querySelector('.js-video-modal');
		const videoWrapper = section.querySelector('.js-video-wrapper');
		const closeButtons = section.querySelectorAll('.js-video-modal-close');

		if (!videoModal || !videoWrapper) {
			return;
		}

		videoTriggers.forEach((trigger) => {
			trigger.addEventListener('click', () => {
				const videoUrl = trigger.dataset.videoUrl;

				if (!videoUrl) {
					return;
				}

				openVideoModal(videoUrl, videoModal, videoWrapper);
			});
		});

		closeButtons.forEach((button) => {
			button.addEventListener('click', () => {
				closeVideoModal(videoModal, videoWrapper);
			});
		});

		// Close on ESC key
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && videoModal.classList.contains('is-active')) {
				closeVideoModal(videoModal, videoWrapper);
			}
		});
	});
}

/**
 * Opens the video modal with the provided video URL
 *
 * @param {string} videoUrl - URL of the video to display
 * @param {HTMLElement} modal - The modal element
 * @param {HTMLElement} wrapper - The wrapper where the video will be inserted
 */
function openVideoModal(videoUrl, modal, wrapper) {
	// Clear previous content
	wrapper.innerHTML = '';

	// Create appropriate embed based on URL type
	let embedHTML = '';

	if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
		// YouTube video
		const youtubeId = getYoutubeId(videoUrl);
		if (youtubeId) {
			embedHTML = `<iframe src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
		}
	} else if (videoUrl.includes('vimeo.com')) {
		// Vimeo video
		const vimeoId = getVimeoId(videoUrl);
		if (vimeoId) {
			embedHTML = `<iframe src="https://player.vimeo.com/video/${vimeoId}?autoplay=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
		}
	} else if (videoUrl.match(/\.(mp4|webm|ogg)$/i)) {
		// Direct video file
		embedHTML = `<video controls autoplay><source src="${videoUrl}" type="video/${videoUrl.split('.').pop()}">Your browser does not support the video tag.</video>`;
	}

	// Insert the embed HTML
	wrapper.innerHTML = embedHTML;

	// Show the modal
	modal.classList.add('is-active');
	document.body.style.overflow = 'hidden';
}

/**
 * Closes the video modal
 *
 * @param {HTMLElement} modal - The modal element
 * @param {HTMLElement} wrapper - The wrapper containing the video
 */
function closeVideoModal(modal, wrapper) {
	modal.classList.remove('is-active');
	document.body.style.overflow = '';

	// Clear the wrapper content (stops playback)
	setTimeout(() => {
		wrapper.innerHTML = '';
	}, 300);
}

/**
 * Extracts YouTube video ID from various YouTube URL formats
 *
 * @param {string} url - YouTube URL
 * @returns {string|null} - YouTube video ID or null if not found
 */
function getYoutubeId(url) {
	const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
	const match = url.match(regExp);
	return (match && match[2].length === 11) ? match[2] : null;
}

/**
 * Extracts Vimeo video ID from various Vimeo URL formats
 *
 * @param {string} url - Vimeo URL
 * @returns {string|null} - Vimeo video ID or null if not found
 */
function getVimeoId(url) {
	const regExp = /vimeo.com\/(?:video\/)?(\d+)/;
	const match = url.match(regExp);
	return match ? match[1] : null;
}

// Initialize on DOM content loaded
document.addEventListener('DOMContentLoaded', initTestimonialsBlock);
