<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt | Store Coupon')
@section('content')
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-left">
			<a href="javascript:void(0)" class="btn btn-primary pull-left CreateCoupon">
			<i class="fa fa-fw fa-user "></i>
				<span class="text">Add New Coupon</span>
			</a>
		</div>

	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="storedatatable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Store</th>
					<th>Amount</th>
					<th>Valid Offer</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
			<tfoot>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Store</th>
					<th>Amount</th>
					<th>Valid Offer</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="modal fade in" id="CouponModal">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span></button>
		<h4 class="modal-title" id="CouponModalLabel" >Default Modal</h4>
	  </div>
	  <div class="modal-body">
		<form id="CreateCouponForm" enctype="multipart/form-data">
			<input type="hidden" class="edit_method" name="_method" value="put">
			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="CouponId" />
			<div class="form-group">
				<select name="store_id" id="merchant" class="form-control form-control-user">
					<option value="">-- Select Store --</option>
				</select>
				<span id="store_id_error" class="help-block"></span>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="title" id="title" placeholder="Enter Title..." />
				<span id="title_error" class="help-block"></span>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="amount" id="amount" placeholder="Enter Amount..." />
				<span id="amount_error" class="help-block"></span>
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user datepicker1" name="offer_valid" id="offer_valid"  placeholder="Enter Offer Valid..." />
				<span id="offer_valid_error" class="help-block"></span>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="CreateCouponButton" name="CreateCoupon">Create Store</button>
			  </div>
		</form>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@endsection

@section('js')
	<script>
		$('.datepicker1').datepicker({
		    format: "dd/mm/yyyy",
		});
		 $(function() {
			getmerchant();
			 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
               $('#storedatatable').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ url('/admin/coupon') }}",
               columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex' },
					{data: 'title', name: 'title'},
					{data: 'store.title', name: 'store.title'},
					{data: 'amount', name: 'amount'},
					{data: 'offer_valid', name: 'offer_valid'},
					{data: 'action', name: 'action'},
				],
				"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0, 5 ] },
                { "bSearchable": false, "aTargets": [ 0, 5 ] }
				]
            });
			function getmerchant(){
				$.ajax({
					url: "{{ url('admin/get-store') }}",
					method: 'get',
					success: function(result){
						$("#merchant").html(result.data);
					}
				});
			}
			$(document).on("click",".CreateCoupon",function() {
				$('.edit_method').val("post");
				$('.Errors').html('');
				$( "#CreateCouponForm div.form-group").removeClass("has-error");
				$( "#CreateCouponForm div.form-group span").hide();
				$('#CreateCouponForm').trigger("reset");
				$('#CouponId').val('');
				$('#CouponModalLabel').html('Add Coupon');
				$('#CreateCouponButton').html('Add Coupon');
				$('#CouponModal').modal('show');
			});
			 $(document).on("click","#EditCoupon",function() {
				$('.edit_method').val("put");
				$('.Errors').html('');
				$( "#CreateCouponForm div.form-group").removeClass("has-error");
				$( "#CreateCouponForm div.form-group span").hide();
				var Id = $(this).attr('data-id');
				$.ajax({
					url: "{{ url('admin/coupon/') }}/" + Id,
					method: 'get',
					success: function(result){
						$('#CouponModalLabel').html('Edit Coupon');
						$('#CreateCouponButton').html('Edit Coupon');
						$('#CouponId').val(result.data.id);
						$("#title").val(result.data.title);
						$("#amount").val(result.data.amount);
						$("#offer_valid").val(result.data.offer_valid);
						$("#merchant").val(result.data.store_id);
						$('#CouponModal').modal('show');
					}

				});

			});

			$(document).on("click","#DeleteCoupon",function() {
				var Id = $(this).attr('data-id');
				if (confirm("Are you sure?")) {
					$.ajax({
						url: "{{ url('admin/coupon') }}/"+Id,
						method: 'DELETE',
						success: function(result){
							$('#storedatatable').DataTable().ajax.reload();
						}
					});
				}
				return false;
			});

			$( "#CreateCouponForm" ).on('submit',(function( event ) {
				$( "#CreateCouponForm div.form-group").removeClass("has-error");
				$( "#CreateCouponForm div.form-group span").hide();
				event.preventDefault();
				let data = $(this).serializeArray(); // new FormData(this);
				let method = 'post';
				let url = "{{ url('admin/coupon') }}";
				if(	$('#CouponId').val()){
					method = "post";
					url =  "{{ url('admin/coupon')}}/" + $('#CouponId').val();
				}
			$.ajax({
					url: url,
					method: method,
					//dataType : 'json',
					contentType: false,
					processData:false,
					data: new FormData(this),
					success: function(result){
						$('#CouponModal').modal('hide');
						$('#storedatatable').DataTable().ajax.reload();
					},error: function (reject) {
						if( reject.status === 422 ) {
							var errors = $.parseJSON(reject.responseText);
							$.each(errors.errors, function (key, val){
								$( "#CreateCouponForm span#" + key + "_error").parent().addClass("has-error");
								$("#" + key + "_error").show();
								$("#" + key + "_error").text(val[0]);
							});
						}
					}
				});
			}));
         });
         </script>
@stop