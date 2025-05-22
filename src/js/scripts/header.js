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

				const globalDropdown = document.querySelector('.js-global-dropdown');
				const globalToggle = document.querySelector('.js-global-toggle');
				if (globalDropdown && globalDropdown.classList.contains('is-active')) {
					globalDropdown.classList.remove('is-active');
					if (globalToggle) {
						globalToggle.classList.remove('is-active');
					}
				}
			} else if (dir === 1) {
				header.classList.remove('is-scrolled-down');
				prevDirection = dir;
			}
		};

		const checkScroll = () => {
			currentScroll =
				window.scrollY || document.documentElement.scrollTop;
			currentScroll = Math.max(0, Math.min(currentScroll, limit));

			const openMenuItemOnScroll = document.querySelector('.site-top-nav > .menu-item.has-submenu.is-active');
			if (openMenuItemOnScroll && prevScroll !== currentScroll) {
				openMenuItemOnScroll.classList.remove('is-active');
			}

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

	initMegaMenu();
	initGlobalDropdown();
});

function updateSubmenuTopPosition(subMenuElement, headerElement) {
	if (subMenuElement && headerElement) {
		const headerHeight = headerElement.getBoundingClientRect().height;
		subMenuElement.style.top = `${headerHeight}px`;
	}
}

function initMegaMenu() {
	const siteHeader = document.querySelector('.js-header');
	if (!siteHeader) return;

	const menuItemsWithSubmenu = document.querySelectorAll(
		'.site-top-nav > .menu-item.has-submenu',
	);

	if (!menuItemsWithSubmenu.length) {
		return;
	}

	menuItemsWithSubmenu.forEach((item) => {
		const triggerLink = item.querySelector('a');
		const subMenuWrap = item.querySelector('.sub-menu-wrap');

		if (!triggerLink || !subMenuWrap) {
			return;
		}

		triggerLink.addEventListener('click', (e) => {
			e.preventDefault();
			const isActive = item.classList.contains('is-active');

			if (!isActive) {
				const globalDropdown = document.querySelector('.js-global-dropdown');
				const globalToggle = document.querySelector('.js-global-toggle');
				if (globalDropdown && globalDropdown.classList.contains('is-active')) {
					globalDropdown.classList.remove('is-active');
					if (globalToggle) {
						globalToggle.classList.remove('is-active');
					}
				}
			}

			menuItemsWithSubmenu.forEach((otherItem) => {
				if (otherItem !== item && otherItem.classList.contains('is-active')) {
					otherItem.classList.remove('is-active');
				}
			});

			if (isActive) {
				item.classList.remove('is-active');
			} else {
				item.classList.add('is-active');
				updateSubmenuTopPosition(subMenuWrap, siteHeader);
				const firstFocusable = subMenuWrap.querySelector('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
				if (firstFocusable) {
					firstFocusable.focus();
				}
			}
		});

		const tabsNav = subMenuWrap.querySelector('.sub-menu-wrap__tabs-nav');
		if (tabsNav) {
			const tabButtons = tabsNav.querySelectorAll('.sub-menu-wrap__tab-btn');
			const tabPanels = subMenuWrap.querySelectorAll('.sub-menu-wrap__tab-panel');

			tabButtons.forEach((button) => {
				button.addEventListener('click', () => {
					if (button.classList.contains('is-active')) {
						return;
					}

					const tabIndex = button.getAttribute('data-tab');
					tabButtons.forEach((btn) => btn.classList.remove('is-active'));
					tabPanels.forEach((panel) => panel.classList.remove('is-active'));
					button.classList.add('is-active');
					const activePanel = subMenuWrap.querySelector(
						`.sub-menu-wrap__tab-panel[data-tab='${tabIndex}']`,
					);
					if (activePanel) {
						activePanel.classList.add('is-active');
					}
				});
			});
		}

		const focusableElements = Array.from(subMenuWrap.querySelectorAll(
			'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])',
		));
		const firstFocusableElement = focusableElements[0];
		const lastFocusableElement = focusableElements[focusableElements.length - 1];

		subMenuWrap.addEventListener('keydown', (e) => {
			if (e.key === 'Escape') {
				item.classList.remove('is-active');
				if (triggerLink) {
					triggerLink.focus();
				}
			}
			if (e.key === 'Tab') {
				if (e.shiftKey) {
					if (document.activeElement === firstFocusableElement) {
						e.preventDefault();
						lastFocusableElement.focus();
					}
				} else {
					if (document.activeElement === lastFocusableElement) {
						e.preventDefault();
						firstFocusableElement.focus();
					}
				}
			}
		});
	});

	document.addEventListener('click', (e) => {
		const openMenuItem = document.querySelector('.site-top-nav > .menu-item.has-submenu.is-active');

		if (openMenuItem) {
			if (!openMenuItem.contains(e.target)) {
				openMenuItem.classList.remove('is-active');
			}
		}
	});
}

function initGlobalDropdown() {
	const siteHeader = document.querySelector('.js-header');
	const globalToggle = document.querySelector('.js-global-toggle');
	const globalDropdown = document.querySelector('.js-global-dropdown');


	if (!siteHeader || !globalToggle || !globalDropdown) {
		return;
	}

	globalToggle.addEventListener('click', (e) => {
		e.preventDefault();


		const isHeaderScrolledDown = siteHeader.classList.contains('is-scrolled-down');


		if (!isHeaderScrolledDown) {
			const openMegaMenuItem = document.querySelector('.site-top-nav > .menu-item.has-submenu.is-active');
			if (openMegaMenuItem) {
				openMegaMenuItem.classList.remove('is-active');
			}


			const isActive = globalDropdown.classList.toggle('is-active');
			globalToggle.classList.toggle('is-active', isActive);


			if (isActive) {
				updateSubmenuTopPosition(globalDropdown, siteHeader);
				const firstFocusable = globalDropdown.querySelector('a, button');
				if (firstFocusable) {
					firstFocusable.focus();
				}
			}
		}
	});

	globalDropdown.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') {
			globalDropdown.classList.remove('is-active');
			globalToggle.classList.remove('is-active');
			globalToggle.focus();
		}
	});

	const dropdownLinks = Array.from(globalDropdown.querySelectorAll('.site-top__dropdown-list a'));
	dropdownLinks.forEach((link, index) => {
		link.addEventListener('keydown', (e) => {
			if (e.key === 'ArrowDown') {
				e.preventDefault();
				const nextLink = dropdownLinks[index + 1];
				if (nextLink) nextLink.focus();
				else dropdownLinks[0].focus();
			} else if (e.key === 'ArrowUp') {
				e.preventDefault();
				const prevLink = dropdownLinks[index - 1];
				if (prevLink) prevLink.focus();
				else dropdownLinks[dropdownLinks.length - 1].focus();
			}
		});
	});
}
