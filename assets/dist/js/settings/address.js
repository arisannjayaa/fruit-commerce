$('#btn-add').click(function () {
	$("#modal-address").modal('show');

	$('.modal-title').empty().append('Tambah Alamat');
});

$("#form-address").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-address";
	let modal = "#modal-address";

	if (id !== "") {
		var url = $("#update-url").val();
	} else {
		var url = $("#create-url").val();
	}

	// send data
	ajaxPost(url, formData, btn).done(function (res) {
		notifySuccess(res.message);
		$(modal).modal("hide");
		$(form)[0].reset();
	});
});
