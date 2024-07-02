@extends('theme.home')

@section('title', 'Checkout')

@section('style')
<script type="text/javascript"
		src="https://app.sandbox.midtrans.com/snap/snap.js"
		data-client-key="SB-Mid-client-S09glAfzatzn3woa" xmlns="http://www.w3.org/1999/html"></script>
<style>
	.img-product {
		height: 500px;
		width: 100%;
		object-fit: contain;
	}

	input[type=number]::-webkit-outer-spin-button,
	input[type=number]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	input[type=number] {
		-moz-appearance: textfield;
	}

	.btn-decrease, .btn-increase, .btn-trash {
		width: 30px !important;
		height: 30px !important;
		border-radius: 10px;
	}

	.address.active {
		border: 1px solid #82ae46 !important;
	}

	.ftco-cart button.btn-primary:hover {
		color: #82ae46 !important;
		border: 1px solid #82ae46 !important;
	}

	.ftco-cart button.btn-primary {
		color: #fff !important;
	}
</style>
@endsection

@section('content')
<section class="ftco-section ftco-cart">
	<form class="d-none" id="payment-form">
		<input type="hidden" name="result_type" id="result-type" value=""></div>
		<input type="hidden" name="result_data" id="result-data" value=""></div>
		<input type="hidden" name="invoice" id="invoice" value="<?= genInvoice() ?>"></div>
	</form>
	<div class="container">
		<button onclick="location.href='<?= base_url('cart') ?>'" class="btn btn-primary " style="width: 50px; height: 50px"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></button>
		<h4>Checkout</h4>
		<div class="row mb-3">
			<div class="col-lg-4">
				<div class="card address <?= $address->is_primary ? 'active' : '' ?>">
					<div class="card-body">
						<h6 data-testid="label"><?= $address->label ?></h6>
						<h6 data-testid="addressee"><?= $address->addressee ?></h6>
						<div data-testid="telephone"><?= $address->telephone ?></div>
						<span data-testid="address"><?= $address->address ?></span>
						<hr>
						<div>
							<a href="<?= base_url('user/settings/address') ?>">Ubah alamat</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-12">
				<div id="product-container">
					@foreach($carts as $cart)
					<div id="product" class="mb-3">
						<div class="card">
							<div class="card-body">
								<div class="d-flex" style="gap: 10px">
									<img width="80" height="80" style="object-fit: cover; border-radius: 7px" src="{{ base_url($cart->attachment) ?? base_url('assets/home/images/image_5.jpg') }}" alt="">
									<div class="d-flex justify-content-between flex-grow-1 flex-shrink-1">
										<div class="d-flex flex-column">
											<a href="#" class="product-name">{{ $cart->title }}</a>
											<span></span>
											<span data-price="{{ $cart->title }}" class="price">{{ $cart->quantity . ' x ' . formatToRupiah($cart->price) }} </span>
										</div>
										<span data-total-price="{{ $cart->title }}" class="total-price">{{ formatToRupiah($cart->price * $cart->quantity) }} </span>
										<input type="hidden" id="total" value="{{ formatToRupiah($cart->price * $cart->quantity) }}">
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div class="col-lg-4 col-12">
				<div id="total-container">
					<div class="card">
						<div class="card-body">
							<span class="h6 mb-3 d-block">Ringkasan Belanja</span>
							<div class="d-flex justify-content-between align-items-center mb-3">
								<span>Total</span>
								<input id="total-price" type="hidden" value="{{ $cart->price * $cart->quantity }}">
								<h6 class="total-price">{{ formatToRupiah($cart->price * $cart->quantity) }}</h6>
							</div>
							<button id="pay-button" class="btn btn-primary w-100">Pilih Pembayaran</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('url')
<input type="hidden" id="all-cart-item-url" value="<?= base_url('all-cart') ?>">
<input type="hidden" id="delete-item-cart-url" value="<?= base_url('cart/delete') ?>">
<input type="hidden" id="update-url" value="<?= base_url('cart/update') ?>">
<input type="hidden" id="snap-token-url" value="<?= base_url('snap/token') ?>">
<input type="hidden" id="snap-finish-url" value="<?= base_url('snap/finish') ?>">
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/helpers.min.js"></script>
<script>
	fetchTotalCart();
	function fetchTotalCart() {
		let countCart = 0;
		let url = $("#all-cart-item-url").val();
		ajaxGet(url).done(function (res) {
			let data = res.data;
			countCart = data.length;
			$(".cart-count").html(countCart);
		});
	}
</script>
<script src="{{ base_url('assets/dist/js/cart/checkout.js') }}"></script>
@endsection
