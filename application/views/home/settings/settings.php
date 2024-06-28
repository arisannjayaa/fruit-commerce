@extends('theme.home')

@section('title', 'Pengaturan')

@section('style')
<style>
	.img-product {
		height: 80px;
		width: 80px;
		object-fit: cover;
	}

	.nav-link.active {
		color: #fff !important;
		background-color: #82ae46 !important;
	}
</style>
@endsection

@section('content')
<section class="ftco-section">
	<div class="container">
		<h4>Pengaturan Biodata</h4>
		<div class="card">
			<div class="card-header">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->uri_string() == 'user/settings' ? 'active' : '' ?>" href="<?= base_url('user/settings') ?>">Biodata</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->uri_string() == 'user/settings/address' ? 'active' : '' ?>" href="<?= base_url('user/settings/address') ?>">Alamat</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-4"></div>
					<div class="col-8"></div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('url')
<input type="hidden" id="detail-url" value="{{ base_url('order-list/:id') }}">
@endsection

@section('script')
@if($this->auth->user())
<script src="{{ base_url('assets/dist/js/order-list.js') }}"></script>
@endif
@endsection
