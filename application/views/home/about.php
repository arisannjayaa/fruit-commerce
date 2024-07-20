@extends('theme.home')

@section('title', 'Tentang')

@section('style')
<style>
	.img-product {
		height: 200px;
		width: 100%;
		object-fit: cover;
	}
</style>
@endsection

@section('content')
<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('assets/home/') ?>images/bg_1.jpg);">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url('about') ?>">Beranda</a></span> <span>Tentang</span></p>
				<h1 class="mb-0 bread">Tentang</h1>
			</div>
		</div>
	</div>
</div>
<section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
	<div class="container">
		<div class="row">
			<div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(<?= base_url('assets/home/') ?>images/about.jpg);">
			</div>
			<div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate fadeInUp ftco-animated">
				<div class="heading-section-bold mb-4 mt-md-5">
					<div class="ml-md-0">
						<h2 class="mb-4">Welcome to Vegefoods an eCommerce website</h2>
					</div>
				</div>
				<div class="pb-md-5">
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
					<p>But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
					<p><a href="<?= base_url('shop') ?>" class="btn btn-primary">Belanja Sekarang</a></p>
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
<input type="hidden" id="create-url" value="<?= base_url('cart/create') ?>">
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/helpers.min.js"></script>
@endsection
