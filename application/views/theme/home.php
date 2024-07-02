<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
	@include('components/home/css')
	@yield('style')
</head>
<body class="goto-here">
<!--<div class="py-1 bg-primary">-->
<!--	<div class="container">-->
<!--		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">-->
<!--			<div class="col-lg-12 d-block">-->
<!--				<div class="row d-flex">-->
<!--					<div class="col-md pr-4 d-flex topper align-items-center">-->
<!--						<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>-->
<!--						<span class="text">+ 1235 2355 98</span>-->
<!--					</div>-->
<!--					<div class="col-md pr-4 d-flex topper align-items-center">-->
<!--						<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>-->
<!--						<span class="text">youremail@email.com</span>-->
<!--					</div>-->
<!--					<div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">-->
<!--						<span class="text">3-5 Business days delivery &amp; Free Returns</span>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	@include('components/home/navbar')
</nav>
<!-- END nav -->

@yield('content')

<footer class="ftco-footer ftco-section">
	<div class="container">
		<div class="row">
			<div class="mouse">
				<a href="#" class="mouse-icon">
					<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
				</a>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2">Bu Jem Jem</h2>
					<p>Sehat, dan Berkualitas - Buah dan Sayur Pilihan Terbaik, Langsung dari Kebun Kami ke Meja Anda Setiap Hari!</p>
<!--					<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">-->
<!--						<li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>-->
<!--						<li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>-->
<!--						<li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>-->
<!--					</ul>-->
				</div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4 ml-md-5">
					<h2 class="ftco-heading-2">Menu</h2>
					<ul class="list-unstyled">
						<li><a href="<?= base_url('shop')?>" class="py-2 d-block">Belanja</a></li>
						<li><a href="<?= base_url('about')?>" class="py-2 d-block">Tentang</a></li>
						<li><a href="<?= base_url('contact')?>" class="py-2 d-block">Kontak</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2">Punya pertanyaan?</h2>
					<div class="block-23 mb-3">
						<ul>
							<li><a href="#"><span class="icon icon-map-marker"></span><span class="text">Jalan Bypass Ngurah Rai, Nusa Dua</span></a></li>
							<li><a href="#"><span class="icon icon-phone"></span><span class="text">+62 8902838 37823</span></a></li>
							<li><a href="#"><span class="icon icon-envelope"></span><span class="text">bujemjem@gmail.com</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">

				<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Hilmi Dev</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
			</div>
		</div>
	</div>
</footer>

<input type="hidden" id="user-id" value="{{ @$this->auth->user()->id }}">
<input type="hidden" id="base-url" value="{{ base_url('') }}">
<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
@include('components/home/script')
@yield('url')
@yield('script')
</body>
</html>
