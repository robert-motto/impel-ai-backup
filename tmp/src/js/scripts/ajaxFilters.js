const filtersHld = document.querySelector('.js-filters-hld');
const filters = document.querySelectorAll('.js-filter-item');
const filtersBody = document.querySelector('.js-filter-body');
const filtersBodyToLoad = document.querySelector('.js-filter-body-to-load');

function getCoords(elem) { // crossbrowser version
	let box = elem.getBoundingClientRect();
	let body = document.body;
	let docEl = document.documentElement;
	let scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
	let scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
	let clientTop = docEl.clientTop || body.clientTop || 0;
	let clientLeft = docEl.clientLeft || body.clientLeft || 0;
	let top = box.top + scrollTop - clientTop;
	let left = box.left + scrollLeft - clientLeft;
	return { top: Math.round(top), left: Math.round(left) };
}

if (filtersHld && filtersBody && filtersBodyToLoad) {
	document.addEventListener('click', function(event) {
		const clickedElem = event.target;
		// Check if the event.target matches some selector, and do things...
		if (clickedElem.classList.contains('js-filter-item') || clickedElem.classList.contains('page-numbers')) {
			event.preventDefault();
			if (!clickedElem.classList.contains('is-active')) {
				const loadUrl = clickedElem.getAttribute('href');

				filters.forEach(filterSibling => {
					filterSibling.classList.remove('is-active');
				});
				clickedElem.classList.add('is-active');

				loadNewContent(loadUrl);

				const scrollOffset = clickedElem.classList.contains('page-numbers') ? 140 : 60;
				window.scrollTo({
					top: getCoords(filtersHld).top - scrollOffset,
					behavior: 'smooth',
				});
			}
		}

		if (clickedElem.classList.contains('js-order-select-option')) {
			event.preventDefault();
			let url = window.location.href;
			const orderBy = clickedElem.dataset.value;
			const params = new URLSearchParams(window.location.search);

			if (params.size === 0) {
				url = url + '?order_by=' + orderBy;
			} else {
				if (params.has('order_by')) {
					url = url.replace('order_by=' + params.get('order_by'), 'order_by=' + orderBy);
				} else {
					url = url + '&order_by=' + orderBy;
				}
			}
			loadNewContent(url);
		}
	}, false);

	document.addEventListener('submit', function(e) {
		const submitedForm = e.target;
		if (submitedForm.classList.contains('js-search')) {
			e.preventDefault();
			const url = window.location.href;
			const searchPhrase = submitedForm.querySelector('.js-search-input').value;
			const params = new URLSearchParams(window.location.search);
			let searchUrl = url;

			if (searchPhrase !== '') {
				if (params.size === 0) {
					searchUrl = url + '?search=' + searchPhrase;
				} else {
					if (params.has('search')) {
						searchUrl = searchUrl.replace('search=' + params.get('search'), 'search=' + searchPhrase);
					} else {
						searchUrl = url + '&search=' + searchPhrase;
					}
				}
			} else {
				searchUrl = searchUrl.replace('?search=' + params.get('search'), '');
				searchUrl = searchUrl.replace('&search=' + params.get('search'), '');
			}

			loadNewContent(searchUrl);
		}
	});
}

function loadNewContent(loadUrl) {
	filtersBody.classList.add('is-loading');
	let xhr = new XMLHttpRequest();
	xhr.onload = function() {
		if (xhr.status >= 200 && xhr.status < 300) {
			// This will run when the request is successful
			const parser = new DOMParser();
			const loadedContent = parser.parseFromString(xhr.responseText, 'text/html');
			const loadedContentUpdate = loadedContent.querySelector('.js-filter-body-to-load');
			filtersBodyToLoad.innerHTML = loadedContentUpdate.innerHTML;
		} else {
			// This will run when it's not
			console.log('The request failed.');
		}

		filtersBody.classList.remove('is-loading');

		if (history.pushState) {
			history.pushState({}, '', loadUrl);
		}
	};

	xhr.open('GET', loadUrl);
	xhr.send();
}
