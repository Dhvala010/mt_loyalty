<!-- home.blade.php -->
@extends('adminlte::page')

@section('content')
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-left">
			<a href="javascript:void(0)" class="btn btn-primary pull-left CreateStore">
			<i class="fa fa-fw fa-user "></i>
				<span class="text">Add New Store</span>
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
					<th>Email</th>
					<th>created_at</th>
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
					<th>Email</th>
					<th>created_at</th>
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
		<form id="CreateStoreForm" enctype="multipart/form-data" method="post" action="{{ route('admin.store.store') }}">
			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="StoreId" />
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="title" id="title" placeholder="Enter Title..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="description" id="description" placeholder="Enter Description..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="phone_number" id="phone_number" placeholder="Enter Phone Number..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="facebook_url" id="facebook_url" placeholder="Enter Facebook Url..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="location_address" id="location_address" placeholder="Enter Location Address..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="email" id="email" placeholder="Enter Email Address..." />
			</div>

			<div class="form-group">
			  <input type="file" id="image" name="image" class="form-control-file">
				<div class="image-div mt-3" style="">

				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="CreateStoreButton" name="CreateStore">Create Store</button>
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
               ajax: '{{ url('/admin/store') }}',
               columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex' },
					{data: 'title', name: 'title'},
					{data: 'description', name: 'description'},
					{data: 'email', name: 'email'},
					{data: 'created_at', name: 'created_at'},
					{data: 'action', name: 'action'},
				],
				"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0, 5 ] },
                { "bSearchable": false, "aTargets": [ 0, 5 ] }
				]
            });

			$(document).on("click",".CreateStore",function() {
				$('.Errors').html('');
				$('#CreateStoreForm').trigger("reset");
				$('#StoreId').val('');
				$('.image-div').html('');
				$('.EditInput').show();
				$('#StoreModalLabel').html('Add User');
				$('#CreateStoreButton').html('Add User');
				$('#StoreModal').modal('show');
			});

			$(document).on("click","#EditStore",function() {
				$('.Errors').html('');
				var Id = $(this).attr('data-id');
				$.ajax({
					url: "{{ url('admin/store/GetDataById') }}",
					method: 'post',
					data: {	id : Id },
					success: function(result){
						$('.EditInput').hide();
						var image = "";
						if(result.data.image){
							var image = " <img src='{{ url('public/storage') }}/" + result.data.image + "'>";
						}

						$('#StoreModalLabel').html('Edit User');
						$('#CreateStoreButton').html('Edit User');
						$('.image-div').html(image);
						$('#StoreId').val(result.data.id);
						$("#first_name").val(result.data.first_name);
						$("#last_name").val(result.data.last_name);
						$("#email").val(result.data.email);
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
				event.preventDefault();
				$.ajax({
					url: "{{ url('admin/store') }}",
					method: 'post',
					contentType: false,
					processData:false,
					data: new FormData(this),
					success: function(result){
						if(result.status == 0 ){
							var ErrorStr = '<div class="alert alert-danger">'
							$.each(result.errors, function(key, value){
								ErrorStr += " <p> " + value + " </p> ";
							});
							ErrorStr += '</div>';
							$(".Errors").html(ErrorStr);
						}
						else{
							$('#StoreModal').modal('hide');
							$('#storedatatable').DataTable().ajax.reload();
						}
					}
				});
			}));
         });
         </script>
@stop