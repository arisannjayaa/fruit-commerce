@extends('theme.default')

@section('title', 'Pembayaran')

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
		<select name="status" id="status" class="form-control w-auto">
			<option value="">Semua</option>
			<option value="201">Pending</option>
			<option value="407">Expired</option>
			<option value="200">Berhasil</option>
		</select>
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
						<th>Total</th>
						<th>Tipe</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('payment/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('transaction/payment/table') }}">
<input type="hidden" id="detail-url" value="{{ base_url('transaction/order/detail/:id') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/transaction/payment.js') }}"></script>
@endsection

