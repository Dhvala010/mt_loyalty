<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt | Store Management')
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
		<form id="CreateStoreForm" enctype="multipart/form-data">
			<input type="hidden" class="edit_method" name="_method" value="put">
			@csrf
			<div class="Errors"></div>
			<input type="hidden" class="form-control form-control-user" name="id" id="StoreId" />
			<div class="form-group">
				<select name="user_id" id="merchant" class="form-control form-control-user">
					<option value="">-- Select Merchant --</option>
				</select>
				<span id="user_id_error" class="help-block"></span>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="title" id="title" placeholder="Enter Title..." />
				<span id="title_error" class="help-block"></span>
			</div>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" name="description" id="description" placeholder="Enter Description..." />
				<span id="description_error" class="help-block"></span>
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="phone_number" id="phone_number" placeholder="Enter Phone Number..." />
				<span id="phone_number_error" class="help-block"></span>
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="facebook_url" id="facebook_url" placeholder="Enter Facebook Url..." />
				<span id="facebook_url_error" class="help-block"></span>
			</div>
			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="location_address" id="location_address" placeholder="Enter Location Address..." />
				<span id="location_address_error" class="help-block"></span>
			</div>

			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="latitude" id="latitude" placeholder="Enter Location latitude..." />
				<span id="latitude_error" class="help-block"></span>
			</div>

			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="longitude" id="longitude" placeholder="Enter Location longitude..." />
				<span id="longitude_error" class="help-block"></span>
			</div>

			<div class="form-group">
			  <input type="text" class="form-control form-control-user" name="email" id="email" placeholder="Enter Email Address..." />
				<span id="email_error" class="help-block"></span>
			</div>

			<div class="form-group">
			  <input type="file" id="image" name="image" class="form-control-file">
				<div class="image-div mt-3" >
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
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEKhaA47gJSR33ZyDEbpPENL14jeGTvH4&libraries=places"
  type="text/javascript"></script> -->
	<script>
         $(function() {
			// function initMap() {
			// 	var input = document.getElementById('location_address');
			// 	console.log(input);
			// 	var autocomplete = new google.maps.places.Autocomplete(input);
			// 	google.maps.event.addListener(autocomplete, 'place_changed', function () {
			// 		var place = autocomplete.getPlace();
			// 		if (!place.geometry) {
			// 			// User entered the name of a Place that was not suggested and
			// 			// pressed the Enter key, or the Place Details request failed.
			// 			window.alert("No details available for input: '" + place.name + "'");
			// 			return;
			// 		}
			// 		var lat = place.geometry.location.lat(),
			// 			lng = place.geometry.location.lng();

			// 		$("#location_address_lat").val(lat)
			// 		$("#location_address_long").val(lng)
			// 		$("#preferred_workplace_lat-error").html("")
			// 	})
			// }
			// initMap();
			getmerchant();
			 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});

               $('#storedatatable').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ url('/admin/store') }}",
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
				$( "#CreateStoreForm div.form-group").removeClass("has-error");
				$( "#CreateStoreForm div.form-group span").hide();
				$('.Errors').html('');
				$('#CreateStoreForm').trigger("reset");
				$('#StoreId').val('');
				$('.image-div').html('');
				$('#StoreModalLabel').html('Add Store');
				$('#CreateStoreButton').html('Add Store');
				$('#StoreModal').modal('show');
			});

			$(document).on("click","#EditStore",function() {
				$('.edit_method').val("put");
				$('.Errors').html('');
				$( "#CreateStoreForm div.form-group").removeClass("has-error");
				$( "#CreateStoreForm div.form-group span").hide();
				var Id = $(this).attr('data-id');
				$.ajax({
					url: "{{ url('admin/store/') }}/" + Id,
					method: 'get',
					success: function(result){
						var image = "";
						if(result.data.image){
							var image = " <img src='"+ result.data.image + "'>";
						}
						$('#StoreModalLabel').html('Edit Store');
						$('#CreateStoreButton').html('Edit Store');
						$('.image-div').html(image);
						$('#StoreId').val(result.data.id);
						$("#title").val(result.data.title);
						$("#description").val(result.data.description);
						$("#email").val(result.data.email);
						$("#latitude").val(result.data.latitude);
						$("#longitude").val(result.data.longitude);

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
							$( "#CreateStoreForm div.form-group").removeClass("has-error");
							$( "#CreateStoreForm div.form-group span").hide();
							$('#StoreModal').modal('hide');
							$('#storedatatable').DataTable().ajax.reload();
					},error: function (reject) {
						if( reject.status === 422 ) {
							var errors = $.parseJSON(reject.responseText);
							$( "#CreateStoreForm div.form-group").removeClass("has-error");
							$( "#CreateStoreForm div.form-group span").hide();
							$.each(errors.errors, function (key, val){
								$( "#CreateStoreForm span#" + key + "_error").parent().addClass("has-error");
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