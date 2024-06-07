<div class="modal modal-blur fade" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-product">
				<div class="modal-body">
					<input type="hidden" name="id" id="id" value="">
					<div class="mb-3">
						<label class="form-label">Judul</label>
						<input id="title" type="text" class="form-control" name="title" placeholder="judul">
					</div>
					<div class="mb-3">
						<label class="form-label">Kategori</label>
						<select name="category_id" id="category-id" class="form-control">
							<option value="">Pilih kategori</option>
						</select>
					</div>
					<div class="mb-3">
						<label class="form-label">Stok</label>
						<input id="stock" type="text" class="form-control" name="stock" placeholder="stok">
					</div>
					<div class="mb-3">
						<label class="form-label">Harga Normal</label>
						<input id="normal_price" type="text" class="form-control" name="normal_price" placeholder="harga normal">
					</div>
					<div class="mb-3">
						<label class="form-label">Harga Promosi</label>
						<input id="promotion_price" type="text" class="form-control" name="promotion_price" placeholder="harga promosi">
					</div>
					<div class="mb-3">
						<label class="form-label">Deskripsi</label>
						<textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
						Cancel
					</a>
					<button type="submit" class="btn btn-primary ms-auto" id="btn-submit">
						Submit
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
