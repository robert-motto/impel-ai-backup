const gFormHldAll = document.querySelectorAll('.gform_wrapper');

const formScripts = function(forms) {
	forms.forEach(form => {
		const formInputs = form.querySelectorAll('input[type="text"], input[type="text"], input[type="email"], input[type="number"], input[type="password"]');
		if (formInputs) {
			formInputs.forEach(item => {
				const parent = item.closest('.gfield');
				if (item.value !== '') {
					parent.classList.add('is-not-empty');
				} else {
					parent.classList.remove('is-not-empty');
				}
				item.addEventListener('input', () => {
					if (item.value !== '') {
						parent.classList.add('is-not-empty');
					} else {
						parent.classList.remove('is-not-empty');
					}
				});
			});
		}

		const formSelects = form.querySelectorAll('select');
		if (formSelects) {
			formSelects.forEach(item => {
				const parent = item.closest('.gfield');
				parent.classList.add('gfield--with-select');
				if (item.value !== '') {
					parent.classList.add('is-not-empty');
				} else {
					parent.classList.remove('is-not-empty');
				}
				item.addEventListener('change', () => {
					if (item.value !== '') {
						parent.classList.add('is-not-empty');
					} else {
						parent.classList.remove('is-not-empty');
					}
				});
			});
		}

		const formTextareas = form.querySelectorAll('textarea');
		if (formTextareas) {
			formTextareas.forEach(item => {
				const parent = item.closest('.gfield');
				parent.classList.add('gfield--with-textarea');
				if (item.value !== '') {
					parent.classList.add('is-not-empty');
				} else {
					parent.classList.remove('is-not-empty');
				}

				if (item.classList.contains('small')) {
					item.setAttribute('rows', '1');
					item.setAttribute('style', 'height:' + (item.scrollHeight) + 'px;');
					item.addEventListener('input', (event) => {
						if (item.value !== '') {
							parent.classList.add('is-not-empty');
						} else {
							parent.classList.remove('is-not-empty');
						}

						event.target.style.height = 'auto';
						event.target.style.height = (event.target.scrollHeight) + 'px';
						if (event.target.offsetHeight >= 185) {
							event.target.classList.add('is-scrollable');
						} else {
							event.target.classList.remove('is-scrollable');
						}
					});
				}
			});
		}

		form.classList.remove('is-loading');

		form.addEventListener('submit', () => {
			form.classList.add('is-loading');
		});

		// const uploadsInput = form.querySelectorAll('input[type="file"]');
		// if (uploadsInput) {
		//     uploadsInput.forEach(item => {
		//         const parent = item.closest('.gfield');
		//         if (parent) {
		//             parent.classList.add('is-file-upload');
		//         }
		//     });
		// }

		// const checkboxStyle = form.querySelectorAll('.ginput_container_checkbox');
		// if (checkboxStyle) {
		//     checkboxStyle.forEach(item => {
		//         const parent = item.closest('.gfield');
		//         if (parent) {
		//             parent.classList.add('is-checkboxes');
		//         }
		//     });
		// }

		// const radioStyle = form.querySelectorAll('.ginput_container_radio');
		// if (radioStyle) {
		//     radioStyle.forEach(item => {
		//         const parent = item.closest('.gfield');
		//         if (parent) {
		//             parent.classList.add('is-radiobutton');
		//         }
		//     });
		// }

		// const fileInputs = form.querySelectorAll('.gform_fields input[type="file"]');

		// if (fileInputs) {
		//     fileInputs.forEach((input, index) => {
		//         input.classList.add('is-input-upload');
		//     });
		// }

		// setTimeout(function() {
		//     const fileInputsHld = form.querySelectorAll('.gform_fields .is-file-upload');
		//     if (fileInputsHld) {
		//         fileInputsHld.forEach((fileInputDiv) => {
		//             fileInputDiv.insertAdjacentHTML('beforeend', '<div class="is-upload-file-name"></div>');
		//         });
		//     }
		// }, 100);


		// if (fileInputs) {
		//     fileInputs.forEach((input, index) => {
		//         input.addEventListener('change', (event) => {
		//             const myListParent = input.parentNode.nextElementSibling;
		//             // console.log(fileInputs[index].files[0]);
		//             myListParent.innerHTML = `
		//                 ${fileInputs[index].files[0] ? `<span data-input-name="fileUpload">${fileInputs[index].files[0].name}<span class="close"><span class="icon icon-close1"></span></span></span>` : ''}
		//             `;
		//         });
		//     });
		// }

		// const multiselect = form.querySelectorAll('.gform_fields .ginput_container_multiselect');
		// if (multiselect) {
		//     multiselect.forEach((multi) => {
		//         const options = multi.querySelectorAll('select option');
		//         options.forEach((option) => {
		//             option.addEventListener('click', () => {
		//                 // option.classList.toggle('selected');
		//                 option.setAttribute('selected', 'selected');
		//             });
		//         });
		//     });
		// }
	});
};

if (gFormHldAll) {
	/* eslint-disable */
	jQuery(document).on('gform_post_render', function (event, form_id) { // reinits form scripts each time form is rendered (ajax)
		formScripts(gFormHldAll);
	});
	/* eslint-enable */
}
