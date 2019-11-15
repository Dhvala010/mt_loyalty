<!-- home.blade.php -->
@extends('adminlte::page')

@section('content')
<div class="col-sm-12 col-md-6">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Change Password</h3>
		</div>
		<div class="box-body">
			<form action="{{ url('admin/user/ChangePasswords') }}" method="post">
                {!! csrf_field() !!}
				@if (session()->has('success'))
					<div class="alert alert-success">
						@if(is_array(session()->get('success')))
						<ul>
							@foreach (session()->get('success') as $message)
								<li>{{ $message }}</li>
							@endforeach
						</ul>
						@else
							{{ session()->get('success') }}
						@endif
					</div>
				@endif
				@if (!empty($errors->toarray()))
				 <div class="alert alert-danger">
					<span>{{ $errors->first() }}</span>
				</div>
				@endif
				<div class="form-group">
                    <input type="password" name="current_password" class="form-control"
                           placeholder="Enter Current Password">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control"
                           placeholder="Enter New Password">

                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Enter New Confirm Password">
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >
					Change Password
				</button>
            </form>
		</div>
	</div>
</div>
@endsection
@section('css')

@stop
@section('js')

@stop
