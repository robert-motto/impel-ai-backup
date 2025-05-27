function initTertiaryCTABackgroundMatching() {
	const tertiaryCTASections = document.querySelectorAll('.js-tertiary-cta');

	if (!tertiaryCTASections.length) return;

	tertiaryCTASections.forEach(section => {
		const previousSection = section.previousElementSibling;
		const nextSection = section.nextElementSibling;

		// Get computed background colors
		let previousBgColor = 'rgba(33, 31, 35, 1)'; // Default fallback
		let nextBgColor = 'rgba(18, 18, 18, 1)'; // Default fallback

		if (previousSection) {
			const previousStyles = window.getComputedStyle(previousSection);
			const prevBg = previousStyles.backgroundColor;
			previousBgColor = prevBg;
		}

		if (nextSection) {
			const nextStyles = window.getComputedStyle(nextSection);
			const nextBg = nextStyles.backgroundColor;
			nextBgColor = nextBg;
		}

		// Apply the background colors
		section.style.setProperty('--tertiary-cta-bg', nextBgColor);
		section.style.setProperty('--tertiary-cta-before-bg', previousBgColor);
	});
}

window.addEventListener('load', function() {
	initTertiaryCTABackgroundMatching();
});

