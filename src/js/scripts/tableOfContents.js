import  scrollTracker  from './scrollTracker';

const tableOfContents = document.querySelector('.js-table-of-contents');
const contentScope = document.querySelector('.js-table-of-contents-scope');

// Find all headings in the content scope
const headings = contentScope.querySelectorAll('h2, h3, h4, h5, h6');
const iframes = contentScope.querySelectorAll('iframe');

// If there are headings, build the table of contents
if (headings.length) {
	tableOfContents.classList.add('active');

	// Create a list of links for each heading
	const list = document.createElement('ul');
	list.classList.add('table-of-contents__list');

	// Loop through each heading
	headings.forEach(heading => {
		//Create id base od header content
		const id = `${heading.textContent.toLowerCase().replace(/\s/g, '-')}`;
		heading.setAttribute('id', id);
		// Create a list item
		const item = document.createElement('li');
		item.classList.add('table-of-contents__item');

		// Create a link
		const link = document.createElement('a');
		link.classList.add('table-of-contents__link');
		link.setAttribute('href', `#${id}`);
		link.textContent = heading.textContent;

		link.addEventListener('click', e => {
			e.preventDefault();
			window.scrollTo({ top: heading.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
		});

		// Add link to list item
		item.appendChild(link);

		// Add list item to list
		list.appendChild(item);
	});

	tableOfContents.appendChild(list);

	document.addEventListener('scroll', () => {
		scrollTracker(headings, document.querySelector('.table-of-contents__list'));
	});
}

if (iframes.length) {
	iframes.forEach(iframe => {
		iframe.style.aspectRatio = `${iframe.getAttribute('width')}/${iframe.getAttribute('height')}`;
	});
}
