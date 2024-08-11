@extends('theme.home')

@section('title', 'Pengaturan Biodata')

@section('style')
<!-- Dropify -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
	.img-profile {
		height: 300px;
		width: 100%;
		object-fit: cover;
		border-radius: 10px !important;
	}

	.nav-link.active {
		color: #fff !important;
		background-color: #82ae46 !important;
	}

	.address.active {
		border: 1px solid #82ae46 !important;
	}

	td {
		width: 200px !important;
		padding: 10px 0 !important;
	}

	.ftco-section .nav-link.active {
		color: #fff !important;
		background-color: #006400 !important;;
	}

	.ftco-section .nav-link {
		color: #006400 !important;;
	}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
					<div class="col-4">
						<div class="d-flex flex-column justify-content-center" style="gap: 10px;">
							<img src="<?= base_url($user->attachment ?? 'assets/dist/img/face.png') ?>" alt="profile" class="img-profile">
							<button data-id="<?= $user->id ?>" class="btn btn-primary w-100 edit">Ubah Biodata</button>
						</div>
					</div>
					<div class="col-6">
						<h5>Detail</h5>
						<table>
							<tr>
								<td>Nama Lengkap</td>
								<td><?= $user->first_name . ' ' . $user->last_name ?></td>
							</tr>
							<tr>
								<td>Telepon</td>
								<td><?= $user->telephone ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?= $user->email ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('home/settings/modal-bio')
@endsection

@section('url')
<input type="hidden" id="all-cart-item-url" value="<?= base_url('all-cart') ?>">
<input type="hidden" id="edit-url" value="<?= base_url('user/settings/edit/:id') ?>">
<input type="hidden" id="update-url" value="<?= base_url('user/settings/update') ?>">
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

<!-- Dropify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ base_url('assets/dist/js/user/profile.js') }}"></script>
@endif
@endsection
