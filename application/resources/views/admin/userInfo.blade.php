@extends('admin.layout')

@section('title', 'Admin access')
@section('Asettings', 'active')

@section('content')

	@if(Session::has('message'))
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-dismissible @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('message') }}
				</div>
			</div>
		</div>
	@endif

	<form class="form" method="post" action="{{ URL::action('admin\UserInfoController@post') }}">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Admin login Informations</h3>
				<!-- /.box-tools -->
			</div>
			<div class="box-body">
				
				<div class="row">
				  <div class="form-group">
					<label for="username" class="col-sm-3 control-label">Admin username:</label>
					<div class="col-sm-4">
                        <input type="text" name="username" id="username" class="form-control" value="{{ $username }}">
		            </div>
				  </div>
				</div>
				
			</div>
		</div>
		
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Admin password</h3>
				<!-- /.box-tools -->
			</div>
			<div class="box-body">
				<div class="row">
				  <div class="form-group">
					<label for="password_old" class="col-sm-3 control-label">current password:</label>
					<div class="col-sm-4">
                        <input type="password" name="password_old" id="password_old" class="form-control" placeholder="keep it empty for unchange">
		            </div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group">
					<label for="password_new" class="col-sm-3 control-label">New password:</label>
					<div class="col-sm-4">
                        <input type="password" name="password_new" id="password_new" class="form-control" placeholder="keep it empty for unchange">
		            </div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group">
					<label for="password_new_conf" class="col-sm-3 control-label">Confirm new password:</label>
					<div class="col-sm-4">
                        <input type="password" name="password_new_conf" id="password_new_conf" class="form-control" placeholder="keep it empty for unchange">
		            </div>
				  </div>
				</div>
				<div class="row">
					<button type="submit" class="btn btn-flat btn-primary ink-reaction">Update</button>
				</div>
			</div>
		</div>
		<em class="text-caption">These settings affect your entire Site and all your visitors.</em>
	</form>
@endsection