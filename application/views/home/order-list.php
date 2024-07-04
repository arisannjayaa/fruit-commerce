@extends('theme.home')

@section('title', 'Daftar Transaksi Pembelian')

@section('style')
<style>
	.img-product {
		height: 80px;
		width: 80px;
		object-fit: cover;
	}
</style>
@endsection

@section('content')
<section class="ftco-section">
	<div class="container">
		<h4>Daftar Transaksi</h4>
		@if(count($transactions) > 0)
		@foreach($transactions as $transaction)
		<?php
			$product = json_decode($transaction->products);
			$captureResponse = json_decode($transaction->capture_payment_response);
			$status = $captureResponse->transaction_status;
			$other = count($product) - 1;
			$total = 0;
		?>
			<div class="card mb-3">
				<div class="card-body">
					<div class="d-flex mb-3" style="gap: 10px">
						<span class="badge {{ $status == 'pending' ? 'bg-warning' : 'bg-success' }} text-white my-auto">{{ $status }}</span>
						<span>{{ formatDateId($transaction->created_at) }}</span>
						<span class="d-lg-block d-none cursor-pointer">{{ $transaction->order_id }}</span>
					</div>
					<div class="d-flex justify-content-between flex-wrap">
						<div class="products col-lg-8 col-12" style="padding: 0">
							<div class="d-flex" style="gap: 10px">
								<img class="img-product" style="object-fit: cover; border-radius: 7px" src="<?= base_url($product[0]->attachment ?? 'assets/home/images/image_5.jpg') ?>" alt="Colorlib Template">
								<div class="title">
									<span style="cursor:pointer;" data-id="{{ $transaction->order_id }}" class="detail" href="javascript:void(0)">{{ $product[0]->name }}</span>

									<span class="d-block">{{ $product[0]->quantity . ' Barang x ' . formatToRupiah($product[0]->price)  }} </span>

									@if ($other > 0)
									<a style="cursor: pointer" data-id="{{ $transaction->order_id }}" class="d-block detail">+ {{ $other }} produk lainnya</a>
									@endif
								</div>
							</div>
						</div>
						<div class="d-flex flex-column col-lg-4 col-12 align-items-lg-end align-items-start" style="padding: 0">
							<span>Total Belanja</span>
							<span>{{ formatToRupiah($transaction->gross_amount) }}</span>
						</div>
					</div>
					<div class="d-lg-flex d-none justify-content-end">
						<button type="button" data-id="{{ $transaction->order_id }}" href="javascript:void(0)" class="btn btn-primary detail">Lihat Detail Transaksi</button>
					</div>
				</div>
			</div>
		@endforeach
		@else
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center" style="gap: 10px;">
					<img class="img-fluid" width="200" src="{{ base_url('assets/dist/img/undraw_empty_cart_co35.svg') }}" alt="">
					<div>
						<h6>Waduhh, kamu belum memiliki riwayat transaksi</h6>
						<div class="mb-2">Yuk, lakukan transaksi dengan produk-produk impianmu!</div>
						<a href="{{ base_url('shop') }}" class="btn btn-primary">Mulai Belanja</a>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
@include('home/modal-order-detail')
@endsection

@section('url')
<input type="hidden" id="detail-url" value="{{ base_url('order-list/:id') }}">
@endsection

@section('script')
@if($this->auth->user())
<script src="{{ base_url('assets/dist/js/order-list.js') }}"></script>
@endif
@endsection
