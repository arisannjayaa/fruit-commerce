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

	.address.active {
		border: 1px solid #82ae46 !important;
	}
</style>
@endsection

@section('content')
<section class="ftco-section">
	<div class="container">
		<h4>Pengaturan Alamat</h4>
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
				<button type="button" id="btn-add" class="btn btn-primary mb-4">
					Tambah Alamat Baru
				</button>
				<div class="row">
					<div class="col-12">
						<div class="card address active">
							<div class="card-body">
								<h6 data-testid="label">Label</h6>
								<h6 data-testid="addressee">Addressee</h6>
								<div data-testid="telephone">6289394904</div>
								<span data-testid="address">Address</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('home/settings/modal-address')
@endsection

@section('url')
<input type="hidden" id="create-url" value="{{ base_url('user/settings/address/store') }}">
<input type="hidden" id="update-url" value="{{ base_url('user/settings/address/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('user/settings/address/delete') }}">
<input type="hidden" id="edit-url" value="{{ base_url('user/settings/address/edit/:id') }}">
@endsection

@section('script')
@if($this->auth->user())
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/helpers.min.js"></script>
<script src="{{ base_url('assets/dist/js/settings/address.js') }}"></script>
@endif
@endsection
