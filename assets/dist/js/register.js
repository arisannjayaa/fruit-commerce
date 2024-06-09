$('#form-register').submit(function (e) {
	e.preventDefault();

	let url = $('#register-url').val();
	let formData = new FormData(this);
	let btn = '#btn-register';

	new ajaxPost(url, formData, btn, 'snackbarError')
		.done(function (res) {
			snackbar(res.message);

			setTimeout(function () {
				location.href = res.redirect;
			},1300);
		});
});
