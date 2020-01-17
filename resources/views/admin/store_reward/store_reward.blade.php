<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt | Store Reward')
@section('content')
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-left">
			<a href="javascript:void(0)" class="btn btn-primary pull-left Addreward">
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
		<form id="reward_form" enctype="multipart/form-data">

			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="RewardId" />
			<div class="form-group">
				<select name="store_id" id="merchant" class="form-control form-control-user">
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
				<input type="date" class="form-control form-control-user" name="offer_valid" id="offer_valid" placeholder="offer valide" />
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
			getmerchant();
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
					url: "{{ url('admin/get-store') }}",
					method: 'get',
					success: function(result){
						$("#merchant").html(result.data);
					}
				});
			}
			$(document).on("click",".Addreward",function() {
				$('.Errors').html('');
				$('#reward_form').trigger("reset");
				$('#RewardId').val('');

				$('#StoreModalLabel').html('Add Reward');
				$('#CreateStoreButton').html('Add Reward');
				$('#StoreModal').modal('show');
			});


			$(document).on("click","#DeleteReward",function() {
				var Id = $(this).attr('data-id');
				if (confirm("Are you sure?")) {
					$.ajax({
						url: "{{ url('admin/store_reward') }}/"+Id,
						method: 'DELETE',
						success: function(result){
							$('#storedatatable').DataTable().ajax.reload();
						}
					});
				}
				return false;
			});
			$(document).on("click","#EditReward",function() {
				$('.edit_method').val("post");
				$('.Errors').html('');
				var Id = $(this).attr('data-id');

				$.ajax({
					url: "{{ url('admin/store_reward/') }}/" + Id,
					method: 'get',
					success: function(result){
						$('#StoreModal').modal('show');
						$('#StoreModalLabel').html('Edit Reward');
						$('#CreateStoreButton').html('Edit Reward');
						$('#RewardId').val(result.data.id);
						$("#title").val(result.data.title);
						$("#description").val(result.data.description);
						$("#count").val(result.data.count);
						$("#offer_valid").val(result.data.offer_valid);
						$("#merchant").val(result.data.store_id);

					}

				});

			});


         });
		 </script>
		  <script>
			$(document).ready(function(){

			$('#reward_form').on('submit', function(event){
			 event.preventDefault();
			 url =  "{{ url('admin/store_reward')}}/"
			 $.ajax({
			  url:url,
			  method:"POST",
			  data:new FormData(this),
			//   dataType:'JSON',
			  contentType: false,
			  cache: false,
			  processData: false,
			  success:function(data)
			  {
			   $('#mul_ajax').css('display', 'block');
			   $('#StoreModal').modal('hide');
			   $('#storedatatable').DataTable().ajax.reload();
			   $("#reward_form")[0].reset();
			  }
			 })
			});

			});
			</script>
@stop