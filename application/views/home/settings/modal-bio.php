<div class="modal fade" id="modal-profile" tabindex="-1" aria-labelledby="modal-transaction-label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="form-profile">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-transaction-label">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" id="id" name="id">
					<div class="form-group">
						<div class="custom-file"></div>
					</div>
					<div class="form-group">
						<label for="addressee">Nama Awal</label>
						<input type="text" class="form-control" id="first-name" name="first_name">
					</div>
					<div class="form-group">
						<label for="telephone">Nama Akhir</label>
						<input type="text" class="form-control" id="last-name" name="last_name">
					</div>
					<hr>
					<div class="form-group">
						<label for="label">Telepon</label>
						<input type="text" class="form-control" id="telephone" name="telephone">
					</div>
					<div class="form-group">
						<label for="address">Email</label>
						<input type="email" class="form-control" id="email" name="email">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>
