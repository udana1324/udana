@extends('layouts.mainlayout')
@section('content')
	<!-- Content area -->
	@include('flash-message')
			<div class="content">
				<!-- Basic initialization -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Food and Beverages</h5>
					</div>
					<div class="panel-body" style="border-top: none;">
						&emsp;&emsp;<button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#modal_form_horizontal_add">Add Data</button>
					</div>
					
					<table class="table datatable-button-html5-image data-table" id="tbl_item">
						<thead>
							<tr>
								<th style="text-align:center;display:none;">ID</th>

				                <th style="text-align:center;">Code</th>

				                <th style="text-align:center;">Name</th>

				                <th style="text-align:center;">Category</th>

				                <th style="text-align:center;">Price</th>

				                <th style="text-align:center;">Status</th>

				                <th style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $data)
							<tr>
								<td style="text-align:center;display:none;">{{$data->id}}</td>
								<td style="text-align:center;">{{strtoupper($data->code)}}</td>
								<td>{{ucwords($data->name)}}</td>
								<td style="text-align:center;">{{ucwords($data->category)}}</td>
								<td style="text-align:center;">{{number_format($data->price)}}</td>
								@if ($data->flag_ready == 'Y')
								<td style="text-align:center;">Ready</td>
								@else
								<td style="text-align:center;">Not Ready</td>
								@endif
								<td style="text-align:center;">
									<button type='button' class='btn btn-primary btn-icon edit' data-toggle='modal' value="" data-target='#modal_form_horizontal_edit'><i class='icon-pencil7'></i></button>
					            	<button type='button' class='btn btn-danger btn-icon delete'><i class='icon-trash'></i></button>
					            </td>
					        </tr>
					        @endforeach
						</tbody>
					</table>
				</div>
				<!-- /basic initialization -->

				 <!-- Horizontal form modal Add-->
					<div id="modal_form_horizontal_add" class="modal fade" tabindex="-1">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header bg-info">
									
									<h5 class="modal-title">Add</h5>
								</div>

								<form action="{{ route('food.store') }}" class="form-horizontal" method="POST">
								{{ csrf_field() }}
									<div class="modal-body">

										<div class="form-group">
											<label class="control-label col-sm-3">Name</label>
											<div class="col-sm-12">
												<input type="text" name="name" class="form-control" required>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-3">Category</label>
											<div class="col-sm-12">
												<select class="form-control select-search" data-fouc id="category" name="category">
													<option value="food">Food</option>
													<option value="drink">Drink</option>
													<option value="snack">Snack</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-3">Price</label>
											<div class="col-sm-12">
												<input type="number" name="price" class="form-control" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-form-label col-lg-3">Status</label>
											<div class="col-lg-9">
												<div class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" value="Y" name="status" id="custom_radio_stacked_checked" checked>
													<label class="custom-control-label" for="custom_radio_stacked_checked">Ready</label>
												</div>
												<div class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" value="N" name="status" id="custom_radio_stacked_unchecked">
													<label class="custom-control-label" for="custom_radio_stacked_unchecked">Not Ready</label>
												</div>
											</div>
										</div>

									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Submit form</button>
									</div>
								</form>

							</div>
						</div>
					</div>
				 <!-- /horizontal form modal --> 

				 <!-- Horizontal form modal Edit-->
					<div id="modal_form_horizontal_edit" class="modal fade" tabindex="-1">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header bg-info">
									
									<h5 class="modal-title">Edit</h5>
								</div>

								<form action="{{ route('food.update') }}" class="form-horizontal" method="POST">
									{{ csrf_field() }}
									<div class="modal-body">

										<div class="form-group">
											<label class="control-label col-sm-3">Name</label>
											<div class="col-sm-12">
												<input type="hidden" name="id_item" id="id_item" class="form-control">
												<input type="text" name="name_edit" id="name_edit" class="form-control" required>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-3">Category</label>
											<div class="col-sm-12">
												<select class="form-control select-search" data-fouc id="category_edit" name="category_edit">
													<option value="food">Food</option>
													<option value="drink">Drink</option>
													<option value="snack">Snack</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-3">Price</label>
											<div class="col-sm-12">
												<input type="number" name="price_edit" id="price_edit" class="form-control" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-form-label col-lg-3">Status</label>
											<div class="col-lg-9">
												<div class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" value="Y" name="status_edit" id="status_edit_y" checked>
													<label class="custom-control-label" for="status_edit_y">Ready</label>
												</div>
												<div class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" value="N" name="status_edit" id="status_edit_n">
													<label class="custom-control-label" for="status_edit_n">Not Ready</label>
												</div>
											</div>
										</div>

									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
										<button type="submit" id="btnUpdate" class="btn btn-primary">Submit form</button>
									</div>
								</form>

							</div>
						</div>
					</div>
				 <!-- /horizontal form Edit --> 
			</div>
			<!-- /content area -->
@endsection
@section('scripts')
	<script type="text/javascript">
		var nm = "";
		var ket = "";
		var id = "";
		$(document).ready(function(){
			$("#tbl_item").on("click", ".edit", function(){
			  id = $(this).parents('tr:first').find('td:first').text();
			  name = $(this).parents('tr:first').find('td:eq(2)').text();
			  category = $(this).parents('tr:first').find('td:eq(3)').text();
			  price = $(this).parents('tr:first').find('td:eq(4)').text();
			  status = $(this).parents('tr:first').find('td:eq(5)').text();
			  category = category.toLowerCase();
			  price = parseInt(price.replace(/\,/g,''), 10);
			  $("#id_item").val(id);
			  $("#name_edit").val(name);
			  $("#category_edit").val(category).trigger('change');
			  $("#price_edit").val(price);
			  if (status == "Ready") {
			  	$("#status_edit_y").trigger('click');
			  }
			  else {
			  	$("#status_edit_n").trigger('click');
			  }
			});
		});

		$(document).ready(function(){
			$("#tbl_item").on("click", ".delete", function(){
			  id = $(this).parents('tr:first').find('td:first').text();
			  name = $(this).parents('tr:first').find('td:eq(2)').text(); 
			  var decision = confirm("Delete Data?");
            	if (decision == true) { 
            		$.ajaxSetup({
		                  headers: {
		                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                  }
		              });
		               jQuery.ajax({
		                  url: "food/delete",
		                  method: 'POST',
		                  data: {
		                     id_item: id,
		                     name : name
		                  },
		                  success: function(result){
		                     location.reload();
		                  }
		              });
            	};
			});
		});

		$("#modal_form_horizontal_edit").on('hide.bs.modal', function(e) {
	        var decision = confirm("Cancel Edit?");
	        if (decision == false) { 
	            e.preventDefault();
	        };
	    });
              
      </script>
@endsection