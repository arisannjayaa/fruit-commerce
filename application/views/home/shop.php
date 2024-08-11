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
    <form id="filter-form" action="<?= base_url('shop') ?>" method="get">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h5 class="mb-3">Urutkan</h5>
                    <select name="sort_by" id="" class="form-control mb-3"
                        style="width: 100% !important; height: 40px !important;">
                        <option value="popular" <?= $this->input->get('sort_by') == "popular" ? "selected" : "" ?>>
                            Terpopular</option>
                        <option value="title_asc" <?= $this->input->get('sort_by') == "title_asc" ? "selected" : "" ?>>
                            Judul : A - Z</option>
                        <option value="title_desc"
                            <?= $this->input->get('sort_by') == "title_desc" ? "selected" : "" ?>>Judul : Z - A</option>
                        <option value="price_asc" <?= $this->input->get('sort_by') == "price_asc" ? "selected" : "" ?>>
                            Harga : Rendah - Tinggi</option>
                        <option value="price_desc"
                            <?= $this->input->get('sort_by') == "price_desc" ? "selected" : "" ?>>Harga : Tinggi -
                            Rendah</option>
                        <option value="created_desc"
                            <?= $this->input->get('sort_by') == "created_desc" ? "selected" : "" ?>>Waktu : Terbaru
                        </option>
                        <option value="created_asc"
                            <?= $this->input->get('sort_by') == "created_asc" ? "selected" : "" ?>>Waktu : Terlama
                        </option>
                    </select>
                    <h5 class="mb-3">Kategori</h5>
                    <div style="max-height: 400px; overflow-y: hidden">
                        @php
                        $ctgr = $this->input->get('category') ?? [];
                        @endphp
                        @foreach($categories as $category)
                        <div class="form-check d-flex align-items-center mb-4" style="gap: 10px;">
                            <input value="<?= $category->id ?>" name="category[]" class="form-check-input"
                                style="position: relative !important; width: 25px; height: 25px;" type="checkbox"
                                id="<?= $category->id ?>" <?= in_array($category->id, $ctgr) ? "checked" : "" ?>>
                            <label class="form-check-label" for="<?= $category->id ?>>">
                                <?= $category->name ?>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <button class="btn btn-primary w-100 mb-3 mb-lg-0" type="submit">Terapkan</button>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-3">Menampilkan <?= count($products) .  " Produk" ?></h5>
                    </div>
                    <div class="row">
                        @if(count($products) > 0)
                        @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 ftco-animate">
                            <div class="product item-product p-2" style="border-radius: 10px;">
                                <div onclick="window.location.href='<?= base_url('shop/' . $product->slug) ?>'"
                                    style="cursor: pointer;">
                                    <img class="img-product mb-2" style="border-radius: 10px;"
                                        src="<?= base_url($product->attachment ?? 'assets/home/images/image_5.jpg') ?>"
                                        alt="">
                                    <div id="detail" class="p-1 mb-2">
                                        <h1 style="font-size: 16px; font-weight: 400;">
                                            <?= trimString($product->title, 25) ?></h1>
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
            </div>
        </div>
    </form>
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