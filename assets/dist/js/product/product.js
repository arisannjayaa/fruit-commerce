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
		{ data: 'title', name: 'title', className: 'text-nowrap'},
		{ data: 'stock', name: 'stock', className: 'text-nowrap'},
		{ data: 'normal_price', name: 'normal_price', className: 'text-nowrap'},
		{ data: 'promotion_price', name: 'promotion_price', className: 'text-nowrap'},
		{ data: null, className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				return `<a href="javascript:void(0)" data-id="${row.id}" class="btn btn-warning btn-sm edit">Edit</a>
				<a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="${row.id}">Delete</a>`;
			}
		}
	]
});

$('#btn-add').click(function () {
	$("#form-product")[0].reset();
	$("#modal-product").modal('show');

	$('.modal-title').empty().append('Tambah Produk');
});

$("#form-product").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
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
		notifySuccess(res.message);
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
		$(".modal-title").empty().append("Edit Produk");
		$("#id").val(res.data.id);
		$("#title").val(res.data.title);
		$("#modal-product").modal("show");
	});
});


$("#table").on("click", ".delete", function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();
	let table = "#table";

	ajaxDel(url, id, false, 'notifySuccess', table);
});

$('#modal-product').on('hidden.bs.modal', function () {
	resetValidation();
});
