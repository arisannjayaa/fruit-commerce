<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
	@include('components/home/css')
	<!-- Helpers -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.css">
</head>
<body class="goto-here">
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-12 p-0 d-none d-lg-block">
			<div style="background-image: url(<?= base_url('assets/home/images/about.jpg') ?>); height: 100vh; width: 100%; background-size: cover;">
			</div>
		</div>
		<div class="col-lg-4 col-12">
			<div style="padding: 20px">
				<div class="form-wrap mt-lg-4 mt-5">
					<h4>Login</h4>
					<p>Selamat Datang di Portal Bu Jem Jem's Stall. Isi Detail Login Anda dan Mari Mulai Petualangan!</p>
					<form id="form-login">
						<div class="row">
							<div class="col-12">
								<div class="mb-3">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="email">
								</div>
							</div>
							<div class="col-12">
								<div class="mb-3">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password" id="password">
								</div>
							</div>
							<div class="col-12">
								<div class="mb-3">
									<div class="w-100">
										<button type="submit" id="btn-login" class="btn btn-primary w-100">Login</button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="text-center">
						<p>Belum memiliki akun? <a href="<?= base_url('register') ?>">Buat akun</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="login-url" value="<?= base_url('login') ?>">
<script src="<?= base_url('assets/') ?>dist/js/login.js" defer></script>
@include('components/script')
</body>
</html>
