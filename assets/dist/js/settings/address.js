let totalRows = $("#total-rows").val();
checkRows(totalRows);

$('#btn-add').click(function () {
	if (totalRows == 5) {
		sweetError('Tidak dapat menyimpan data alamat lebih dari 5');
		return;
	}

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
		setTimeout(() => {
			location.reload();
		}, 1500);
	});
});

$(".edit").click(function () {
	let id = $(this).data("id");
	let url = $("#edit-url").val();
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		$(".modal-title").empty().append("Edit Alamat");
		$("#id").val(res.data.id);
		$("#addressee").val(res.data.addressee);
		$("#telephone").val(res.data.telephone);
		$("#label").val(res.data.label);
		$("#address").val(res.data.address);
		$("#postal_code").val(res.data.postal_code);

		if (res.data.is_primary == 1) {
			$("#check-is-primary").hide();
			$('#is-primary').attr('checked', 'checked');
		} else {
			$("#check-is-primary").show();
			$('#is-primary').removeAttr('checked');
		}

		$("#modal-address").modal("show");
	});
});

$(".delete").click(function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();

	Swal.fire({
		title: 'Apakah anda yakin ingin menghapus data ini?',
		text: 'Data tidak dapat dipulihkan!',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#c82333',
		confirmButtonText: 'Hapus',
		cancelButtonText: 'Batal',
	}).then((result) => {
		console.log(result);
		if (result.value) {
			$.ajax({
				type: 'POST',
				url: url,
				data: {'id': id},
				dataType: 'json',
				success: function (res) {
					if (res.success == true) {
						notifySuccess(res.message);
						setTimeout(function () {
							location.reload();
						}, 1500);
					} else {
						new sweetError(res.message);
					}
				},
				error: function (res) {
					new sweetError('There is an error');
				}
			});
		}
	});
});

$(".set-primary").click(function () {
	let id = $(this).data("id");
	let url = $("#set-primary-url").val();

	Swal.fire({
		title: 'Apakah anda yakin?',
		text: 'Ini akan menjadikan sebagai alamat utama anda',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#82ae46',
		confirmButtonText: 'Jadikan Alamat Utama',
		cancelButtonText: 'Batal',
	}).then((result) => {
		console.log(result);
		if (result.value) {
			$.ajax({
				type: 'POST',
				url: url,
				data: {'id': id},
				dataType: 'json',
				success: function (res) {
					if (res.success == true) {
						setTimeout(function () {
							location.reload();
						}, 500);
					} else {
						new sweetError(res.message);
					}
				},
				error: function (res) {
					new sweetError('There is an error');
				}
			});
		}
	});
});

function checkRows(total) {
	if (total == 0) {
		$("#check-is-primary").hide();
		return;
	}

	$("#check-is-primary").show();
}
