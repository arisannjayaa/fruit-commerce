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
		{ data: 'name', name: 'name', className: 'text-nowrap'},
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
	$("#product-id").prop('disabled', false);
	$("#form-product-variant")[0].reset();
	$("#modal-product-variant").modal('show');

	$('.modal-title').empty().append('Tambah Varian Produk');
});

$("#form-product-variant").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
	formData.set('price', reverseFormatRupiah($("#price").val()));
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-product-variant";
	let modal = "#modal-product-variant";

	if (id !== "") {
		formData.append("product_id", $("#product-id").val());
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
	});
});

$("#table").on("click", ".edit", function () {
	let id = $(this).data("id");
	let url = $("#edit-url").val();
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		$(".modal-title").empty().append("Edit Varian Produk");
		$("#id").val(res.data.id);
		$("#name").val(res.data.name);
		$("#price").val(formatRupiah(res.data.price, "IDR"));
		$("#stock").val(res.data.stock);
		$("#product-id").val(res.data.product_id);
		$("#product-id").prop('disabled', true);

		$("#modal-product-variant").modal("show");
	});
});


$("#table").on("click", ".delete", function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();
	let table = "#table";

	ajaxDel(url, id, false, 'snackbarSuccess', table);
});

$('#modal-product-variant').on('hidden.bs.modal', function () {
	resetValidation();
});
