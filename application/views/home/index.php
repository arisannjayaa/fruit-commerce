@extends('theme.home')

@section('title', 'Home')

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
<section id="home-section" class="hero">
    <div class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url(<?= base_url('assets/home/') ?>images/category-1.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-md-12 ftco-animate text-center">
                        <h1 class="mb-2">Kami menyediakan sayur jewhejwhje &amp; buah</h1>
                        <h2 class="subheading mb-4">Free pengiriman sayur &amp; buah hanya untuk Daerah Denpasar & Nusa
                            Dua</h2>
                        <p><a href="<?= base_url('shop') ?>" class="btn btn-primary">Lihat Selengkapnya</a></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="slider-item" style="background-image: url(<?= base_url('assets/home/') ?>images/bg_3.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-sm-12 ftco-animate text-center">
                        <h1 class="mb-2">100% Buah segar &amp; sayur berkualitas</h1>
                        <h2 class="subheading mb-4">Pengiriman setiap Hari</h2>
                        <p><a href="<?= base_url('shop') ?>" class="btn btn-primary">Lihat Selengkapnya</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters ftco-services">
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-shipped"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Bebas Biaya Kirim</h3>
                        <span>Seluruh pesanan</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-diet"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Selalu Segar</h3>
                        <span>Paket produk baik</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-award"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Kualitas Unggul</h3>
                        <span>Produk berkualitas</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-customer-service"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Dukungan</h3>
                        <span>24/7 Dukungan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-category ftco-no-pt">
    <div class="row justify-content-center">
        <!-- <div class="col-lg-4 col-12">
                <div class="category-wrap-2 ftco-animate img align-self-stretch text-center">
                    <img height="400" src="<?= base_url('assets/home/images/category.jpg') ?>" alt="">
                    <div class="text text-center">
                        <h2>Sayuran</h2>
                        <p>Lindungi kesehatan setiap rumah</p>
                        <p><a href="<?= base_url('shop') ?>" class="btn btn-primary">Berbelanja sekarang</a></p>
                    </div>
                </div>
            </div> -->
        <div class="col-lg-8 col-12">
            <div class="row">
                @foreach($categories as $category)
                <div class="col-lg-6 col-12">
                    <div class="category-wrap ftco-animate img d-flex align-items-end"
                        style="background-image: url(<?= base_url('assets/home/') ?>images/category-1.jpg);">
                        <div class="text px-3 py-1">
                            <h2 class="mb-0"><a href="#">{{ $category->name }}</a></h2>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Produk Pilihan</span>
                <h2 class="mb-4">Produk kita</h2>
                <p>Miliki buah dan sayur pilihan kami yang segar dan berkualitas tinggi, langsung dari kebun ke meja
                    makan Anda.</p>
            </div>
        </div>
    </div>
    <div class="container">
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