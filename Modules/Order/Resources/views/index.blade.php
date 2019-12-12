@extends('layouts.mainlayout')
@section('content')
	<!-- Content area -->
	@include('flash-message')
			<div class="content">
				<!-- Basic initialization -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Orders</h5>
					</div>
					
					<div class="panel-body" style="border-top: none;">
						&emsp;&emsp;<button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#modal_form_horizontal_add">Create Order</button>
					</div>
					
					
					<table class="table datatable-button-html5-image data-table" id="tbl_item">
						<thead>
							<tr>
								<th style="text-align:center;display:none;">ID</th>

				                <th style="text-align:center;">Order No.</th>

				                <th style="text-align:center;">Table No.</th>

				                <th style="text-align:center;">Status</th>

				                <th style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($dataOrder as $data)
							<tr>
								<td style="text-align:center;display:none;">{{$data->id}}</td>
								<td style="text-align:center;">{{strtoupper($data->order_num)}}</td>
								<td style="text-align:center;">{{$data->table_num}}</td>
								<td style="text-align:center;">{{ucwords($data->status)}}</td>
								<td style="text-align:center;">
									<button type='button' class='btn btn-primary btn-icon edit' data-toggle='modal' value="" data-target='#modal_form_horizontal_edit'><i class='icon-pencil7'></i></button>
									@if($role == "kasir")
									<button type='button' class='btn btn-info btn-icon payment' data-toggle='modal' value="" data-target='#modal_form_horizontal_payment'><i class='icon-coin-dollar'></i></button>
					            	<button type='button' class='btn btn-danger btn-icon delete'><i class='icon-trash'></i></button>
					            	@endif
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
									
									<h5 class="modal-title">Create Order</h5>
								</div>

								<form id="form_add" action="{{ route('order.store') }}" class="form-horizontal" method="POST">
								{{ csrf_field() }}
									<div class="modal-body">

										<div class="row">
											<div class="col-md-6">
												<fieldset>
													<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Order</legend>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Order No.</label>
														<div class="col-lg-9">
															<input type="text" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Auto Generated" name="order_no" id="order_no" readonly>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Tabel No.</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="table" id="table" required>
														</div>
													</div>

												</fieldset>
											</div>

											<div class="col-md-6">
												<fieldset>
								                	<legend class="font-weight-semibold"><i class="icon-list mr-2"></i> Order Details</legend>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Items</label>
														<div class="col-lg-9">
															<input type="hidden" name="items" id="itemId">
															<select class="form-control select-search" data-placeholder="Select Item" data-fouc id="items">
																<option></option>
																@foreach($items as $idItem => $name)
																	<option value="{{$idItem}}">{{strtoupper($name)}}</option>
																@endforeach
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Price</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="price" id="price" readonly>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Quantity Order</label>
														<div class="col-lg-9">
															<input type="number" class="form-control" name="qty" id="qty">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-5 col-form-label"></label>
														<div class="col-lg-7 text-left">
															<button type="button" class="btn btn-primary btn-labeled btn-labeled-left rounded-round" onclick="addItem()"><b><i class="icon-stack-plus"></i></b> Add</button>
														</div>
													</div>

												</fieldset>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12 text-center">
												<span class="form-text text-danger errTbl" id="errTbl" style="display:none;">*Please Add Item First!</span>
											</div>
										</div>
											
										<div class="row">
											<div class="table-responsive">
												<table class="table" id="list_item">
													<thead>
														<tr>
															<th align="center" style="text-align:center;display:none;">#</th>
															<th align="center" style="text-align:center;">Item</th>
															<th align="center" style="text-align:center;">Quantity</th>
															<th align="center" style="text-align:center;">Price</th>
															<th align="center" style="text-align:center;">Subtotal</th>
															<th align="center" style="text-align:center;"></th>
														</tr>
													</thead>
													<tbody id="list_item_detail">
																		
													</tbody>
												</table>
											</div>
										</div>

										<br>
										<div class="row">
											<div class="col-md-6">
												
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Total</label>
													<div class="col-lg-9">
														<input type="text"  value="0" id="totalMask" class="form-control text-center" readonly>
														<input type="hidden" id="total" name="total" class="form-control text-right" readonly>
													</div>	
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

								<form action="{{ route('order.update') }}" class="form-horizontal" method="POST">
									{{ csrf_field() }}
									<div class="modal-body">

										<div class="row">
											<div class="col-md-6">
												<fieldset>
													<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Order</legend>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Order No.</label>
														<div class="col-lg-9">
															<input type="hidden" class="form-control" name="idOrder" id="idOrder" required>
															<input type="text" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Auto Generated" name="order_no_edit" id="order_no_edit" readonly>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Tabel No.</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="table_edit" id="table_edit" required>
														</div>
													</div>

												</fieldset>
											</div>

											<div class="col-md-6">
												<fieldset>
								                	<legend class="font-weight-semibold"><i class="icon-list mr-2"></i> Order Details</legend>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Items</label>
														<div class="col-lg-9">
															<input type="hidden" name="items_edit" id="itemIdEdit">
															<select class="form-control select-search" data-placeholder="Select Item" data-fouc id="items_edit">
																<option></option>
																@foreach($items as $idItem => $name)
																	<option value="{{$idItem}}">{{strtoupper($name)}}</option>
																@endforeach
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Price</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="price_edit" id="price_edit" readonly>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Quantity Order</label>
														<div class="col-lg-9">
															<input type="number" class="form-control" name="qty_edit" id="qty_edit">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-5 col-form-label"></label>
														<div class="col-lg-7 text-left">
															<button type="button" class="btn btn-primary btn-labeled btn-labeled-left rounded-round" onclick="addItemEdit()"><b><i class="icon-stack-plus"></i></b> Add</button>
														</div>
													</div>

												</fieldset>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12 text-center">
												<span class="form-text text-danger errTbl" id="errTbl" style="display:none;">*Please Add Item First!</span>
											</div>
										</div>
											
										<div class="row">
											<div class="table-responsive">
												<table class="table" id="list_item_edit">
													<thead>
														<tr>
															<th align="center" style="text-align:center;display:none;">#</th>
															<th align="center" style="text-align:center;">Item</th>
															<th align="center" style="text-align:center;">Quantity</th>
															<th align="center" style="text-align:center;">Price</th>
															<th align="center" style="text-align:center;">Subtotal</th>
															<th align="center" style="text-align:center;"></th>
														</tr>
													</thead>
													<tbody id="list_item_edit_detail">
																		
													</tbody>
												</table>
											</div>
										</div>

										<br>
										<div class="row">
											<div class="col-md-6">
												
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Total</label>
													<div class="col-lg-9">
														<input type="text"  value="0" id="totalMaskEdit" class="form-control text-center" readonly>
														<input type="hidden" id="totalEdit" name="totalEdit" class="form-control text-right" readonly>
													</div>	
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

				 <!-- Horizontal form modal Payment-->
					<div id="modal_form_horizontal_payment" class="modal fade" tabindex="-1">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header bg-info">
									
									<h5 class="modal-title">Payment</h5>
								</div>

								<form action="{{ route('order.payment') }}" class="form-horizontal" method="POST">
									{{ csrf_field() }}
									<div class="modal-body">

										<div class="row">
											<div class="col-md-6">
												<fieldset>
													<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Order</legend>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Order No.</label>
														<div class="col-lg-9">
															<input type="hidden" class="form-control" name="idOrderPayment" id="idOrderPayment">
															<input type="text" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Auto Generated" name="order_no_payment" id="order_no_payment" readonly>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Tabel No.</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="table_payment" id="table_payment" readonly>
														</div>
													</div>

												</fieldset>
											</div>
										</div>
											
										<div class="row">
											<div class="table-responsive">
												<table class="table" id="list_item_payment">
													<thead>
														<tr>
															<th align="center" style="text-align:center;display:none;">#</th>
															<th align="center" style="text-align:center;">Item</th>
															<th align="center" style="text-align:center;">Quantity</th>
															<th align="center" style="text-align:center;">Price</th>
															<th align="center" style="text-align:center;">Subtotal</th>
															<th align="center" style="text-align:center;"></th>
														</tr>
													</thead>
													<tbody id="list_item_payment_detail">
																		
													</tbody>
												</table>
											</div>
										</div>

										<br>
										<div class="row">
											<div class="col-md-6">
												
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Total</label>
													<div class="col-lg-9">
														<input type="text"  value="0" id="totalMaskPayment" class="form-control text-center" readonly>
														<input type="hidden" id="totalPayment" name="totalPayment" class="form-control text-right" readonly>
													</div>	
												</div>
											</div>
										</div>

									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
										<button type="submit" id="btnPayment" class="btn btn-primary">Payment</button>
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
		
		$(document).ready(function(){
			$("#tbl_item").on("click", ".edit", function(){
			  var id = $(this).parents('tr:first').find('td:first').text();
			  var order = $(this).parents('tr:first').find('td:eq(1)').text(); 
			  $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "/order/editHeader",
                  method: 'POST',
                  dataType : 'json',
                  data: {
                     id_order: id
                  },
                  success: function(result){
                  	var order_num = result[0].order_num;
                  	var table_num = result[0].table_num;
                    $("#order_no_edit").val(order_num.toUpperCase());
                    $("#table_edit").val(table_num);
                    $("#idOrder").val(id);
                  }
              });

              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "/order/editDetail",
                  method: 'POST',
                  dataType : 'json',
                  data: {
                     order_num: order
                  },
                  success: function(result){
                  	$('#list_item_edit tbody').empty();
                  	for (var i = 0; i < result.length;i++) {
                  		var id_item = result[i].item_id;
				        var item = result[i].name;;
				        var qty = result[i].quantity_order;
				        var qtyMask = parseInt(qty).toLocaleString('id-ID');
				        var price = result[i].price;
				        var priceMask = parseInt(price).toLocaleString('id-ID', { minimumFractionDigits: 2});
				        var sub = parseInt(qty)*parseInt(price);
				        var subMask = sub.toLocaleString('id-ID', { minimumFractionDigits: 2});
                  		var data="<tr>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valEdit["+i+"][idItem]' id='idItemEdit_"+i+"' class='items form-control' value='"+id_item+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='itemEdit_"+i+"' class='form-control' value='"+item.toUpperCase()+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='qtyItemMaskEdit_"+i+"' class='form-control' value='"+qtyMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valEdit["+i+"][qtyItem]' id='qtyItemEdit_"+i+"' class='qty form-control' value='"+qty+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valEdit["+i+"][price]' id='priceEdit_"+i+"' class='priceEdit form-control' value='"+price+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='priceMaskEdit_"+i+"' class='form-control' value='"+priceMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:right;border:none;' type='text' id='subTotalEdit_"+i+"' class='subtotalEdit form-control' value='"+sub+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:right;border:none;' type='text' id='subTotalMaskEdit_"+i+"' class='form-control' value='"+subMask+"' readonly/></td>";
							data +="<td style='text-align:center;'><button type='button' class='del btn btn-outline bg-primary text-primary-800 btn-icon ml-2'><i class='icon-cross3'></i></button></td>";
							data +="</tr>";
							$('#list_item_edit_detail').append(data);
							$("#items_edit").val("").trigger('change');
						    $("#qty_edit").val("");
						    $("#price_edit").val("");
						    kalkulasiEdit();
                  	}
                  	
                  }
              });
			});
		});

		$(document).ready(function(){
			$("#tbl_item").on("click", ".payment", function(){
			  var id = $(this).parents('tr:first').find('td:first').text();
			  var order = $(this).parents('tr:first').find('td:eq(1)').text(); 
			  $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "/order/editHeader",
                  method: 'POST',
                  dataType : 'json',
                  data: {
                     id_order: id
                  },
                  success: function(result){
                  	var order_num = result[0].order_num;
                  	var table_num = result[0].table_num;
                    $("#order_no_payment").val(order_num.toUpperCase());
                    $("#table_payment").val(table_num);
                    $("#idOrderPayment").val(id);
                  }
              });

               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "/order/editDetail",
                  method: 'POST',
                  dataType : 'json',
                  data: {
                     order_num: order
                  },
                  success: function(result){
                  	$('#list_item_payment tbody').empty();
                  	for (var i = 0; i < result.length;i++) {
                  		var id_item = result[i].item_id;
				        var item = result[i].name;;
				        var qty = result[i].quantity_order;
				        var qtyMask = parseInt(qty).toLocaleString('id-ID');
				        var price = result[i].price;
				        var priceMask = parseInt(price).toLocaleString('id-ID', { minimumFractionDigits: 2});
				        var sub = parseInt(qty)*parseInt(price);
				        var subMask = sub.toLocaleString('id-ID', { minimumFractionDigits: 2});
                  		var data="<tr>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valPayment["+i+"][idItem]' id='idItemEdit_"+i+"' class='items form-control' value='"+id_item+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='itemPayment_"+i+"' class='form-control' value='"+item.toUpperCase()+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='qtyItemMaskPayment_"+i+"' class='form-control' value='"+qtyMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valPayment["+i+"][qtyItem]' id='qtyItemPayment_"+i+"' class='qty form-control' value='"+qty+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valPayment["+i+"][price]' id='pricePayment_"+i+"' class='priceEdit form-control' value='"+price+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='priceMaskPayment_"+i+"' class='form-control' value='"+priceMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:right;border:none;' type='text' id='subTotalPayment_"+i+"' class='subtotalPayment form-control' value='"+sub+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:right;border:none;' type='text' id='subTotalMaskPayment_"+i+"' class='form-control' value='"+subMask+"' readonly/></td>";
							data +="<td style='text-align:center;'><button type='button' class='del btn btn-outline bg-primary text-primary-800 btn-icon ml-2'><i class='icon-cross3'></i></button></td>";
							data +="</tr>";
							$('#list_item_payment_detail').append(data);
						    kalkulasiPayment();
                  	}
                  	
                  }
              });
			});
		});

		$(document).ready(function(){
			$("#tbl_item").on("click", ".delete", function(){
			  id = $(this).parents('tr:first').find('td:first').text();
			  num = $(this).parents('tr:first').find('td:eq(1)').text(); 
			  var decision = confirm("Delete Data?");
            	if (decision == true) { 
            		$.ajaxSetup({
		                  headers: {
		                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                  }
		              });
		               jQuery.ajax({
		                  url: "order/delete",
		                  method: 'POST',
		                  data: {
		                     id_order: id,
		                     order_num : num
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

		$("#modal_form_horizontal_payment").on('hide.bs.modal', function(e) {
	        var decision = confirm("Cancel Payment?");
	        if (decision == false) { 
	            e.preventDefault();
	        };
	    });

	    $("#items").on('change', function() {
			if ($("#item").val() != "") {
				$.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              	});
               jQuery.ajax({
                  url: "/order/GetDataItem",
                  method: 'POST',
                  dataType : 'json',
                  data: {
                     id_item: $("#items option:selected").val()
                  },
                  success: function(result){
                    $("#price").val(result.price);
                  }
              });  
			}
	    });

	    $("#items_edit").on('change', function() {
			if ($("#items_edit").val() != "") {
				$.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              	});
               jQuery.ajax({
                  url: "/order/GetDataItem",
                  method: 'POST',
                  dataType : 'json',
                  data: {
                     id_item: $("#items_edit option:selected").val()
                  },
                  success: function(result){
                    $("#price_edit").val(result.price);
                  }
              });  
			}
	    });

	    function kalkulasi() {
            var gt = 0;
            $('.subtotal').each(function() {
                gt += parseInt($(this).val()) || 0;
            });  
            $("#total").val(parseInt(gt));
            var gtMask = gt.toLocaleString('id-ID', { minimumFractionDigits: 2});
            $("#totalMask").val(gtMask);
	    }

	    function kalkulasiEdit() {
            var gt = 0;
            $('.subtotalEdit').each(function() {
                gt += parseInt($(this).val()) || 0;
            });  
            $("#totalEdit").val(parseInt(gt));
            var gtMask = gt.toLocaleString('id-ID', { minimumFractionDigits: 2});
            $("#totalMaskEdit").val(gtMask);
	    }

	    function kalkulasiPayment() {
            var gt = 0;
            $('.subtotalPayment').each(function() {
                gt += parseInt($(this).val()) || 0;
            });  
            $("#totalPayment").val(parseInt(gt));
            var gtMask = gt.toLocaleString('id-ID', { minimumFractionDigits: 2});
            $("#totalMaskPayment").val(gtMask);
	    }

	    $("#form_add").submit(function(e){
	    	var rowcount = document.getElementById('list_item_detail').getElementsByTagName('tr');
	    	var count = rowcount.length;
			if(count < 1) {
		  		$("#errTbl").show();
		      	e.preventDefault();
		  	}
		});

		function addItem() {
	        var id_item = $("#items option:selected").val();
	        var item = $("#items option:selected").html();
	        var qty = $("#qty").val();
	        var qtyMask = parseInt(qty).toLocaleString('id-ID');
	        var price = $("#price").val();
	        var priceMask = parseInt(price).toLocaleString('id-ID', { minimumFractionDigits: 2});
	        var sub = parseInt(qty)*parseInt(price);
	        var subMask = sub.toLocaleString('id-ID', { minimumFractionDigits: 2});
	        var rowcount = document.getElementById('list_item_detail').getElementsByTagName('tr');
	        var double = 0;
	        var count = rowcount.length;
	        if(id_item!="") {
		        if (qty!="") {
		        	$('.items').each(function() {
		                 if (id_item == $(this).val()) {
		                    double++;
		                 }        
		            });

					if (double != 0) {
						alert("This Item is Already Exist!");
						$("#items").val("").trigger('change');
						$("#qty").val("");
						$("#price").val("");
					}
					else {
						var data="<tr>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='val["+count+"][idItem]' id='idItem_"+count+"' class='items form-control' value='"+id_item+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='item_"+count+"' class='form-control' value='"+item+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='qtyItemMask_"+count+"' class='form-control' value='"+qtyMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='val["+count+"][qtyItem]' id='qtyItem_"+count+"' class='qty form-control' value='"+qty+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='val["+count+"][price]' id='price_"+count+"' class='price form-control' value='"+price+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='priceMask_"+count+"' class='form-control' value='"+priceMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:right;border:none;' type='text' id='subTotal_"+count+"' class='subtotal form-control' value='"+sub+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:right;border:none;' type='text' id='subTotalMask_"+count+"' class='form-control' value='"+subMask+"' readonly/></td>";
							data +="<td style='text-align:center;'><button type='button' class='del btn btn-outline bg-primary text-primary-800 btn-icon ml-2'><i class='icon-cross3'></i></button></td>";
							data +="</tr>";
							$('#list_item_detail').append(data);
							$("#items").val("").trigger('change');
						    $("#qty").val("");
						    $("#price").val("");
						    kalkulasi();
						}
		        }
		        else {
		        	alert("Please Input Order Quantity First!");
		        }
	    	}
	        else {
	         	alert("Please Select The Item First!");
	        }
	    }

	    $("#list_item").on('click', '.del', function() {
	        $(this).closest("tr").remove();
	        kalkulasi();
	    });

	    function addItemEdit() {
	        var id_item = $("#items_edit option:selected").val();
	        var item = $("#items_edit option:selected").html();
	        var qty = $("#qty_edit").val();
	        var qtyMask = parseInt(qty).toLocaleString('id-ID');
	        var price = $("#price_edit").val();
	        var priceMask = parseInt(price).toLocaleString('id-ID', { minimumFractionDigits: 2});
	        var sub = parseInt(qty)*parseInt(price);
	        var subMask = sub.toLocaleString('id-ID', { minimumFractionDigits: 2});
	        var rowcount = document.getElementById('list_item_edit_detail').getElementsByTagName('tr');
	        var double = 0;
	        var count = rowcount.length;
	        if(id_item!="") {
		        if (qty!="") {
		        	$('.items').each(function() {
		                 if (id_item == $(this).val()) {
		                    double++;
		                 }        
		            });

					if (double != 0) {
						alert("This Item is Already Exist!");
						$("#items_edit").val("").trigger('change');
						$("#qty_edit").val("");
						$("#price_edit").val("");
					}
					else {
						var data="<tr>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valEdit["+count+"][idItem]' id='idItemEdit_"+count+"' class='items form-control' value='"+id_item+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='itemEdit_"+count+"' class='form-control' value='"+item.toUpperCase()+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='qtyItemMaskEdit_"+count+"' class='form-control' value='"+qtyMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valEdit["+count+"][qtyItem]' id='qtyItemEdit_"+count+"' class='qty form-control' value='"+qty+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:center;border:none;' type='text' name='valEdit["+count+"][price]' id='priceEdit_"+count+"' class='priceEdit form-control' value='"+price+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:center;border:none;' type='text' id='priceMaskEdit_"+count+"' class='form-control' value='"+priceMask+"' readonly/></td>";
							data +="<td style='text-align:center;display:none;'><input style='text-align:right;border:none;' type='text' id='subTotalEdit_"+count+"' class='subtotalEdit form-control' value='"+sub+"' readonly/></td>";
							data +="<td style='text-align:center;'><input style='text-align:right;border:none;' type='text' id='subTotalMaskEdit_"+count+"' class='form-control' value='"+subMask+"' readonly/></td>";
							data +="<td style='text-align:center;'><button type='button' class='del btn btn-outline bg-primary text-primary-800 btn-icon ml-2'><i class='icon-cross3'></i></button></td>";
							data +="</tr>";
							$('#list_item_edit_detail').append(data);
							$("#items_edit").val("").trigger('change');
						    $("#qty_edit").val("");
						    $("#price_edit").val("");
						    kalkulasiEdit();
						}
		        }
		        else {
		        	alert("Please Input Order Quantity First!");
		        }
	    	}
	        else {
	         	alert("Please Select The Item First!");
	        }
	    }

	    $("#list_item_edit").on('click', '.del', function() {
	        $(this).closest("tr").remove();
	        kalkulasiEdit();
	    });
              
      </script>
@endsection