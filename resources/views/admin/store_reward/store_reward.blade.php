<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt|Store')
@section('content')
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-left">
			<a href="javascript:void(0)" class="btn btn-primary pull-left CreateStore">
			<i class="fa fa-fw fa-user "></i>
				<span class="text">Add New Reward</span>
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
					<th>Description</th>
					<th>count</th>
					<th>offervalid</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
			<tfoot>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Description</th>
					<th>count</th>
					<th>offervalid</th>
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
		<form id="CreateStoreForm" enctype="multipart/form-data">
			<input type="hidden" class="edit_method" name="_method" value="put">
			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="StoreId" />
			<div class="form-group">
				<select name="user_id" id="merchant" class="form-control form-control-user">
					<option value="">--select store--</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="title" id="title" placeholder="Enter Title..." />
				<span id="title_error" class="error"></span>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="description" id="description" placeholder="Enter Description..." />
				<span id="description_error" class="error"></span>
            </div>
            <div class="form-group">
				<input type="text" class="form-control form-control-user" name="count" id="count" placeholder="enter count" />
				<span id="description_error" class="error"></span>
            </div>
            <div class="form-group">
				<input type="date" class="form-control form-control-user" name="offervalid" id="offervalid" placeholder="offer valide" />
				<span id="description_error" class="error"></span>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="CreateStoreButton" name="CreateStore">Add Reward</button>
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
         $(function() {
			 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
               $('#storedatatable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ url('/admin/store_reward') }}',
               columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex' },
					{data: 'title', name: 'title'},
					{data: 'description', name: 'description'},
					{data: 'count', name: 'count'},
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
					url: "{{ url('admin/get-merchant') }}",
					method: 'get',
					success: function(result){
						$("#merchant").html(result.data);
					}
				});
			}
			$(document).on("click",".CreateStore",function() {
				$('.edit_method').val("post");
				$('.Errors').html('');
				$('#CreateStoreForm').trigger("reset");
				$('#StoreId').val('');
				$('.image-div').html('');
				$('.EditInput').show();
				$('#StoreModalLabel').html('Add User');
				$('#CreateStoreButton').html('Add User');
				$('#StoreModal').modal('show');
				getmerchant();
			});

			$(document).on("click","#EditReward",function() {
				$('.edit_method').val("put");
				$('.Errors').html('');
				var Id = $(this).attr('data-id');
				getmerchant();
				$.ajax({
					url: "{{ url('admin/store/') }}/" + Id,
					method: 'get',
					success: function(result){
						$('.EditInput').hide();
						var image = "";
						if(result.data.image){
							var image = " <img src='{{ url('/uploads/stores') }}/" + result.data.image + "'>";
						}

						$('#StoreModalLabel').html('Edit User');
						$('#CreateStoreButton').html('Edit User');
						$('.image-div').html(image);
						$('#StoreId').val(result.data.id);
						$("#title").val(result.data.title);
						$("#description").val(result.data.description);
						$("#email").val(result.data.email);
						$("#phone_number").val(result.data.phone_number);
						$("#facebook_url").val(result.data.facebook_url);
						$("#location_address").val(result.data.location_address);
						$("#merchant").val(result.data.user_id);	
						$('#StoreModal').modal('show');
					}

				});

			});

			$(document).on("click","#DeleteStore",function() {
				var Id = $(this).attr('data-id');
				if (confirm("Are you sure?")) {
					$.ajax({
						url: "{{ url('admin/store') }}/"+Id,
						method: 'DELETE',
						success: function(result){
							$('#storedatatable').DataTable().ajax.reload();
						}
					});
				}
				return false;
			});

			$( "#CreateStoreForm" ).on('submit',(function( event ) {
				$('.error').hide();
				event.preventDefault();
				let data = $(this).serializeArray(); // new FormData(this);
				let method = 'post';
				let url = "{{ url('admin/store') }}";
				if(	$('#StoreId').val()){
					method = "post"; 
					url =  "{{ url('admin/store')}}/" + $('#StoreId').val();
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