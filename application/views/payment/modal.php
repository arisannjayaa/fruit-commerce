<div class="modal modal-blur fade" id="modal-order" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 text-end">
						<p class="h3" id="fullname">Client</p>
						<address>
							<div id="email">Email</div>
							<div id="telephone">Telephone</div>
							<div>
								<span id="address">Address</span> <br>
								<span id="state">State</span>,
								<span id="city">City</span> <br>
								<span id="postal-code">Postal Code</span>
							</div>
						</address>
					</div>
					<div class="col-12 my-5">
						<a id="location" href="" class="badge bg-primary d-flex align-items-center" style="width: max-content; gap: 6px">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" /></svg>
							Lokasi Pembeli
						</a>
						<h1>Invoice <span id="invoice"></span></h1><div class="d-inline" id="status"></div>
					</div>
				</div>
				<table class="table table-transparent table-responsive">
					<thead>
					<tr>
						<th class="text-center" style="width: 1%"></th>
						<th>Product</th>
						<th class="text-center" style="width: 2%">Qnt</th>
						<th class="text-end" style="width: 20%">Harga</th>
						<th class="text-end" style="width: 20%">Jumlah</th>
					</tr>
					</thead>
					<tbody id="order-detail"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
					Cancel
				</a>
				<a target="_blank" href="javascript:void(0)" class="btn btn-primary ms-auto" id="btn-print">
					Cetak
				</a>
			</div>
		</div>
	</div>
</div>
