<div class="modal fade" id="modal-address" tabindex="-1" aria-labelledby="modal-transaction-label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="form-address">
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
						<label for="addressee">Nama Penerima</label>
						<input type="text" class="form-control" id="addressee" name="addressee">
					</div>
					<div class="form-group">
						<label for="telephone">Telephone</label>
						<input type="text" class="form-control" id="telephone" name="telephone">
					</div>
					<hr>
					<div class="form-group">
						<label for="label">Label Alamat</label>
						<input type="text" class="form-control" id="label" name="label">
					</div>
					<div class="form-group">
						<label for="address">Alamat Lengkap</label>
						<textarea type="text" class="form-control" id="address" name="address"></textarea>
					</div>
					<div class="form-group">
						<label for="postal_code">Kode POS</label>
						<input type="text" class="form-control" id="postal_code" name="postal_code">
					</div>
					<div class="form-check" id="check-is-primary">
						<input class="form-check-input" type="checkbox" value="true" id="is-primary" name="is_primary">
						<label class="form-check-label" for="is-primary">
							Jadikan Alamat Utama
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="btn-submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</form>
	</div>
</div>
