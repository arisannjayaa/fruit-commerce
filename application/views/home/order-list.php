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
			$status = $transaction->status_code == '201' ? 'Pending' : 'Selesai';
			$date = new DateTime($transaction->transaction_time);
			$total = 0;
		?>
			<div class="card mb-3">
				<div class="card-body">
					<div class="d-flex mb-3" style="gap: 10px">
						<span class="badge {{ $status == 'Pending' ? 'bg-warning' : 'bg-success' }} text-white my-auto">{{ $status }}</span>
						<span>{{ $date->format('d F Y') }}</span>
						<span class="d-lg-block d-none cursor-pointer">{{ $transaction->order_id }}</span>
					</div>
					<div class="d-flex justify-content-between flex-wrap">
						<div class="product col-lg-8 col-12" style="padding: 0">
							<div class="d-flex" style="gap: 10px">
								<img class="img-product" style="object-fit: cover; border-radius: 7px" src="<?= base_url('assets/home/images/image_5.jpg') ?>" alt="Colorlib Template">
								<span data-id="{{ $transaction->order_id }}" class="detail" href="javascript:void(0)">{{ $product[0]->title }}</span>
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
				<span>Belum ada transaksi pembelian</span>
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
