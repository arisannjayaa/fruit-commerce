const expiry = $("#expiry-date").val();
let intervalId;

fetchTotalCart();

setTimeout(() => {
	$("#title").html('Pembayaran Harus Selesai Dalam');
},1000);

startInterval();

function startInterval() {
	intervalId = setInterval(function() {
		countDown(expiry);
		checkProduct();
	}, 1000);
}

function checkProduct() {
	let id = $("#order-id").val();
	let url = BASE_URL + 'transaction/check/cancel';
	let formData = new FormData();
	formData.append('order_id', id);

	$.ajax({
		type: 'POST',
		data: formData,
		url: url,
		dataType: 'json',
		contentType: false,
		processData: false,
		success: function(res) {
			if (res.code == 200) {
				$("#title").html('Pesanan Dibatalkan, Stok Produk Habis');
				clearInterval(intervalId);

				setTimeout(function () {
					location.href = '';
				}, 3000);
			}
		},
	});
}

function fetchTotalCart() {
	let countCart = 0;
	let url = BASE_URL + 'all-cart';

	ajaxGet(url).done(function (res) {
		let data = res.data;
		countCart = data.length;
		$(".cart-count").html(countCart);
	});
}
