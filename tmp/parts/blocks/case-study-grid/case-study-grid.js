const SELECTORS = {
	SECTION: '.js-case-study-grid',
	LOAD_MORE_BUTTON: '.js-case-study-load-more',
	ITEMS_CONTAINER: '.js-case-study-grid-items',
	HIDDEN_ITEM: '.case-study-grid__item--hidden',
	VISIBLE_ITEM: '.case-study-grid__item:not(.case-study-grid__item--hidden)',
};

const BREAKPOINTS = {
	MOBILE: 768,
	TABLET: 1024,
};

const RESIZE_DELAY = 250;
const DEFAULT_ITEMS_PER_LOAD = 6;

function initCaseStudyGrid() {
	const caseStudySections = document.querySelectorAll(SELECTORS.SECTION);

	if (!caseStudySections.length) {
		return;
	}

	caseStudySections.forEach((section) => {
		const loadMoreButton = section.querySelector(SELECTORS.LOAD_MORE_BUTTON);
		const itemsContainer = section.querySelector(SELECTORS.ITEMS_CONTAINER);

		if (!loadMoreButton || !itemsContainer) {
			return;
		}

		loadMoreButton.addEventListener('click', () => {
			handleLoadMore(section, loadMoreButton);
		});
	});
}

function handleLoadMore(section, button) {
	const totalItems = parseInt(button.dataset.total, 10);
	let shownItems = parseInt(button.dataset.shown, 10);
	const itemsPerLoad = parseInt(section.dataset.itemsPerLoad, 10) || DEFAULT_ITEMS_PER_LOAD;

	const hiddenItems = Array.from(section.querySelectorAll(SELECTORS.HIDDEN_ITEM));

	if (!hiddenItems.length) {
		button.style.display = 'none';
		return;
	}

	const columnsPerRow = getColumnsPerRow();
	const rowsToAdd = Math.ceil(itemsPerLoad / columnsPerRow);
	const itemsToShow = Math.min(rowsToAdd * columnsPerRow, hiddenItems.length);

	for (let i = 0; i < itemsToShow; i++) {
		hiddenItems[i].classList.remove(SELECTORS.HIDDEN_ITEM.substring(1));
	}

	shownItems += itemsToShow;
	button.dataset.shown = shownItems;

	if (shownItems >= totalItems || hiddenItems.length <= itemsToShow) {
		button.style.display = 'none';
	}
}

function getColumnsPerRow() {
	const windowWidth = window.innerWidth;

	if (windowWidth < BREAKPOINTS.MOBILE) {
		return 1;
	} else if (windowWidth < BREAKPOINTS.TABLET) {
		return 2;
	}
	return 3;
}

initCaseStudyGrid();

let resizeTimer;
window.addEventListener('resize', () => {
	clearTimeout(resizeTimer);
	resizeTimer = setTimeout(() => {
		const loadMoreButtons = document.querySelectorAll(SELECTORS.LOAD_MORE_BUTTON);
		loadMoreButtons.forEach((button) => {
			const section = button.closest(SELECTORS.SECTION);
			const visibleItems = section.querySelectorAll(SELECTORS.VISIBLE_ITEM);
			button.dataset.shown = visibleItems.length;
		});
	}, RESIZE_DELAY);
});
