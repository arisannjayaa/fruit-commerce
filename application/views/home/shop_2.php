@extends('theme.home')

@section('title', 'Shop')

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
<div class="hero-wrap hero-bread"
	style="background-image: url(<?= base_url('assets/home/') ?>images/Belanja_sekarang.jpg);">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url('') ?>">Beranda</a></span>
					<span>Belanja</span>
				</p>
				<h1 class="mb-0 bread">Belanja</h1>
			</div>
		</div>
	</div>
</div>
<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-10 mb-5 text-center">
				<ul class="product-category">
					<li><a href="<?= base_url('shop') ?>" class="<?= $category_id == "" ? "active" : "" ?>">All</a></li>
					@foreach($categories as $category)
					<li><a class="<?= $category_id ==  $category->id ? "active" : "" ?>"
							href="<?= base_url('shop?category=' . $category->id) ?>">{{ $category->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="row">
			@if(count($products) > 0)
			@foreach($products as $product)
			<div class="col-md-6 col-lg-3 ftco-animate">
				<div class="product item-product p-2" style="border-radius: 10px;">
					<div onclick="window.location.href='<?= base_url('shop/' . $product->slug) ?>'"
						style="cursor: pointer;">
						<img class="img-product mb-2" style="border-radius: 10px;"
							src="<?= base_url($product->attachment ?? 'assets/home/images/image_5.jpg') ?>" alt="">
						<div id="detail" class="p-1 mb-2">
							<h1 style="font-size: 16px; font-weight: 400;"><?= trimString($product->title, 25) ?></h1>
							<span style="font-size: 18px; font-weight: 600;"
								class="text-success"><?= formatToRupiah($product->price) ?></span>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@endif
		</div>
		<div class="row mt-5">
			<div class="col text-center">
				<div class="block-27">
					<!-- pagination -->
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
@if($this->auth->user())
<script src="{{ base_url('assets/dist/js/cart/cart.js') }}"></script>
@endif
@if(!$this->auth->user())
<script>
	$(".item-product").on('click', '.add-cart', function() {
		location.href = BASE_URL + 'login';
	});
</script>
@endif
@endsection