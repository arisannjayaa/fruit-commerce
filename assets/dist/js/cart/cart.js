let allCartItemUrl = $("#all-cart-item-url").val();
let userId = $("#user-id").val();
fetchCart();

$(document).on('click', '.product-remove', function () {
	let id = $(this).data("id");
	let url = $("#delete-item-cart-url").val();
	ajaxDelCustom(url, id, false, "snackbarSuccess");
});

$(document).on("click", ".btn-increase", function () {
	let inputElement = $(this).closest("#product").find("input[type='number']");
	let currentValue = parseInt(inputElement.val());
	let newValue = currentValue + 1;
	let maxValue = parseInt(inputElement.prop("max"));
	let id = $(this).data("id");
	newValue = newValue <= maxValue ? newValue : maxValue;
	inputElement.val(newValue);
	updateQuantity(id, newValue);
	let priceElement = $(this).closest("#product").find(".price")[0];
	let InputTotalElement = $(this).closest("#product").find("#total")[0];
	let priceTotal = priceElement.getAttribute("data-price");
	let subTotal = newValue * parseInt(priceTotal);
	InputTotalElement.value = subTotal
	$(".total-price").html(formatRupiah(totalCount(), "IDR", false));
	$("#total-price").val(totalCount());
});



$(document).on("click", ".btn-decrease", function () {
	let inputElement = $(this).closest("#product").find("input[type='number']");
	let currentValue = parseInt(inputElement.val());
	let newValue = currentValue - 1;
	let id = $(this).data("id");
	newValue = newValue < 1 ? 1 : newValue;
	inputElement.val(newValue);
	updateQuantity(id, newValue);
	let priceElement = $(this).closest("#product").find(".price")[0];
	let InputTotalElement = $(this).closest("#product").find("#total")[0];
	let priceTotal = priceElement.getAttribute("data-price");
	let subTotal = newValue * parseInt(priceTotal);
	InputTotalElement.value = subTotal
	$(".total-price").html(formatRupiah(totalCount(), "IDR", false));
	$("#total-price").val(totalCount());
});

$(".item-product").on('click', '.add-cart', function (){
	let productId = $(this).data("id");
	let formData = new FormData();
	let url = $("#create-url").val()
	formData.append("product_id", productId)
	formData.append("user_id", userId)
	formData.append("quantity", 1);
	ajaxPost(url, formData).done(function (res) {
		fetchTotalCart()
		snackbarSuccess(res.message);
	});
});

$(document).on('blur', '.quantity', function () {
	let id = $(this).data("id");
	let newValue = parseInt($(this).val());
	let maxValue = parseInt($(this).attr('max'));
	let minValue = parseInt($(this).attr('min'));

	if (newValue > maxValue) {
		$(this).val(maxValue);
		newValue = maxValue;
	}

	if (newValue <= 0) {
		newValue = minValue;
		$(this).val(minValue);
	}

	updateQuantity(id, newValue);
});

function totalCount() {
	let arrTotal = document.querySelectorAll("#total");
	let total = 0;
	arrTotal.forEach(function (item) {
		let totalPrice= item.getAttribute("value");
		total += parseInt(totalPrice);
	});

	return total;
}

function fetchCart() {
	ajaxGet(allCartItemUrl).done(function (res) {
		let html = '';
		data = res.data;
		$("#product-container").empty();
		if (data.length == 0) {
			html += `<div id="product">
					<div class="card">
						<div class="card-body">
							<span>Belum ada produk yang di masukkan ke dalam keranjang</span>
						</div>
					</div>
				</div>`;
		}
		data.forEach(function (item) {
			let attachment = item.attachment != null ? BASE_URL + item.attachment : BASE_URL + 'assets/home/images/image_5.jpg';
			html += `<div id="product" class="mb-3">
					<div class="card">
						<div class="card-body">
							<div class="d-flex" style="gap: 10px">
								<img width="80" height="80" style="object-fit: cover; border-radius: 7px" src="${attachment}" alt="">
								<div class="d-flex flex-column justify-content-between flex-grow-1 flex-shrink-1">
									<div class="d-flex justify-content-between flex-grow-1 flex-shrink-1">
										<a href="#" class="product-name">${item.title}</a>
										<span data-price="${item.price}" class="price">${ formatRupiah(item.price, "IDR", false) }</span>
										<input type="hidden" id="total" value="${item.quantity * item.price}">
									</div>
									<div class="d-flex justify-content-end flex-grow-1 flex-shrink-1 align-items-center" style="gap: 10px">
										<button data-id="${item.id}" id="btn-remove" class="btn btn-trash product-remove" style="height: 30px !important;"><i class="ion-ios-trash"></i></button>
										<div class="control" style="width: auto">
											<button data-id="${item.id}" class="btn btn-decrease" style="height: 30px !important;">
												<i class="ion-ios-remove"></i>
											</button>
											<input data-id="${item.id}" class="quantity" id="quantity" name="quantity" type="number" style="border: none; outline: none; background-color: transparent; appearance: textfield; text-align: center; width: 50px" min="1" max="${item.stock}" step="1" value="${item.quantity}">
											<button data-id="${item.id}" class="btn btn-increase" style="height: 30px !important;">
												<i class="ion-ios-add"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>`;
		});
		$("#product-container").append(html);
		$(".total-price").html(formatRupiah(totalCount(), "IDR", false));
		$("#total-price").val(totalCount());
		fetchTotalCart();
	});
}

function fetchTotalCart() {
	let countCart = 0;
	ajaxGet(allCartItemUrl).done(function (res) {
		data = res.data;
		countCart = data.length;
		$(".cart-count").html(countCart);
	});
}

function updateQuantity(idCartItem, quantity) {
	let url = $("#update-url").val();
	let formData = new FormData();
	formData.append('id', idCartItem);
	formData.append('quantity', quantity);
	ajaxPost(url, formData);
}

function ajaxDelCustom(url, id, reload = false, typeNotification = 'snackbarSuccess', table = null, confirmSweetDelete = null) {
	const title = confirmSweetDelete == null ? confirmSweetDeleteDefault.title : confirmSweetDelete.title;
	const body = confirmSweetDelete == null ? confirmSweetDeleteDefault.body : confirmSweetDelete.body;
	const buttonLabel = confirmSweetDelete == null ? confirmSweetDeleteDefault.buttonLabel : confirmSweetDelete.buttonLabel;
	const buttonConfirmColor = confirmSweetDelete == null ? confirmSweetDeleteDefault.buttonConfirmColor : confirmSweetDelete.buttonConfirmColor;

	Swal.fire({
		title: title,
		text: body,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: buttonConfirmColor,
		confirmButtonText: buttonLabel
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type: 'POST',
				url: url,
				data:{'id':id},
				dataType: 'json',
				success: function (res) {
					if (res.success == true) {
						if(typeNotification == 'sweetSuccess') {
							sweetSuccess(res.message);
						}

						if (typeNotification == 'notifySuccess') {
							notifySuccess(res.message);
						}

						if (typeNotification == 'toastSuccess') {
							toastSuccess(res.message);
						}

						if (typeNotification == 'snackbarSuccess') {
							snackbarSuccess(res.message);
							fetchCart();
							fetchTotalCart();
						}

						if(table !== null)
						{
							reloadTable(table);
						}
						if (reload == true) {
							setTimeout(function (){
								location.reload();
							}, 1500);
						}
					}else {
						new sweetError(res.message);
					}
				},
				error: function (res) {
					new sweetError('There is an error');
				}
			});
		}
	});
}
