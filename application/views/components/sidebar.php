<ul class="navbar-nav pt-lg-3">
	<li class="nav-item <?= $this->uri->uri_string() == 'dashboard' ? 'active' : '' ?>">
		<a class="nav-link" href="./">
			<span class="nav-link-icon d-md-none d-lg-inline-block">
				<!-- Download SVG icon from http://tabler-icons.io/i/home -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
					stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
					<path d="M5 12l-2 0l9 -9l9 9l-2 0" />
					<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
					<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
			</span>
			<span class="nav-link-title">
				Dashboard
			</span>
		</a>
	</li>
	<li class="nav-item dropdown <?= $this->uri->uri_string() == 'master' ? 'show' : '' ?>">
		<a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
			role="button" aria-expanded="false">
			<span class="nav-link-icon d-md-none d-lg-inline-block">
				<!-- Download SVG icon from http://tabler-icons.io/i/package -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
					stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
					<path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
					<path d="M12 12l8 -4.5" />
					<path d="M12 12l0 9" />
					<path d="M12 12l-8 -4.5" />
					<path d="M16 5.25l-8 4.5" /></svg>
			</span>
			<span class="nav-link-title">
				Master
			</span>
		</a>
		<div class="dropdown-menu <?= $this->uri->uri_string() == 'master' ? 'show' : '' ?>">
			<div class="dropdown-menu-columns">
				<div class="dropdown-menu-column">
					<a class="dropdown-item" href="./accordion.html">
						Kategori
					</a>
				</div>
				<div class="dropdown-menu-column">
					<a class="dropdown-item" href="./accordion.html">
						Buah dan Sayur
					</a>
				</div>
			</div>
		</div>
	</li>
	<li class="nav-item <?= $this->uri->uri_string() == 'user' ? 'active' : '' ?>">
		<a class="nav-link" href="">
			<span class="nav-link-icon d-md-none d-lg-inline-block">
				<!-- Download SVG icon from http://tabler-icons.io/i/home -->
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
			</span>
			<span class="nav-link-title">
				Management User
			</span>
		</a>
	</li>
	<li class="nav-item <?= $this->uri->uri_string() == 'order' ? 'active' : '' ?>">
		<a class="nav-link" href="">
			<span class="nav-link-icon d-md-none d-lg-inline-block">
				<!-- Download SVG icon from http://tabler-icons.io/i/home -->
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-invoice"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M19 12v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-14a2 2 0 0 1 2 -2h7l5 5v4.25" /></svg>
			</span>
			<span class="nav-link-title">
				Pemesanan
			</span>
		</a>
	</li>
	<li class="nav-item <?= $this->uri->uri_string() == 'payments' ? 'active' : '' ?>">
		<a class="nav-link" href="./">
			<span class="nav-link-icon d-md-none d-lg-inline-block">
				<!-- Download SVG icon from http://tabler-icons.io/i/home -->
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-credit-card-pay"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" /><path d="M3 10h18" /><path d="M16 19h6" /><path d="M19 16l3 3l-3 3" /><path d="M7.005 15h.005" /><path d="M11 15h2" /></svg>
			</span>
			<span class="nav-link-title">
				Pembayaran
			</span>
		</a>
	</li>
	<li class="nav-item <?= $this->uri->uri_string() == 'report' ? 'active' : '' ?>">
		<a class="nav-link" href="./">
			<span class="nav-link-icon d-md-none d-lg-inline-block">
				<!-- Download SVG icon from http://tabler-icons.io/i/home -->
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-report"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" /><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" /><path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8 11h4" /><path d="M8 15h3" /></svg>
			</span>
			<span class="nav-link-title">
				Laporan
			</span>
		</a>
	</li>
</ul>
