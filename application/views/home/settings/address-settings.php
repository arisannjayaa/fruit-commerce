@extends('theme.home')

@section('title', 'Pengaturan Alamat')

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
						@foreach($addresses as $address)
						<div style="max-height: 500px !important; overflow-x: scroll !important;">
							<div class="card address <?= $address->is_primary ? 'active' : '' ?> mb-3">
								<div class="card-body">
									<h6 data-testid="label"><?= $address->label ?></h6>
									<h6 data-testid="addressee"><?= $address->addressee ?></h6>
									<div data-testid="telephone"><?= $address->telephone ?></div>
									<span data-testid="address"><?= $address->address ?></span>

									<div class="mt-3">
										@if ($address->is_primary != 1)
										<button data-id="<?= $address->id ?>" class="btn btn-primary set-primary">Jadikan alamat utama</button>
										@endif
										<button data-id="<?= $address->id ?>" class="btn btn-secondary edit"><i class="bi bi-pen-fill"></i></button>
										<button data-id="<?= $address->id ?>" class="btn btn-danger delete"><i class="bi bi-trash-fill"></i></button>
									</div>
								</div>
							</div>
						</div>
						@endforeach
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
<input type="hidden" id="all-cart-item-url" value="<?= base_url('all-cart') ?>">
<input type="hidden" id="total-rows" value="{{ $total }}">
<input type="hidden" id="update-url" value="{{ base_url('user/settings/address/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('user/settings/address/delete') }}">
<input type="hidden" id="set-primary-url" value="{{ base_url('user/settings/address/setprimary') }}">
<input type="hidden" id="edit-url" value="{{ base_url('user/settings/address/edit/:id') }}">
@endsection

@section('script')
@if($this->auth->user())
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/helpers.min.js"></script>
<script>
	fetchTotalCart();
	function fetchTotalCart() {
		let countCart = 0;
		let url = $("#all-cart-item-url").val();
		ajaxGet(url).done(function (res) {
			console.log(res);
			let data = res.data;
			countCart = data.length;
			$(".cart-count").html(countCart);
		});
	}
</script>
<script src="{{ base_url('assets/dist/js/settings/address.js') }}"></script>
@endif
@endsection
