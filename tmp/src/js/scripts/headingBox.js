(function() {
	const headingBoxes = document.querySelectorAll('.js-heading-box');

	if (!headingBoxes.length) {
		return;
	}

	headingBoxes.forEach(function(box) {
		if (box.classList.contains('heading-box--left')) {
			const parentSection = box.closest('.js-section');
			if (parentSection) {
				parentSection.classList.add('has-heading-box-left');
			}
		}
	});
})();

