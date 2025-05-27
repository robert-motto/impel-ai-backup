window.addEventListener('click', (e) => {
	const target = e.target;

	if (!target.classList.contains('select')) {
		const selects = document.querySelectorAll('.select');
		selects.forEach(select => {
			const checkbox = select.querySelector('input[type="checkbox"]');
			if (checkbox.checked) {
				checkbox.click();
			}
		});
	}
});

