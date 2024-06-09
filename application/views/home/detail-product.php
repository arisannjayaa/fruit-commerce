@extends('theme.home')

@section('title', 'Product Detail - ' . $product->title)

@section('style')
<style>
	.img-product {
		height: 500px;
		width: 100%;
		object-fit: contain;
	}
</style>
@endsection

@section('content')
<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('assets/home/') ?>images/bg_1.jpg);">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span class="mr-2"><a href="index.html">Product</a></span> <span></span></p>
				<h1 class="mb-0 bread">Product - {{ $product->title }}</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="images/product-1.jpg" class="image-popup"><img class="img-product" src="{{ base_url($product->attachment) }}" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate item-product">
				<h3>{{ $product->title }}</h3>
				<div class="rating d-flex">
					<p class="text-left">
						<a href="javascript:void()" class="mr-2" style="color: #000;">Stok <span style="color: #bbb;">{{ $product->stock }}</span></a>
					</p>
				</div>
				<p class="price"><span>{{ formatToRupiah($product->price) }}</span></p>
				<p>
					{{ $product->description }}
				</p>
				<p><a href="javascript:void(0)" class="btn btn-black py-3 px-5 add-cart" data-id="{{ $product->id }}">Add to Cart</a></p>
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
@if($this->auth->user())
<script src="{{ base_url('assets/dist/js/cart/cart.js') }}"></script>
@endif
@endsection
