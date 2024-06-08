<div class="container">
	<a class="navbar-brand" href="index.html">Vegefoods</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="oi oi-menu"></span> Menu
	</button>

	<div class="collapse navbar-collapse" id="ftco-nav">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item <?= $this->uri->uri_string() == "" ? "active" : "" ?>"><a href="index.html" class="nav-link">Home</a></li>
			<li class="nav-item <?= $this->uri->uri_string() == "shop" ? "active" : "" ?>"><a href="<?= base_url('shop') ?>" class="nav-link">Shop</a></li>
			<li class="nav-item <?= $this->uri->uri_string() == "about" ? "active" : "" ?>"><a href="about.html" class="nav-link">About</a></li>
			<li class="nav-item <?= $this->uri->uri_string() == "contact" ? "active" : "" ?>"><a href="contact.html" class="nav-link">Contact</a></li>
			<li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="javascript:void(0)" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akun</a>
				<div class="dropdown-menu" aria-labelledby="dropdown04">
					@if($this->auth->isAdmin())
						<a class="dropdown-item" href="<?= base_url('dashboard') ?>">Dashboard</a>
					@endif
					@if(!$this->auth->check())
						<a class="dropdown-item" href="<?= base_url('login') ?>">Login</a>
					@else
						<a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a>
					@endif
				</div>
			</li>
		</ul>
	</div>
</div>
