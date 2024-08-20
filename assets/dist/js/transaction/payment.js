const tableUrl = $('#table-url').val();
let table = $('#table');

$('input[name="dates"]').daterangepicker({
	autoApply: true,
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
			if($("#status").val() != "") {
				let status = $("#status").val();
				d.status = status;
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
		{ data: 'payment_type', name: 'payment_type', className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				let paymentResponse = JSON.parse(row.capture_payment_response);
				return `<span>${paymentMethod(paymentResponse.payment_type)}</span>`;
			}
		},
		{ data: 'transaction_status', name: 'transaction_status', className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				let paymentResponse = JSON.parse(row.capture_payment_response);
				return `<span class="badge ${badgeStatusPayment(paymentResponse.transaction_status)}">${statusPayment(paymentResponse.transaction_status)}</span>`;
			}
		},
		{ data: 'delivery_status', name: 'delivery_status', className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				let html = `<select class="form-control change-delivery-status" data-id="${row.id}" ${checkTransactionStatus(row.transaction_status) == false ? 'disabled' : ''}>
										<option value="Menunggu Konfirmasi" ${row.delivery_status == "Menunggu Menunggu Konfirmasi" ? "selected" : ""}>Menunggu Konfirmasi</option>
										<option value="Menunggu Kurir" ${row.delivery_status == "Menunggu Kurir" ? "selected" : ""}>Menunggu Kurir</option>
										<option value="Dalam Pengiriman" ${row.delivery_status == "Dalam Pengiriman" ? "selected" : ""}>Dalam Pengiriman</option>
										<option value="Selesai" ${row.delivery_status == "Selesai" ? "selected" : ""}>Selesai</option>
									</select>`
				return html;
			}
		},
		{ data: null, className: 'text-nowrap', orderable: false, searchable: false,
			render: function (data, type, row, meta) {
				return `<a href="javascript:void(0)" data-id="${row.id}" class="btn btn-warning btn-sm detail">Detail</a>`;
			}
		}
	]
});

$("#table").on("change", ".change-delivery-status", function () {
	let id = $(this).data("id");
	let deliveryStatus = $(this).val();
	let url = BASE_URL + 'change/delivery/status';

	let formData = new FormData();
	formData.append('id', id);
	formData.append('delivery_status', deliveryStatus);

	ajaxPost(url, formData).done(function (res) {
		notifySuccess(res.message);
		reloadTable(table);
	});

})

$("#table").on("click", ".detail", function () {
	let id = $(this).data("id");
	let url = $("#detail-url").val();
	let gmapsUrl = "https://www.google.com/maps?q=";
	url = url.replace(":id", id);

	ajaxGet(url).done(function (res) {
		let html = '';
		let no = 1;
		let products = JSON.parse(res.data.products);
		let captureRequest = JSON.parse(res.data.capture_payment_request);
		let captureResponse = JSON.parse(res.data.capture_payment_response);

		$(".modal-title").empty().append("Detail Pemesanan");
		$("#location").attr('href', gmapsUrl + captureRequest.customer_details.latitude + "," + captureRequest.customer_details.longitude);
		$("#invoice").html(res.data.order_id);
		$("#fullname").html(res.data.first_name + ' ' + res.data.last_name);
		$("#email").html(res.data.email);
		$("#telephone").html(res.data.telephone);
		$("#address").html(captureRequest.customer_details.shipping_address.address);
		$("#state").html("Indonesia");
		$("#city").html(captureRequest.customer_details.shipping_address.city);
		$("#postal-code").html(captureRequest.customer_details.shipping_address.postal_code);
		$("#status").html(`<span
			class="badge ${badgeStatusPayment(captureResponse.transaction_status)}">${statusPayment(captureResponse.transaction_status)}</span>`);

		$("#btn-print").attr("href", BASE_URL + "invoice/" + res.data.order_id);
		products.forEach(function (item) {
			html += `<tr>
						<td class="text-center">${no}</td>
						<td>
						<p class="strong mb-1">${item.name}</p>
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
