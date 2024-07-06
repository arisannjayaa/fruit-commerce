@extends('theme.default')

@section('title', 'Laporan')

@section('style')
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
		<button type="button" id="btn-export" class="btn mb-2 h-100 w-auto">
			Export
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
@include('order/modal')
@endsection

@section('url')
<input type="hidden" id="table-url" value="{{ base_url('report/table') }}">
<input type="hidden" id="detail-url" value="{{ base_url('transaction/order/detail/:id') }}">
<input type="hidden" id="export-url" value="{{ base_url('report/export') }}">
@endsection

@section('script')
<script src="{{ base_url('assets/dist/js/report/report.js') }}"></script>
@endsection

