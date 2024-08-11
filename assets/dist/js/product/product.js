const tableUrl = $('#table-url').val();
let table = $('#table');
$("#table").DataTable({
	order: [[0, 'desc']],
	ordering: true,
	serverSide: true,
	processing: true,
	autoWidth: false,
	responsive: false,
	ajax: {
		url: tableUrl
	},
	columns: [
		{data: null, render: function (data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}
		},
		{ data: 'title', name: 'title', className: 'text-nowrap', render: function (data, type, row, meta) {
				return `<div><img class="img-fluid me-3" width="50" src="${BASE_URL + row.attachment}" alt=""><span>${row.title}</span></div>`
			}},
		{ data: 'stock', name: 'stock', className: 'text-nowrap', orderable: false, searchable: false, render: function (data) {
				return `<span class="badge bg-success">${data}</span>`
			}},
		{ data: 'price', name: 'price', className: 'text-nowrap', orderable: false, searchable: false, render: function (data) {
				return `<span class="badge bg-primary">${formatRupiah(data, "IDR")}</span>`
			}},
		{ data: null, className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				return `<a href="javascript:void(0)" data-id="${row.id}" class="btn btn-warning btn-sm edit">Edit</a>
				<a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="${row.id}">Delete</a>`;
			}
		}
	]
});

$('#btn-add').click(function () {
	const defaultDescription = '<h2>Deskripsi produk</h2><p>Segar dan Sehat</p>';
	$('#attachment , .dropify-wrapper').remove();
	let html = `<input type="file" id="attachment" name="attachment" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png" data-default-file='' />`;
	$('.custom-file').append(html);
	$('.dropify').dropify();

	quill.setContents([]);
	$("#form-product")[0].reset();
	$("#modal-product").modal('show');

	$('.modal-title').empty().append('Tambah Produk');
	quill.root.innerHTML = defaultDescription;
});

resetValidationFile();

$("#form-product").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let description = quill.getSemanticHTML();
	let formData = new FormData(this);
	formData.append('description', description);
	formData.set('price', reverseFormatRupiah($("#price").val()));
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-product";
	let modal = "#modal-product";

	if (id !== "") {
		var url = $("#update-url").val();
	} else {
		var url = $("#create-url").val();
	}

	// send data
	ajaxPost(url, formData, btn).done(function (res) {
		snackbarSuccess(res.message);
		reloadTable(table);
		$(modal).modal("hide");
		$(form)[0].reset();

		if ($("#old-attachment").length) {
			$("#old-attachment").remove();
		}

	}).fail(function (res) {
		let data = res.responseJSON;
		let errorMessage = document.querySelectorAll('.text-left.invalid-feedback.order-3');
		errorMessage[0]?.remove();
		$(".dropify-error").empty().append(data.errors.attachment[0]);
		$(".dropify-wrapper").addClass("error");
		$(".dropify-error").show();
	});
});

$("#table").on("click", ".edit", function () {
	let id = $(this).data("id");
	let url = $("#edit-url").val();
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		$(".modal-title").empty().append("Edit Produk");
		$("#id").val(res.data.id);
		$("#title").val(res.data.title);
		$("#price").val(formatRupiah(res.data.price, "IDR"));
		$("#stock").val(res.data.stock);
		$("#category-id").val(res.data.category_id);
		$(".ql-editor").empty().append(res.data.description);

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

		$("#modal-product").modal("show");
	});
});


$("#table").on("click", ".delete", function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();
	let table = "#table";

	ajaxDel(url, id, false, 'snackbarSuccess', table);
});

$('#modal-product').on('hidden.bs.modal', function () {
	resetValidation();

	if ($("#old-attachment").length) {
		$("#old-attachment").remove();
	}
});
