@extends('theme.default')

@section('title', 'Pemesanan')

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
	<div class="d-flex" style="gap: 10px">
		<input type="text" class="form-control w-auto" name="daterange" value="01/01/2018 - 01/15/2018" />
		<button type="button" id="btn-add" class="btn mb-2 h-100 w-auto" data-bs-toggle="modal">
			Filter
		</button>
	</div>
	<div class="col-lg-12">
		<div class="card">
			<div class="table-responsive">
				<table id="table"
					   class="table table-vcenter card-table">
					<thead>
					<tr>
						<th>No</th>
						<th>Invoice</th>
						<th>Total</th>
						<th>Tipe Pembayaran</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('transaction/order/table') }}">
<input type="hidden" id="create-url" value="{{ base_url('transaction/order/store') }}">
<input type="hidden" id="update-url" value="{{ base_url('transaction/order/update') }}">
<input type="hidden" id="delete-url" value="{{ base_url('transaction/order/delete') }}">
<input type="hidden" id="edit-url" value="{{ base_url('transaction/order/edit/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/transaction/order.js') }}"></script>

@endsection

