@extends('theme.home')

@section('title', 'Kontak')

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
<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('assets/home/') ?>images/category-3.jpg);">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url('') ?>">Beranda</a></span>
                    <span>Kontak</span>
                </p>
                <h1 class="mb-0 bread">Kontak</h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section contact-section bg-light">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="w-100"></div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Nama Usaha:</span> Warung bu Jem-Jem</p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Alamat:</span> Jalan Bypass Ngurah Rai, Nusa Dua</p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Telepon:</span> <a href="tel://1234567920">+62 81558735604</a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span>Email:</span> <a href="mailto:info@yoursite.com">bujemjem@gmail.com</a></p>
                </div>
            </div>
        </div>
        <!-- <div class="row block-9">
			<div class="col-md-6 order-md-last d-flex">
				<form action="#" class="bg-white p-5 contact-form">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Nama">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Subjek">
					</div>
					<div class="form-group">
						<textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Pesan"></textarea>
					</div>
					<div class="form-group">
						<input type="submit" value="Kirim Pesan" class="btn btn-primary py-3 px-5">
					</div>
				</form>

			</div> -->

        <div class="col-md-6 d-flex text-center">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9882.224088869649!2d115.21796023149464!3d-8.797792883709088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2433f202626f9%3A0x255c93dcef84fbb7!2sWarung%20Bu%20Jemjem!5e0!3m2!1sid!2sid!4v1721457596078!5m2!1sid!2sid"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
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