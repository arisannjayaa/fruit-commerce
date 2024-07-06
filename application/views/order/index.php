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
		<input type="text" class="form-control w-auto" id="dates" name="dates" value="" />
		<button type="button" id="btn-filter" class="btn mb-2 h-100 w-auto" data-bs-toggle="modal">
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
						<th>Status</th>
						<th>Total</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('order/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('transaction/order/table') }}">
<input type="hidden" id="detail-url" value="{{ base_url('transaction/order/detail/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/transaction/order.js') }}"></script>
@endsection

