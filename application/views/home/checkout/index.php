@extends('theme.home')

@section('title', 'Cart')

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
		<h4>Checkout</h4>
		<div class="row mb-3">
			<div class="col-lg-4">
				<div class="card">
					<div class="card-body">
						<div class="card address mb-3">
							<div class="card-body">
								<h6 data-testid="label"><?= $address->label ?></h6>
								<h6 data-testid="addressee"><?= $address->addressee ?></h6>
								<div data-testid="telephone"><?= $address->telephone ?></div>
								<span data-testid="address"><?= $address->address ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-12">
				<div id="product-container"></div>
			</div>
			<div class="col-lg-4 col-12">
				<div id="total-container">
					<div class="card">
						<div class="card-body">
							<span class="h6 mb-3 d-block">Ringkasan Belanja</span>
							<div class="d-flex justify-content-between align-items-center mb-3">
								<span>Total</span>
								<input id="total-price" type="hidden" value="">
								<h6 class="total-price">100</h6>
							</div>
							<button id="pay-button" class="btn btn-primary w-100 text-white">Bayar</button>
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
<script src="{{ base_url('assets/dist/js/cart/cart.js') }}"></script>
<script src="{{ base_url('assets/dist/js/cart/checkout.js') }}"></script>
@endsection
