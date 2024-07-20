<div class="modal modal-blur fade" id="modal-profile" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-profile">
				<div class="modal-body">
					<input type="hidden" name="id" id="id" value="">
					<div class="mb-3">
						<div class="custom-file"></div>
					</div>
					<div class="mb-3">
						<label class="form-label">Nawal Awal</label>
						<input id="first-name" type="text" class="form-control" name="first_name" placeholder="Nama Awal">
					</div>
					<div class="mb-3">
						<label class="form-label">Nawal Akhir</label>
						<input id="last-name" type="text" class="form-control" name="last_name" placeholder="Nama Akhir">
					</div>
					<div class="mb-3">
						<label class="form-label">Telepon</label>
						<input id="telephone" type="number" class="form-control" name="telephone" placeholder="Telepon">
					</div>
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input id="email" type="email" class="form-control convert-currency" name="email" placeholder="Email">
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
