document.addEventListener('DOMContentLoaded', function() {
	initGeneralForm();
});

function initGeneralForm() {
	const forms = document.querySelectorAll('.js-general-form');
	if (!forms.length) return;

	forms.forEach(form => {
		// Add any custom JS functionality needed for the form
		// For example, adding custom validation, focus states, etc.
		const formInputs = form.querySelectorAll('input, textarea, select');

		if (formInputs.length) {
			formInputs.forEach(input => {
				// Add focus/blur events for better UX
				input.addEventListener('focus', function() {
					this.closest('.gfield').classList.add('is-focused');
				});

				input.addEventListener('blur', function() {
					this.closest('.gfield').classList.remove('is-focused');
					if (this.value) {
						this.closest('.gfield').classList.add('has-value');
					} else {
						this.closest('.gfield').classList.remove('has-value');
					}
				});
			});
		}
	});
}
