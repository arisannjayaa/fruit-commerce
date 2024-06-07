<div class="modal modal-blur fade" id="modal-user" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-user">
				<div class="modal-body">
						<input type="hidden" name="id" id="id" value="">
						<div class="mb-3">
							<label class="form-label">Username</label>
							<input id="username" type="text" class="form-control" name="username" placeholder="username">
						</div>
						<div class="mb-3">
							<label class="form-label">Email</label>
							<input id="email" type="email" class="form-control" name="email" placeholder="email">
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" class="form-control" name="password" placeholder="password">
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
