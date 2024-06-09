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
		<div class="col-lg-6 col-12 p-0 d-none d-lg-block">
			<div style="background-image: url(<?= base_url('assets/home/images/about.jpg') ?>); height: 100%; width: 100%; background-size: cover; background-position: center center">
			</div>
		</div>
		<div class="col-lg-6 col-12">
			<div style="padding: 20px">
				<button onclick="location.href='<?= base_url('') ?>'" class="btn btn-primary"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></button>
				<div class="form-wrap mt-3">
					<h4>Register</h4>
					<p>Selamat Datang di Portal Bu Jem Jem's Stall. Isi Detail Register Anda dan Mari Mulai Petualangan!</p>
					<form id="form-register">
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-3">
									<label for="first_name">Nama Depan</label>
									<input type="text" class="form-control" name="first_name" id="first-name">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="mb-3">
									<label for="last_name">Nama Belakang</label>
									<input type="text" class="form-control" name="last_name" id="last-name">
								</div>
							</div>
							<div class="col-12">
								<div class="mb-3">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="email">
								</div>
							</div>
							<div class="col-12">
								<div class="mb-3">
									<label for="username">Username</label>
									<input type="text" class="form-control" name="username" id="username">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="mb-3">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password" id="password">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="mb-3">
									<label for="confirm_password">Konfirmasi Password</label>
									<input type="password" class="form-control" name="confirm_password" id="confirm_password">
								</div>
							</div>
							<div class="col-12">
								<div class="mb-3">
									<div class="w-100">
										<button type="submit" id="btn-register" class="btn btn-primary w-100">Register</button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="text-center">
						<p>Sudah memiliki akun? <a href="<?= base_url('login') ?>">Login</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="register-url" value="<?= base_url('register') ?>">
@include('components/script')
<script src="<?= base_url('assets/') ?>dist/js/register.js" defer></script>
</body>
</html>
