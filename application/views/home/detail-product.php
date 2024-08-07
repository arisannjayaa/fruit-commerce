@extends('theme.home')

@section('title', 'Product Detail - ' . $product->title)

@section('style')
<style>
	.img-product {
		height: 500px;
		width: 100%;
		object-fit: contain;
	}

	.btn-primary:hover {
		color: #82ae46 !important;
		border: 1px solid #82ae46 !important;
	}

	.btn-primary {
		color: #fff !important;
	}
</style>
@endsection

@section('content')
<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('assets/home/') ?>images/bg_1.jpg);">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url('') ?>">Beranda</a></span> <span class="mr-2"><a href="index.html">Product</a></span> <span></span></p>
				<h1 class="mb-0 bread">Produk - {{ $product->title }}</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="{{ base_url($product->attachment ?? 'assets/home/images/image_5.jpg') }}" class="image-popup"><img class="img-product" src="{{ base_url($product->attachment ?? 'assets/home/images/image_5.jpg') }}" class="img-fluid"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate item-product">
				<h3>{{ $product->title }}</h3>
				<div class="rating d-flex">
					<p class="text-left">
						<a href="javascript:void()" class="mr-2" style="color: #000;"><span style="color: #bbb;">{{ "Stok " . $product->stock }}</span></a>
						<a href="javascript:void()" class="mr-2" style="color: #000;"><span style="color: #bbb;">{{ "Terjual " . $product->total_sold }}</span></a>
					</p>
				</div>
				<p class="price"><span>{{ formatToRupiah($product->price) }}</span></p>
				<p>
					{{ $product->description }}
				</p>
				<a class="btn btn-primary add-cart" data-id="{{ $product->id }}"><i class="ion-ios-cart"></i> Keranjang</a>
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
	$(".item-product").on('click', '.add-cart', function (){
		location.href = BASE_URL + 'login';
	});
</script>
@endif
@endsection
