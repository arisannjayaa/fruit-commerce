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
						</address>
					</div>
					<div class="col-12 my-5">
						<h1>Invoice <span id="invoice"></span></h1>
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
			</div>
		</div>
	</div>
</div>
