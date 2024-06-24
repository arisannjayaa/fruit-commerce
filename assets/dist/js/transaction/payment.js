const tableUrl = $('#table-url').val();
let table = $('#table');

$('input[name="dates"]').daterangepicker({
	timePicker: false,
	startDate: moment(),
	endDate: moment(),
	locale: {
		format: 'YYYY-MM-DD'
	}
});

$("#btn-filter").click(function () {
	reloadTable(table);
});

$("#table").DataTable({
	order: [[0, 'desc']],
	ordering: true,
	serverSide: true,
	processing: true,
	autoWidth: false,
	responsive: false,
	ajax: {
		url: tableUrl,
		data: function (d) {
			if($("#dates").val() != "") {
				let dates = $("#dates").val();
				dates = dates.split(" - ");
				d.date_start = dates[0];
				d.date_end = dates[1];
			}
		}
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

$("#table").on("click", ".detail", function () {
	let id = $(this).data("id");
	let url = $("#edit-url").val();
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		let html = '';
		let no = 1;
		let products = JSON.parse(res.data.products);
		console.log(res);
		$(".modal-title").empty().append("Detail Pemesanan");
		$("#invoice").html(res.data.order_id);
		$("#fullname").html(res.data.first_name);
		$("#email").html(res.data.email);
		$("#telephone").html(res.data.telephone);

		products.forEach(function (item) {
			html += `<tr>
						<td class="text-center">${no}</td>
						<td>
						<p class="strong mb-1">${item.title}</p>
						<div class="text-muted">${subStr(item.description, 50)}</div>
						</td>
						<td class="text-center">
						${item.quantity}
						</td>
						<td class="text-end">${formatRupiah(item.price, "IDR", false)}</td>
						<td class="text-end">${formatRupiah(item.price * item.quantity, "IDR", false)}</td>
					</tr>`
			no++;
		});

		let other = `<tr>
								<td colspan="4" class="strong text-end">Subtotal</td>
								<td class="text-end">${formatRupiah(res.data.gross_amount,"IDR", false)}</td>
							</tr>
							<tr>
								<td colspan="4" class="font-weight-bold text-uppercase text-end">Total</td>
								<td class="font-weight-bold text-end">${formatRupiah(res.data.gross_amount,"IDR", false)}</td>
							</tr>`
		html += other;
		$("#order-detail").html(html);
		$("#modal-order").modal("show");
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
