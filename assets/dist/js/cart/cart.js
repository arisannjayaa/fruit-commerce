let allCartItemUrl = $("#all-cart-item-url").val();
let userId = $("#user-id").val();
fetchCart();
$("#table").on("click", ".product-remove", function () {
	let id = $(this).data("id");
	let url = $("#delete-item-cart-url").val();
	ajaxDelCustom(url, id, false, "snackbarSuccess");
	fetchCart();
	fetchTotalCart();
});

$("#table").on("click", ".btn-increase", function () {
	let inputElement = $(this).closest("tr").find("input[type='number']");
	let currentValue = parseInt(inputElement.val());
	let newValue = currentValue + 1;
	let maxValue = parseInt(inputElement.prop("max"));
	let id = $(this).data("id");
	console.log(id);
	newValue = newValue <= maxValue ? newValue : maxValue;
	inputElement.val(newValue);
	updateQuantity(id, newValue);
	let priceElement = $(this).closest("tr").find(".price")[0];
	let totalElement = $(this).closest("tr").find(".total")[0];
	let InputTotalElement = $(this).closest("tr").find("#total")[0];
	let priceTotal = priceElement.getAttribute("data-price");
	let subTotal = newValue * parseInt(priceTotal);
	totalElement.innerHTML = formatRupiah(subTotal, "IDR", false);
	InputTotalElement.value = subTotal
	$(".total-price").html(formatRupiah(totalCount(), "IDR", false));
	$("#total-price").val(totalCount());
});

$("#table").on("click", ".btn-decrease", function () {
	let inputElement = $(this).closest("tr").find("input[type='number']");
	let currentValue = parseInt(inputElement.val());
	let newValue = currentValue - 1;
	let id = $(this).data("id");
	console.log(id);
	newValue = newValue < 1 ? 1 : newValue;
	inputElement.val(newValue);
	updateQuantity(id, newValue);
	let priceElement = $(this).closest("tr").find(".price")[0];
	let totalElement = $(this).closest("tr").find(".total")[0];
	let InputTotalElement = $(this).closest("tr").find("#total")[0];
	let priceTotal = priceElement.getAttribute("data-price");
	let subTotal = newValue * parseInt(priceTotal);
	totalElement.innerHTML = formatRupiah(subTotal, "IDR", false);
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
		$("tbody").empty();
		data.forEach(function (item) {
			html += `<tr id="product" class="text-center">
						<td class="product-remove" data-id="${item.id}"><a><span class="ion-ios-close"></span></a></td>
						<td class="image-prod"><div class="img" style="background-image:url(${item.attachment});"></div></td>
						<td class="product-name">
						<h3>${item.title}</h3>
						<p>${ subStr(item.description, 80) }</p>
						</td>
						<td data-price="${item.price}" class="price">${formatRupiah(item.price, "IDR")}</td>
						<td class="quantity">
							<div class="d-flex align-items-center justify-content-center" style="gap: 10px">
								<button data-id="${item.id}" class="btn btn-decrease" style="height: 30px !important;">
								<i class="ion-ios-remove"></i>
								</button>
								<input  id="quantity" name="quantity" type="number" style="border: none; outline: none; background-color: transparent; appearance: textfield; text-align: center" min="1" max="${item.stock}" step="1" value="${item.quantity}">
								<button data-id="${item.id}" class="btn btn-increase" style="height: 30px !important;">
								<i class="ion-ios-add"></i>
								</button>
							</div>
						</td>
						<input type="hidden" id="total" value="${item.quantity * item.price}">
						<td class="total">${formatRupiah(item.quantity * item.price, "IDR", false)}</td>
						</tr>`;
		});
		$("tbody").append(html);
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
	console.log(url);
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
