<div class="modal fade" id="modal-transaction" tabindex="-1" aria-labelledby="modal-transaction-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-transaction-label">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="d-flex flex-column mb-3">
					<div class="d-flex justify-content-between align-items-center">
						<span>Status Pesanan</span>
						<span id="status">Selesai</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span>No. Invoice</span>
						<span id="invoice-id">HR-293892389283</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span>Tanggal Pembelian</span>
						<span id="date-transaction">19 Juni 2024</span>
					</div>
				</div>

				<div class="d-flex flex-column">
					<h6>Detail Produk</h6>
					<div style="overflow-y: auto; max-height: 400px;">
						<div class="first-product"></div>
						<div class="collapse" id="collapse-product"></div>
					</div>
					<div id="collapse-container" class="my-2"></div>
				</div>

				<div class="d-flex flex-column">
					<h6>Rincian Pembayaran</h6>
					<div class="d-flex justify-content-between align-items-center">
						<span>Metode Pembayaran</span>
						<span id="payment-type">BCA</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span>Total Harga</span>
						<span id="gross-amount">Rp.100000</span>
					</div>

					<div class="d-flex justify-content-between align-items-center">
						<p class="fw-bold">Total Belanja</p>
						<p style="font-weight: bold!important" id="total-shop">Rp.100000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
