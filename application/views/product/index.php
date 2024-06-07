@extends('theme.default')

@section('title', 'Produk')

@section('style')
@endsection

@section('content')
<div class="row row-cards">
	<div class="col-lg-12">
		<button type="button" id="btn-add" class="btn mb-2" data-bs-toggle="modal">
			Tambah Produk
		</button>
		<div class="card">
			<div class="table-responsive">
				<table id="table"
					class="table table-vcenter card-table">
					<thead>
					<tr>
						<th>No</th>
						<th>Judul</th>
						<th>Stok</th>
						<th>Harga Normal</th>
						<th>Harga Promo</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('product/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('product/table') }}">
<input type="hidden" id="create-url" value="{{ base_url('product/store') }}">
<input type="hidden" id="update-url" value="{{ base_url('product/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('product/delete') }}">
<input type="hidden" id="edit-url" value="{{ base_url('product/edit/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/product/product.js') }}"></script>
@endsection

