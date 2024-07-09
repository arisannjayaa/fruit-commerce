fetchTotalCart();
$(document).on('click', '.detail', function () {
	let id = $(this).data("id");
	let url = $("#detail-url").val();
	url = url.replace(":id", id);

	$.ajax({
		url: url,
		method: "GET",
		success: function(res) {
			let response = JSON.parse(res);
			let products = JSON.parse(response.data.products);
			let captureResponse = JSON.parse(response.data.capture_payment_response);
			let html = '';
			let htmlOption = '';

			$(".modal-title").empty().append("Detail Transaksi");
			$("#invoice-id").html(response.data.order_id);
			$("#status").html(statusPayment(captureResponse.transaction_status));
			$("#payment-type").html(paymentMethod(response.data.payment_type));
			$("#date-transaction").html(convertDate(response.data.created_at));
			$("#gross-amount").html(formatRupiah(response.data.gross_amount,"IDR", false));
			$("#total-shop").html(formatRupiah(response.data.gross_amount,"IDR", false));

			let htmlFirst = `<div class="card mb-2">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<div class="d-flex" style="gap: 10px">
									<img height="50" width="50" style="object-fit: cover; border-radius: 7px" src="${products[0].attachment != null ? BASE_URL + products[0].attachment : BASE_URL + 'assets/home/images/image_5.jpg'}" alt="">
									<div>
										<span class="d-block" href="javascript:void(0)">${products[0].name}</span>
										<span class="d-block">${products[0].quantity + ' x ' + formatRupiah(products[0].price, "IDR", false)}</span>
									</div>
								</div>
								<div class="d-flex flex-column align-items-lg-end align-items-start">
									<span>Total Harga</span>
									<span>${formatRupiah(products[0].price * products[0].quantity,"IDR", false)}</span>
								</div>
							</div>
						</div>
					</div>`;

			$(".first-product").html(htmlFirst);
			products.shift();

			products.forEach(function (item) {
				let attachment = item.attachment != null ? BASE_URL + item.attachment : BASE_URL + 'assets/home/images/image_5.jpg';
				html += `<div class="card mb-2">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<div class="d-flex" style="gap: 10px">
									<img height="50" width="50" style="object-fit: cover; border-radius: 7px" src="${attachment}" alt="">
									<div>
										<span href="javascript:void(0)" class="d-block">${item.name}</span>
										<span class="d-block">${item.quantity + ' x ' + formatRupiah(item.price, "IDR", false)}</span>
									</div>
								</div>
								<div class="d-flex flex-column align-items-lg-end align-items-start">
									<span>Total Harga</span>
									<span>${formatRupiah(item.price * item.quantity,"IDR", false)}</span>
								</div>
							</div>
						</div>
					</div>`;
			});

			if (captureResponse.transaction_status) {
				htmlOption += `<div class="col-12"><button onclick="location.href='${BASE_URL + 'payment/' + response.data.order_id}'" type="button" class="btn btn-primary">Lihat Detail Transaksi</button></div>`;

				if (captureResponse.transaction_status == "pending") {
					htmlOption += `<div class="col-12"><button type="button" class="btn btn-danger">Batalkan</button></div>`;
				}

				$("#option").html(htmlOption);
			}

			$("#collapse-product").html(html);

			if (products.length > 0) {
				let collapseBtn = `<a role="button" style="cursor:pointer;" aria-expanded="false" aria-controls="collapseExample" id="btn-collapse-product">
					Lihat semua produk
					</a>`
				$("#collapse-container").html(collapseBtn);
			}


			$("#modal-transaction").modal("show");

			$("#btn-collapse-product").click(function () {
				$("#collapse-product").toggle();
			});
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$("#result").html("Terjadi kesalahan: " + textStatus);
		}
	});
});

$('#modal-transaction').on('hidden.bs.modal', function (event) {
	$("#collapse-product").empty();
	$("#collapse-container").empty();
});

fetchTotalCart();

function fetchTotalCart() {
	let countCart = 0;

	$.ajax({
		url: BASE_URL + 'all-cart',
		method: "GET",
		success: function(res) {
			let response = JSON.parse(res);
			let data = response.data;
			countCart = data.length;
			$(".cart-count").html(countCart);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert('Server error');
		}
	});
}
