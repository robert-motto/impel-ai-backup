const scrollTracker = (trackItems, navHld) => {
	const scrollPosition = window.scrollY;

	trackItems.forEach(trackItem => {
		const trackItemTop = trackItem.offsetTop;
		if (scrollPosition >= trackItemTop && navHld) {
			const id = trackItem.getAttribute('id');
			const link = navHld.querySelector(`a[href="#${id}"]`);
			if (link) {
				link.classList.add('is-active');
			}
		} else if (navHld) {
			const id = trackItem.getAttribute('id');
			const link = navHld.querySelector(`a[href="#${id}"]`);
			if (link) {
				link.classList.remove('is-active');
			}
		}
	});
};

export default scrollTracker;
