<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
	<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
	<title>Invoice - {{ $transaction->order_id }}</title>
	<!-- CSS files -->
	<link href="<?= base_url('assets') ?>/dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
	<link href="<?= base_url('assets') ?>/dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
	<link href="<?= base_url('assets') ?>/dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
	<link href="<?= base_url('assets') ?>/dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
	<link href="<?= base_url('assets') ?>/dist/css/demo.min.css?1692870487" rel="stylesheet"/>
	<style>
		@import url('https://rsms.me/inter/inter.css');
		:root {
			--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
		}
		body {
			font-feature-settings: "cv03", "cv04", "cv11";
		}

		table td {
			padding-top: 5px; /* Jarak atas dalam sel */
			padding-bottom: 5px; /* Jarak bawah dalam sel */
			padding-left: 5px;

		}
	</style>
</head>
<body >
<script src="<?= base_url('assets') ?>/dist/js/demo-theme.min.js?1692870487"></script>
<div class="page">
	<div class="page-wrapper">
		<!-- Page header -->
		<div class="page-header d-print-none">
			<div class="container-xl">
				<div class="row g-2 align-items-center">
					<div class="col">
						<h2 class="page-title">
							Invoice
						</h2>
					</div>
					<!-- Page title actions -->
					<div class="col-auto ms-auto d-print-none">
						<button type="button" class="btn btn-primary" onclick="javascript:window.print();">
							<!-- Download SVG icon from http://tabler-icons.io/i/printer -->
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
							Print Invoice
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Page body -->
		@php
			$captureRequest = json_decode($transaction->capture_payment_request);
			$customerDetail = $captureRequest->customer_details;
			$products = json_decode($transaction->products);
		@endphp
		<div class="page-body">
			<div class="container-xl">
				<div class="card card-lg">
					<div class="card-body">
						<div class="row">
							<div class="col-6">
								<p class="h1">BU JEM JEM</p>
							</div>
							<div class="col-6">
								<div class="float-end">
									<h3 class="text-start" class="h3 fw-bold">UNTUK</h3>
									<table style="float: left">
										<tr>
											<td>Pembeli</td>
											<td>:</td>
											<td>{{ $customerDetail->first_name . ' ' . $customerDetail->last_name ?? '' }}</td>
										</tr>
										<tr>
											<td>Tanggal Pembelian</td>
											<td>:</td>
											<td>{{ formatDateId($transaction->created_at) }}</td>
										</tr>
										<tr>
											<td>Alamat Pengiriman</td>
											<td>:</td>
											<td>{{ $customerDetail->shipping_address->address }}</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="col-12 my-5">
								<h1>Invoice {{ $transaction->order_id }}</h1>
							</div>
						</div>
						<table class="table table-transparent table-responsive">
							<thead>
							<tr>
								<th class="text-center" style="width: 1%"></th>
								<th>Produk</th>
								<th class="text-center" style="width: 5%">Jumlah</th>
								<th class="text-end" style="width: 20%">Harga Satuan</th>
								<th class="text-end" style="width: 20%">Total Harga</th>
							</tr>
							</thead>
							@php
							$index = 1;
							$subtotal = 0;
							@endphp
							@foreach($products as $product)
							<tr>
								<td class="text-center">{{ $index }}</td>
								<td>
									<p class="strong mb-1">{{ $product->name }}</p>
									<div class="text-secondary">{{ strip_tags(trimString($product->description, 150)) }}</div>
								</td>
								<td class="text-center">
									{{ $product->quantity }}
								</td>
								<td class="text-end">{{ formatToRupiah($product->price) }}</td>
								<td class="text-end">{{ formatToRupiah($product->price * $product->quantity) }}</td>
							</tr>
							@php
							$subtotal += $product->price * $product->quantity;
							@endphp
							@endforeach

							<tr>
								<td colspan="4" class="strong text-end">Total Harga</td>
								<td class="text-end">{{ formatToRupiah($subtotal) }}</td>
							</tr>
							<tr>
								<td colspan="4" class="font-weight-bold text-uppercase text-end">Total Tagihan</td>
								<td class="font-weight-bold text-end">{{ formatToRupiah($subtotal) }}</td>
							</tr>
						</table>
						<p class="text-secondary text-center mt-5">Terima kasih sudah berbelanjan di warung bu jem jem.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="<?= base_url('assets') ?>/dist/js/tabler.min.js?1692870487" defer></script>
<script src="<?= base_url('assets') ?>/dist/js/demo.min.js?1692870487" defer></script>
</body>
</html>
