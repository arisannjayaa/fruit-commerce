@extends('theme.default')

@section('title', 'Varian Produk')

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
@endsection

@section('content')
<div class="row row-cards">
	<div class="col-lg-12">
		<button type="button" id="btn-add" class="btn mb-2" data-bs-toggle="modal">
			Tambah Varian Produk
		</button>
		<div class="card">
			<div class="table-responsive">
				<table id="table"
					class="table table-vcenter card-table">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Stok</th>
						<th>Harga</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('product-variant/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('product-variant/table') }}">
<input type="hidden" id="create-url" value="{{ base_url('product-variant/store') }}">
<input type="hidden" id="update-url" value="{{ base_url('product-variant/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('product-variant/delete') }}">
<input type="hidden" id="edit-url" value="{{ base_url('product-variant/edit/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/product/variant.js') }}"></script>
@endsection

