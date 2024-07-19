$("#form-profile").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-profile";
	let modal = "#modal-profile";

	var url = $("#update-url").val();

	// send data
	ajaxPost(url, formData, btn).done(function (res) {
		snackbarSuccess(res.message);
		$(modal).modal("hide");
		$(form)[0].reset();

		if ($("#old-attachment").length) {
			$("#old-attachment").remove();
		}

		location.href = '';

	}).fail(function (res) {
		let data = res.responseJSON;
		let errorMessage = document.querySelectorAll('.text-left.invalid-feedback.order-3');
		errorMessage[0]?.remove();
		$(".dropify-error").empty().append(data.errors.attachment[0]);
		$(".dropify-wrapper").addClass("error");
		$(".dropify-error").show();
	});
});

$(document).on("click", ".edit", function () {
	let id = $(this).data("id");
	let url = $("#edit-url").val();
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		console.log(res);
		$(".modal-title").empty().append("Edit Biodata");
		$("#id").val(res.data.id);
		$("#first-name").val(res.data.first_name);
		$("#last-name").val(res.data.last_name);
		$("#email").val(res.data.email);
		$("#telephone").val(res.data.telephone);

		$('#attachment , .dropify-wrapper').remove();

		let html = `<input type="text" id="attachment" name="attachment" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png" value="${res.data.attachment}" data-default-file='${BASE_URL + res.data.attachment}' />
			<input type="hidden" name="old_attachment" id="old-attachment" value="${res.data.attachment}">`;
		$('.custom-file').append(html);
		$('.dropify').dropify();

		$(".dropify-clear").click(function () {
			$(".dropify-wrapper").remove();
			let html = `<input type="file" id="attachment" name="attachment" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png" value="" data-default-file='' />`;
			$('.custom-file').append(html);
			$('.dropify').dropify();
		})

		$("#modal-profile").modal("show");
	});
});

$('#modal-profile').on('hidden.bs.modal', function () {
	resetValidation();

	if ($("#old-attachment").length) {
		$("#old-attachment").remove();
	}
});
