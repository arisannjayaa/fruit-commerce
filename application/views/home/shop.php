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
<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('assets/home/') ?>images/bg_1.jpg);">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Shop</span></p>
				<h1 class="mb-0 bread">Shop</h1>
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
						<li ><a class="<?= $category_id ==  $category->id ? "active" : "" ?>" href="<?= base_url('shop?category=' . $category->id) ?>">{{ $category->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="row">
			@if(count($products) > 0)
				@foreach($products as $product)
			<div class="col-md-6 col-lg-3 ftco-animate">
				<div class="product item-product">
					<a href="{{ base_url('shop/' . $product->slug) }}" class="img-prod"><img class="img-product" src="<?= base_url($product->attachment ?? 'assets/home/images/image_5.jpg') ?>" alt="Colorlib Template">
						<div class="overlay"></div>
					</a>
					<div class="text py-3 pb-4 px-3 text-center">
						<h3><a href="javascript:void(0)">{{ $product->title }}</a></h3>
						<div class="d-flex">
							<div class="pricing">
								<p class="price"><span>{{ formatToRupiah($product->price) }}</span></p>
							</div>
						</div>
						<div class="bottom-area d-flex px-3">
							<div class="m-auto d-flex">
								<a href="javascript:void(0)" data-id="{{ $product->id }}" class="buy-now d-flex justify-content-center align-items-center mx-1 add-cart">
									<span><i class="ion-ios-cart"></i></span>
								</a>
							</div>
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
	$(".item-product").on('click', '.add-cart', function (){
		location.href = BASE_URL + 'login';
	});
</script>
@endif
@endsection
