@extends('theme.default')

@section('title', 'Kategori')

@section('style')
@endsection

@section('content')
<div class="row row-cards">
	<div class="col-lg-12">
		<button type="button" id="btn-add" class="btn mb-2" data-bs-toggle="modal">
			Tambah Kategori
		</button>
		<div class="card">
			<div class="table-responsive">
				<table id="table"
					class="table table-vcenter card-table">
					<thead>
					<tr>
						<th>No</th>
						<th>Kategori</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('category/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('category/table') }}">
<input type="hidden" id="create-url" value="{{ base_url('category/store') }}">
<input type="hidden" id="update-url" value="{{ base_url('category/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('category/delete') }}">
<input type="hidden" id="edit-url" value="{{ base_url('category/edit/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/category/category.js') }}"></script>
@endsection

