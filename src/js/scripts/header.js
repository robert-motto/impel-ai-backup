const throttle = (func, delay) => {
	let timerId;
	let lastInvokeTime = 0;
	return (...args) => {
		const now = Date.now();
		const timeElapsed = now - lastInvokeTime;
		if (timeElapsed >= delay) {
			lastInvokeTime = now;
			func.apply(this, args);
		} else if (!timerId) {
			timerId = setTimeout(() => {
				timerId = null;
				lastInvokeTime = Date.now();
				func.apply(this, args);
			}, delay - timeElapsed);
		}
	};
};

window.addEventListener('load', () => {
	const headerAll = document.querySelectorAll('.js-header');
	headerAll.forEach((header) => {
		const scrollOffset = 80;
		let currentScroll;
		let prevScroll = window.scrollY || document.documentElement.scrollTop;
		let prevDirection = 0;
		let direction = 0;
		const type = header.getAttribute('type');
		const limit =
			Math.max(
				document.body.scrollHeight,
				document.body.offsetHeight,
				document.documentElement.clientHeight,
				document.documentElement.scrollHeight,
				document.documentElement.offsetHeight,
			) - window.innerHeight;

		const toggleHeader = (dir, curScroll) => {
			if (dir === 2 && curScroll > scrollOffset) {
				header.classList.add('is-scrolled-down');
				prevDirection = dir;
			} else if (dir === 1) {
				header.classList.remove('is-scrolled-down');
				prevDirection = dir;
			}
		};

		const checkScroll = () => {
			currentScroll =
				window.scrollY || document.documentElement.scrollTop;
			currentScroll = Math.max(0, Math.min(currentScroll, limit));
			if (currentScroll > prevScroll) {
				direction = 2;
			} else if (currentScroll < prevScroll) {
				direction = 1;
			}
			if (currentScroll >= limit) {
				direction = 2;
			}
			if (direction !== prevDirection) {
				toggleHeader(direction, currentScroll);
			}
			if (currentScroll > 0) {
				if (type === 'is-dark') {
					header.classList.add('is-scrolled', 'is-light');
					header.classList.remove('is-dark');
				} else {
					header.classList.add('is-scrolled');
				}
			} else {
				if (type === 'is-dark') {
					header.classList.remove('is-scrolled', 'is-light');
					header.classList.add('is-dark');
				} else {
					header.classList.remove('is-scrolled');
				}
			}
			prevScroll = currentScroll;
		};

		window.addEventListener('scroll', throttle(checkScroll, 100));
		window.addEventListener('load', checkScroll);
		checkScroll();
	});

	// Initialize mega menu functionality
	initMegaMenu();
});

function initMegaMenu() {
	const menuItems = document.querySelectorAll(
		'.site-top-nav > .site-top-nav__item',
	);
	if (!menuItems.length) return;

	// Add hover handling for desktop
	menuItems.forEach((item) => {
		const subMenuWrap = item.querySelector('.sub-menu-wrap');
		if (!subMenuWrap) return;

		// Handle tabs if present
		const tabsNav = subMenuWrap.querySelector('.sub-menu-wrap__tabs-nav');
		if (tabsNav) {
			const tabButtons = tabsNav.querySelectorAll(
				'.sub-menu-wrap__tab-btn',
			);
			const tabPanels = subMenuWrap.querySelectorAll(
				'.sub-menu-wrap__tab-panel',
			);

			// Switch tabs on hover
			tabButtons.forEach((button) => {
				button.addEventListener('mouseenter', () => {
					const tabIndex = button.getAttribute('data-tab');

					// Update active states
					tabButtons.forEach((btn) =>
						btn.classList.remove('is-active'),
					);
					tabPanels.forEach((panel) =>
						panel.classList.remove('is-active'),
					);

					button.classList.add('is-active');
					subMenuWrap
						.querySelector(
							`.sub-menu-wrap__tab-panel[data-tab='${tabIndex}']`,
						)
						.classList.add('is-active');
				});
			});
		}

		// Add keyboard navigation support - focus trap
		const focusableElements = subMenuWrap.querySelectorAll(
			'a, button, input, select, textarea, [tabindex]:not([tabindex=\'-1\'])',
		);
		const firstFocusableElement = focusableElements[0];
		const lastFocusableElement =
			focusableElements[focusableElements.length - 1];

		// Handle keyboard navigation
		subMenuWrap.addEventListener('keydown', (e) => {
			if (e.key === 'Escape') {
				// Escape key - close menu and focus trigger
				const triggerLink = item.querySelector('a');
				if (triggerLink) {
					triggerLink.focus();
					item.classList.remove('is-active');
				}
			} else if (e.key === 'Tab') {
				// Trap focus within the menu
				if (
					e.shiftKey &&
					document.activeElement === firstFocusableElement
				) {
					e.preventDefault();
					lastFocusableElement.focus();
				} else if (
					!e.shiftKey &&
					document.activeElement === lastFocusableElement
				) {
					e.preventDefault();
					firstFocusableElement.focus();
				}
			}
		});
	});
}
