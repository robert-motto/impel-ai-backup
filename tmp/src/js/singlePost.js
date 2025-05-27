// SCRIPTS
const tableOfContents = document.querySelector('.js-table-of-contents');

if (tableOfContents) {
	import('./scripts/tableOfContents').then(module => {
		module;
	});
}
