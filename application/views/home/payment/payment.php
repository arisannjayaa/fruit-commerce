@extends('theme.home')

@section('title', 'Pembayaran')

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
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 col-12">
				<div class="text-center">
					<img height="250" width="250" src="<?= base_url('assets/dist/img/undraw_payments_re_77x0.svg') ?>" alt="payment">
					<h5 id="title" class="mb-3"><div class="d-flex justify-content-center">
							<div class="spinner-border" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>`</h5>
					<h5 id="countdown"></h5>
				</div>
				<?php
				$paymentResponse = json_decode($transaction->capture_payment_response);
				?>
				<div class="card">
					<div class="card-body">
						<h5><?= strtoupper($paymentResponse->va_numbers[0]->bank) . ' Virtual Account' ?></h5>
					</div>
				</div>
				<div class="card mb-3">
					<div class="card-body">
						<div class="mb-3">
							<label for="">Nomor Virtual Account</label>
							<h5 id="va-number"><?= strtoupper($paymentResponse->va_numbers[0]->va_number) ?></h5>
						</div>
						<div class="mb-2">
							<label for="">Total Tagihan</label>
							<h5 id="va-number"><?= formatToRupiah($paymentResponse->gross_amount) ?></h5>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<button class="btn btn-primary w-100" onclick="window.location.href='<?= base_url('order-list') ?>'">Lihat Status Pembayaran</button>
					</div>
					<div class="col">
						<button class="btn btn-primary w-100" onclick="window.location.href='<?= base_url('shop') ?>'">Belanja Lagi</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('url')
<input type="hidden" id="expiry-date" value="{{ $transaction->expired_time }}">
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/helpers.min.js"></script>
<script>
	const expiry = $("#expiry-date").val();
	setTimeout(() => {
		$("#title").html('Pembayaran Harus Selesai Dalam');
	},1000);
	
	setInterval(function() {
		countDown(expiry);
	}, 1000);

	function fetchTotalCart() {
		let countCart = 0;
		let url = BASE_URL + 'all-cart-item-url';
		ajaxGet(url).done(function (res) {
			let data = res.data;
			countCart = data.length;
			$(".cart-count").html(countCart);
		});
	}
</script>
@endsection
