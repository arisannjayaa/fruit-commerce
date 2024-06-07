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
<div class="py-1 bg-primary">
	<div class="container">
		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
			<div class="col-lg-12 d-block">
				<div class="row d-flex">
					<div class="col-md pr-4 d-flex topper align-items-center">
						<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						<span class="text">+ 1235 2355 98</span>
					</div>
					<div class="col-md pr-4 d-flex topper align-items-center">
						<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						<span class="text">youremail@email.com</span>
					</div>
					<div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
						<span class="text">3-5 Business days delivery &amp; Free Returns</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
					<h2 class="ftco-heading-2">Vegefoods</h2>
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
					<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
						<li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
						<li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
						<li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4 ml-md-5">
					<h2 class="ftco-heading-2">Menu</h2>
					<ul class="list-unstyled">
						<li><a href="#" class="py-2 d-block">Shop</a></li>
						<li><a href="#" class="py-2 d-block">About</a></li>
						<li><a href="#" class="py-2 d-block">Journal</a></li>
						<li><a href="#" class="py-2 d-block">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2">Help</h2>
					<div class="d-flex">
						<ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
							<li><a href="#" class="py-2 d-block">Shipping Information</a></li>
							<li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
							<li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
							<li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
						</ul>
						<ul class="list-unstyled">
							<li><a href="#" class="py-2 d-block">FAQs</a></li>
							<li><a href="#" class="py-2 d-block">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2">Have a Questions?</h2>
					<div class="block-23 mb-3">
						<ul>
							<li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
							<li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
							<li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">

				<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
			</div>
		</div>
	</div>
</footer>



<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
@yield('url')
@yield('script')
@include('components/home/script')
</body>
</html>
