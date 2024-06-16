const tableUrl = $('#table-url').val();
let table = $('#table');

$('input[name="daterange"]').daterangepicker();

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
		{data: null, orderable: false, searchable: false, render: function (data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}
		},
		{ data: 'order_id', name: 'order_id', className: 'text-nowrap'},
		{ data: 'gross_amount', name: 'gross_amount', className: 'text-nowrap', orderable: false, searchable: false, render: function (data) {
				return `<span class="badge bg-success">${formatRupiah(data, "IDR", false)}</span>`
		}},
		{ data: 'payment_type', name: 'payment_type', className: 'text-nowrap', orderable: false, searchable: false},
		{ data: null, className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				return `<a href="javascript:void(0)" data-id="${row.id}" class="btn btn-warning btn-sm detail">Detail</a>`;
			}
		}
	]
});

$('#btn-add').click(function () {
	$("#form-category")[0].reset();
	$("#modal-category").modal('show');

	$('.modal-title').empty().append('Tambah Kategori');
});

$("#form-category").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-category";
	let modal = "#modal-category";

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
		$(".modal-title").empty().append("Edit Kategori");
		$("#id").val(res.data.id);
		$("#name").val(res.data.name);
		$("#modal-category").modal("show");
	});
});


$("#table").on("click", ".delete", function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();
	let table = "#table";

	ajaxDel(url, id, false, 'notifySuccess', table);
});

$('#modal-category').on('hidden.bs.modal', function () {
	resetValidation();
});
