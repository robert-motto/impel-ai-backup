(() => {
	const body = document.querySelector('body');
	const mobileNav = document.querySelector('.js-mobile-nav');
	const mobileNavToggle = document.querySelectorAll('.js-mobile-nav-toggle');
	const mobileNavClose = document.querySelectorAll('.js-mobile-nav-close');
	if (!mobileNav) {
		return;
	}
	const closeMobileNav = () => {
		body.classList.remove('is-mobile-open');
		mobileNav.classList.remove('is-active');
	};
	const openMobileNav = () => {
		body.classList.add('is-mobile-open');
		mobileNav.classList.add('is-active');
	};
	if (mobileNavToggle && mobileNavToggle.length > 0) {
		mobileNavToggle.forEach(button => {
			button.addEventListener('click', () => {
				if (mobileNav.classList.contains('is-active')) {
					closeMobileNav();
				} else {
					openMobileNav();
				}
			});
		});
	}
	if (mobileNavClose && mobileNavClose.length > 0) {
		mobileNavClose.forEach(button => {
			button.addEventListener('click', () => {
				closeMobileNav();
			});
		});
	}
	const mobileNavParents = document.querySelectorAll('.js-mobile-nav-parent');
	if (mobileNavParents && mobileNavParents.length > 0) {
		mobileNavParents.forEach(parent => {
			parent.addEventListener('click', () => {
				const item = parent.parentElement;
				const isCurrentlyActive = item.classList.contains('is-active');

				// Close all other mobile nav items
				mobileNavParents.forEach(otherParent => {
					const otherItem = otherParent.parentElement;
					otherItem.classList.remove('is-active');
				});

				// Toggle the clicked item (if it wasn't active, make it active)
				if (!isCurrentlyActive) {
					item.classList.add('is-active');

					// Scroll the clicked item to the top of the viewport
					setTimeout(() => {
						item.scrollIntoView({
							behavior: 'smooth',
							block: 'start',
						});
					}, 100);
				}
			});
		});
	}
	document.addEventListener('click', (e) => {
		const target = e.target;
		if (target.classList.contains('js-close-sub-menu')) {
			const subMenu = target.parentNode('.sub-menu-wrap');
			if (subMenu) {
				subMenu.classList.remove('is-active');
			}
		}
	});
	window.addEventListener('resize', () => {
		if (window.innerWidth > 1280) {
			closeMobileNav();
		}
	});
})();
