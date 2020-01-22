<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Loyalt | User Management')
@section('content')
<div class="box">
	<div class="box-header">
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="userfeedback" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>First Name</th>
					<th>Title</th>
					<th>Description</th>
					<th>created_at</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
			<tfoot>
				<tr>
                    <th>No</th>
					<th>First Name</th>
					<th>Title</th>
					<th>Description</th>
					<th>created_at</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

@endsection

@section('js')
	<script>
         $(function() {
			 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
            $('#userfeedback').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ url("/admin/user_feedback") }}',
               columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {data: 'user_detail.first_name', name: 'user_detail.first_name'},
					{data: 'title', name: 'title'},
					{data: 'description', name: 'description'},
					{data: 'created_at', name: 'created_at'},
				],
				"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0] },
                { "bSearchable": false, "aTargets": [ 0] }
				]
            });

         });
         </script>
@stop