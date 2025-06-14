function adjustSectionPadding() {
	const sections = document.querySelectorAll('.js-section');

	// Function to get background mode from section classes
	function getBackgroundMode(section) {
		const classList = Array.from(section.classList);

		let colorMode = '';
		let variant = '';

		// Get color mode
		if (classList.includes('color-mode-is-dark')) {
			colorMode = 'color-mode-is-dark';
		} else if (classList.includes('color-mode-is-light')) {
			colorMode = 'color-mode-is-light';
		}

		// Get variant
		if (classList.includes('color-mode-variant-primary')) {
			variant = 'color-mode-variant-primary';
		} else if (classList.includes('color-mode-variant-secondary')) {
			variant = 'color-mode-variant-secondary';
		}

		// Return combined background identifier
		return `${colorMode}-${variant}`;
	}

	// Function to get computed padding-top value in pixels
	function getPaddingTop(section) {
		const computedStyle = window.getComputedStyle(section);
		const paddingTop = computedStyle.paddingTop;
		const parsed = parseInt(paddingTop, 10) || 0;
		return parsed;
	}

	// Function to set padding-top value
	function setPaddingTop(section, value) {
		section.style.paddingTop = `${value}px`;
	}

	// Process each section starting from the second one
	for (let i = 1; i < sections.length; i++) {
		const currentSection = sections[i];
		const previousSection = sections[i - 1];

		// Skip if previous section is tertiary CTA
		if (previousSection.classList.contains('js-tertiary-cta')) {
			continue;
		}

		const currentBackground = getBackgroundMode(currentSection);
		const previousBackground = getBackgroundMode(previousSection);

		// If backgrounds match, reduce top padding by 2px
		if (currentBackground === previousBackground && currentBackground !== '-') {
			const currentPadding = getPaddingTop(currentSection);
			const reducedPadding = Math.max(0, currentPadding / 2);

			setPaddingTop(currentSection, reducedPadding);
		}
	}
}

if (document.readyState === 'complete') {
	// All resources including CSS are loaded
	adjustSectionPadding();
} else {
	// Wait for all resources to load, not just DOM
	window.addEventListener('load', adjustSectionPadding);
}
