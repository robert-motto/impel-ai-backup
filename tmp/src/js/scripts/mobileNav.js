window.addEventListener('load', () => {
	const body = document.querySelector('body');
	const mobileNav = document.querySelector('.js-mobile-nav');
	const mobileNavToggle = document.querySelectorAll('.js-mobile-nav-toggle');
	const mobileNavClose = document.querySelectorAll('.js-mobile-nav-close');

	const closeMobileNav = () => {
		body.classList.remove('is-mobile-open');
		mobileNav.classList.remove('is-active');
	};

	const openMobileNav = () => {
		body.classList.add('is-mobile-open');
		mobileNav.classList.add('is-active');
	};

	if (mobileNavToggle) {
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

	if (mobileNavClose) {
		mobileNavClose.forEach(button => {
			button.addEventListener('click', () => {
				closeMobileNav();
			});
		});
	}

	const mobileNavParents = document.querySelectorAll('.mobile-nav .menu-item:has(.sub-menu-wrap)');
	if (mobileNavParents) {
		mobileNavParents.forEach(parent => {
			parent.addEventListener('click', () => {
				const subMenu = parent.querySelector('.sub-menu-wrap');
				subMenu.classList.toggle('is-active');
			});
		});
	}
	document.addEventListener('click', (e) => {
		const target = e.target;
		if (target.classList.contains('js-close-sub-menu')) {
			const subMenu = target.parentNode('.sub-menu-wrap');
			subMenu.classList.remove('is-active');
		}
	});

	window.addEventListener('resize', () => {
		if (window.innerWidth > 1280) {
			closeMobileNav();
		}
	});
});
