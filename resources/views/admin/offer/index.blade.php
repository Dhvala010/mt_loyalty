<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt|Store Offer')
@section('content')
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-left">
			<a href="javascript:void(0)" class="btn btn-primary pull-left CreateOffer">
			<i class="fa fa-fw fa-user "></i>
				<span class="text">Add New Offer</span>
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
					<th>Stamp</th>
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
					<th>Stamp</th>
					<th>Valid Offer</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="modal fade in" id="StoreModal">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span></button>
		<h4 class="modal-title" id="StoreModalLabel" >Default Modal</h4>
	  </div>
	  <div class="modal-body">
		<form id="CreateOfferForm" enctype="multipart/form-data">
			<input type="hidden" class="edit_method" name="_method" value="put">
			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="OfferId" />
			<div class="form-group">
				<select name="store_id" id="merchant" class="form-control form-control-user">
					<option value="">-- Select Store --</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="title" id="title" placeholder="Enter Title..." />
				<span id="title_error" class="error"></span>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="count" id="stamp" placeholder="Enter Stamp..." />
				<span id="count_error" class="error"></span>
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user datepicker1" name="offer_valid" id="offer_valid"  placeholder="Enter Offer Valid..." />
				<span id="offer_valid_error" class="error"></span>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="CreateOfferButton" name="CreateOffer">Create Store</button>
			  </div>
		</form>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@endsection
@section('css')
	<style>
		.image-div img {
			width: 120px;
			padding: 15px;
		}
	</style>
@stop
@section('js')
	<script>
		$('.datepicker1').datepicker({
		    format: "dd/mm/yyyy",
		});
		 $(function() {
			 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
               $('#storedatatable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ url('/admin/offer') }}',
               columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex' },
					{data: 'title', name: 'title'},
					{data: 'store.title', name: 'store'},
					{data: 'count', name: 'stamp'},
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
			$(document).on("click",".CreateOffer",function() {
				$('.edit_method').val("post");
				$('.Errors').html('');
				$('#CreateOfferForm').trigger("reset");
				$('#OfferId').val('');
				$('.EditInput').show();
				$('#StoreModalLabel').html('Add Offer');
				$('#CreateOfferButton').html('Add Offer');
				$('#StoreModal').modal('show');
				getmerchant();
			});
			 $(document).on("click","#EditStore",function() {
				$('.edit_method').val("put");
				$('.Errors').html('');
				var Id = $(this).attr('data-id');
				getmerchant();
				$.ajax({
					url: "{{ url('admin/offer/') }}/" + Id,
					method: 'get',
					success: function(result){
						$('.EditInput').hide();
						$('#StoreModalLabel').html('Edit Offer');
						$('#CreateOfferButton').html('Edit Offer');
						$('#OfferId').val(result.data.id);
						$("#title").val(result.data.title);
						$("#stamp").val(result.data.count);
						$("#offer_valid").val(result.data.offer_valid);
						$("#merchant").val(result.data.store_id);	
						$('#StoreModal').modal('show');
					}

				});

			});

			$(document).on("click","#DeleteStore",function() {
				var Id = $(this).attr('data-id');
				if (confirm("Are you sure?")) {
					$.ajax({
						url: "{{ url('admin/offer') }}/"+Id,
						method: 'DELETE',
						success: function(result){
							$('#storedatatable').DataTable().ajax.reload();
						}
					});
				}
				return false;
			});

			$( "#CreateOfferForm" ).on('submit',(function( event ) {
				$('.error').hide();
				event.preventDefault();
				let data = $(this).serializeArray(); // new FormData(this);
				let method = 'post';
				let url = "{{ url('admin/offer') }}";
				if(	$('#OfferId').val()){
					method = "post"; 
					url =  "{{ url('admin/offer')}}/" + $('#OfferId').val();
				}
			$.ajax({
					url: url,
					method: method,
					//dataType : 'json',
					contentType: false,
					processData:false,
					data: new FormData(this),
					success: function(result){						
							$('#StoreModal').modal('hide');
							$('#storedatatable').DataTable().ajax.reload();						
					},error: function (reject) {						
             if( reject.status === 422 ) {						
										var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key, val) {
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