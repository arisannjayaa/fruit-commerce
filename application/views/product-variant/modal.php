<div class="modal modal-blur fade" id="modal-product-variant" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-product-variant">
				<div class="modal-body">
					<input type="hidden" name="id" id="id" value="">
					<div class="mb-3">
						<label class="form-label">Produk</label>
						<select name="category_id" id="category-id" class="form-control">
							<option value="">Pilih produk</option>
							@foreach($products as $product)
							<option value="{{ $product->id }}">{{ $product->title }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-3">
						<label class="form-label">Nama</label>
						<input id="title" type="text" class="form-control" name="name" placeholder="Nama">
					</div>
					<div class="mb-3">
						<label class="form-label">Stok</label>
						<input id="stock" type="number" class="form-control" name="stock" placeholder="stok">
					</div>
					<div class="mb-3">
						<label class="form-label">Harga</label>
						<input id="price" type="text" class="form-control convert-currency" name="price" placeholder="harga">
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
