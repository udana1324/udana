@extends('layouts.mainlayout')
@section('content')
	<!-- Content area -->
	@include('flash-message')
			<div class="content">
				<!-- Basic initialization -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Report Orders</h5>
					</div>
					
					<table class="table datatable-button-html5-image data-table" id="tbl_item">
						<thead>
							<tr>
								<th style="text-align:center;display:none;">ID</th>

				                <th style="text-align:center;">Order No.</th>

				                <th style="text-align:center;">Table No.</th>

				                <th style="text-align:center;">Total Price</th>

				                <th style="text-align:center;">Status</th>


							</tr>
						</thead>
						<tbody>
							@foreach($dataOrder as $data)
							<tr>
								<td style="text-align:center;display:none;">{{$data->id}}</td>
								<td style="text-align:center;">{{strtoupper($data->order_num)}}</td>
								<td style="text-align:center;">{{$data->table_num}}</td>
								<td style="text-align:center;">{{ucwords($data->status)}}</td>
								<td style="text-align:right;">{{number_format($data->total_price)}}</td>
					        </tr>
					        @endforeach
						</tbody>
					</table>
				</div>
				<!-- /basic initialization -->
			</div>
			<!-- /content area -->
@endsection
@section('scripts')
	<script type="text/javascript">
		
	</script>
@endsection