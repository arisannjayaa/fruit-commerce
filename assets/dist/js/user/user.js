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
		{ data: 'username', name: 'username', className: 'text-nowrap'},
		{ data: 'email', name: 'email', className: 'text-nowrap', orderable: false, searchable: true },
		{ data: 'role_id', name: 'role_id', className: 'text-nowrap', orderable: false, searchable: true },
		{ data: null, className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				return `<a href="javascript:void(0)" data-id="${row.id}" class="btn btn-warning btn-sm edit">Edit</a>
				<a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="${row.id}">Delete</a>`;
			}
		}
	]
});

$('#btn-add').click(function () {
	$("#form-user")[0].reset();
	$("#modal-user").modal('show');

	$('.modal-title').empty().append('Tambah User');
});

$("#form-user").submit(function (e) {
	e.preventDefault();

	let id = $("#id").val();
	let formData = new FormData(this);
	let btn = "#btn-submit";
	let table = "#table";
	let form = "#form-user";
	let modal = "#modal-user";

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
		$(".modal-title").empty().append("Edit User");
		$("#id").val(res.data.id);
		$("#username").val(res.data.username);
		$("#email").val(res.data.email);
		$("#modal-user").modal("show");
	});
});


$("#table").on("click", ".delete", function () {
	let id = $(this).data("id");
	let url = $("#delete-url").val();
	let table = "#table";

	ajaxDel(url, id, false, 'notifySuccess', table);
});

$('#modal-user').on('hidden.bs.modal', function () {
	resetValidation();
});
