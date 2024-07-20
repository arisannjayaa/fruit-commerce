@extends('theme.default')

@section('title', 'Profil')

@section('style')
<style>
	span.file-icon p {
		font-size: 12px !important;
	}

	.dropify-wrapper.error {
		border: 1px solid red !important;
	}

	.description.error {
		border: 1px solid red !important;
	}

	.invalid-feedback-description {
		display: block;
		width: 100%;
		margin-top: .25rem;
		font-size: 85.714285%;
		color: var(--tblr-form-invalid-color);
	}
</style>
<style>
	.img-profile {
		height: 300px;
		width: 100%;
		object-fit: cover;
		border-radius: 10px !important;
	}

	.nav-link.active {
		color: #fff !important;
		background-color: #82ae46 !important;
	}

	.address.active {
		border: 1px solid #82ae46 !important;
	}

	td {
		width: 200px !important;
		padding: 10px 0 !important;
	}
</style>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<div class="row row-cards">
			<div class="col-4">
				<div class="d-flex flex-column justify-content-center" style="gap: 10px;">
					<img src="<?= base_url($user->attachment ?? 'assets/dist/img/face.png') ?>" alt="profile" class="img-profile">
					<button data-id="<?= $user->id ?>" class="btn btn-primary w-100 edit">Ubah Biodata</button>
				</div>
			</div>
			<div class="col-6">
				<h5>Detail</h5>
				<table>
					<tr>
						<td>Nama Lengkap</td>
						<td><?= $user->first_name . ' ' . $user->last_name ?></td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td><?= $user->telephone ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?= $user->email ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
@include('profile/modal')
@endsection

@section('url')
<input type="hidden" id="edit-url" value="<?= base_url('user/settings/edit/:id') ?>">
<input type="hidden" id="update-url" value="<?= base_url('user/settings/update') ?>">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/user/profile.js') }}"></script>
@endsection

