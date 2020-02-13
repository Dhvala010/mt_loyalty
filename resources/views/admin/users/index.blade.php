<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt | User Management')
@section('content')
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-left">
			<a href="javascript:void(0)" class="btn btn-primary pull-left CreateUser">
			<i class="fa fa-fw fa-user "></i>
				<span class="text">Add New User</span>
			</a>
		</div>

	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="userdatatable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>First Name</th>
					<th>Last Name</th>
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
					<th>Name</th>
					<th>Email</th>
					<th>created_at</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="modal fade in" id="UserModal">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span></button>
		<h4 class="modal-title" id="UserModalLabel" >Default Modal</h4>
	  </div>
	  <div class="modal-body">
		<form id="CreateUserForm" enctype="multipart/form-data" method="post" action="{{ route('admin.user.store') }}">
			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="UserId" />
			<div class="form-group">
				<select name="role" id="user_role" class="form-control form-control-user">
					<option value="">-- Select User type --</option>
					<option value="2">Customer</option>
					<option value="3">Merchant</option>
				</select>
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="email" id="email" placeholder="Enter Email Address..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="first_name" id="first_name" placeholder="Enter First Name..." />
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="last_name" id="last_name" placeholder="Enter Last Name..." />
			</div>
			<div class="form-group EditInput">
			  <input type="text" class="form-control form-control-user" name="password" id="password" placeholder="Enter your password..." />
			</div>
			<div class="form-group EditInput">
			  <input type="text" class="form-control form-control-user" name="password_confirmation" id="password_confirmation" placeholder="Enter your Confirm password..." />
			</div>

			<div class="form-group">
			  <input type="file" id="image" name="image" class="form-control-file">
				<div class="image-div mt-3" style="">

				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="CreateUserButton" name="CreateUser">Create User</button>
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
               $('#userdatatable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ url("/admin/user") }}',
               columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex' },
					{data: 'first_name', name: 'first_name'},
					{data: 'last_name', name: 'last_name'},
					{data: 'email', name: 'email'},
					{data: 'created_at', name: 'created_at'},
					{data: 'action', name: 'action'},
				],
				"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0, 5 ] },
                { "bSearchable": false, "aTargets": [ 0, 5 ] }
				]
            });

			$(document).on("click",".CreateUser",function() {
				$('.Errors').html('');
				$('#CreateUserForm').trigger("reset");
				$('#UserId').val('');
				$('.image-div').html('');
				$('.EditInput').show();
				$('#UserModalLabel').html('Add User');
				$('#CreateUserButton').html('Add User');
				$('#UserModal').modal('show');
			});

			$(document).on("click","#EditUser",function() {
				$('.Errors').html('');
				var Id = $(this).attr('data-id');
				$.ajax({
					url: "{{ url('admin/user/GetDataById') }}",
					method: 'post',
					data: {	id : Id },
					success: function(result){
						$('.EditInput').hide();
						var image = "";
						if(result.data.profile_picture){
							var image = " <img src='" + result.data.profile_picture + "'>";
						}
						$('#UserModalLabel').html('Edit User');
						$('#CreateUserButton').html('Edit User');
						$('.image-div').html(image);
						$('#UserId').val(result.data.id);
						$("#first_name").val(result.data.first_name);
						$("#last_name").val(result.data.last_name);
						$("#email").val(result.data.email);
						$("#user_role").val(result.data.role);
						$('#UserModal').modal('show');
					}

				});

			});

			$(document).on("click","#DeleteUser",function() {
				var Id = $(this).attr('data-id');
				if (confirm("Are you sure?")) {
					$.ajax({
						url: "{{ url('admin/user') }}/"+Id,
						method: 'DELETE',
						success: function(result){
							$('#userdatatable').DataTable().ajax.reload();
						}
					});
				}
				return false;
			});

			$( "#CreateUserForm" ).on('submit',(function( event ) {
				event.preventDefault();
				$.ajax({
					url: "{{ url('admin/user') }}",
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
							$('#UserModal').modal('hide');
							$('#userdatatable').DataTable().ajax.reload();
						}
					}
				});
			}));
         });
         </script>
@stop