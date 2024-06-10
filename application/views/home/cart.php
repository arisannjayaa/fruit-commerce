@extends('theme.home')

@section('title', 'Cart')

@section('style')
<script type="text/javascript"
		src="https://app.sandbox.midtrans.com/snap/snap.js"
		data-client-key="SB-Mid-client-S09glAfzatzn3woa"></script>
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

	.btn-decrease, .btn-increase {
		width: 30px;
		height: 30px !important;
		border-radius: 10px;
	}
</style>
@endsection

@section('content')
<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('assets/home/') ?>images/bg_1.jpg);">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span class="mr-2"><a href="index.html">Cart</a></span> <span></span></p>
				<h1 class="mb-0 bread">My Cart</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section ftco-cart">
	<form class="d-none" id="payment-form">
		<input type="hidden" name="result_type" id="result-type" value=""></div>
		<input type="hidden" name="result_data" id="result-data" value=""></div>
		<input type="hidden" name="body" id="body" value=""></div>
		<input type="hidden" name="invoice" id="invoice" value="<?= genInvoice() ?>"></div>
	</form>
	<div class="container">
		<div class="row">
			<div class="col-md-12 ftco-animate">
				<div class="cart-list">
					<table id="table" class="table">
						<thead class="thead-primary">
						<tr class="text-center">
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>Product name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row justify-content-end">
			<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
				<div class="cart-total mb-3">
					<h3>Ringkasan Belanja</h3>
					<p class="d-flex">
						<span>Total</span>
						<input id="total-price" type="hidden" value="">
						<h4 class="total-price"></h4>
					</p>
				</div>
				<p><button id="pay-button" class="btn btn-primary py-3 px-4 checkout">Bayar</button></p>
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
<script src="{{ base_url('assets/dist/js/cart/cart.js') }}"></script>
<script src="{{ base_url('assets/dist/js/cart/checkout.js') }}"></script>
@endsection
