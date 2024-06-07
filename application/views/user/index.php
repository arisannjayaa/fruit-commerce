@extends('theme.default')

@section('title', 'User')

@section('style')
@endsection

@section('content')
<div class="row row-cards">
	<div class="col-lg-12">
		<button type="button" id="btn-add" class="btn mb-2" data-bs-toggle="modal">
			Tambah User
		</button>
		<div class="card">
			<div class="table-responsive">
				<table id="table"
					class="table table-vcenter card-table">
					<thead>
					<tr>
						<th>No</th>
						<th>Username</th>
						<th>Email</th>
						<th>Role</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('user/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('user/table') }}">
<input type="hidden" id="create-url" value="{{ base_url('user/store') }}">
<input type="hidden" id="update-url" value="{{ base_url('user/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('user/delete') }}">
<input type="hidden" id="edit-url" value="{{ base_url('user/edit/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/user/user.js') }}"></script>
@endsection

