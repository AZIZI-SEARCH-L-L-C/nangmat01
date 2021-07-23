@extends('admin.layout')

@section('title', 'Social media login Settings')
@section('Asettings', 'active')

@section('css')
<style>
.ddicheckbox_minimal-blue{
	margin-left: 15px;
}
.form-group{ 
	clear: both;
}
</style>
@endsection

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	  Social media login Settings
	<small>configure login with social media</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Social login settings</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row" id="statu">
	<div class="col-sm-12">
		<div class="alert alert-dismissible" role="alert"><span></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
	</div>
</div>
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

	<form class="form-horizontal save" method="post" id="mainForm" action="{{ URL::action('admin\SettingsController@postSocialLogin') }}">
		<div class="row flex">
			<div class="col-lg-12 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					  <h3 class="box-title">Facebook Login</h3>
					  <!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="enable_facebook" name="enable_facebook" class="minimal" @if(Config::get('services.facebook.enabled', false) == 'true') checked @endif>
								Enable Login with facebook
							</label>
						</div>
						<div class="form-group">
							<label for="fb_id" class="col-sm-2 control-label">Facebook App ID:</label>
							<div class="col-sm-10">
								<input type="text" name="fb_id" id="fb_id" class="form-control" value="{{ Config::get('services.facebook.client_id', '') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="fb_secret" class="col-sm-2 control-label">Facebook App Secret:</label>
							<div class="col-sm-10">
								<input type="text" name="fb_secret" id="fb_secret" class="form-control" value="{{ Config::get('services.facebook.client_secret', '') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="cacheTime" class="col-sm-2 control-label">Redirect Url:</label>
							<div class="col-sm-10">
								<p>{{ route('login.facebook') }}</p>
							</div>
						</div>
						<!-- /.box-body --
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Update</button>
						</div>
						<!-- /.box-footer -->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
        </div>
		<div class="row flex">
			<div class="col-lg-12 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					  <h3 class="box-title">Twitter Login</h3>
					  <!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="enable_twitter" name="enable_twitter" class="minimal" @if(Config::get('services.twitter.enabled', false) == 'true') checked @endif>
								Enable Login with Twitter
							</label>
						</div>
						<div class="form-group">
							<label for="tw_id" class="col-sm-2 control-label">Twitter App ID:</label>
							<div class="col-sm-10">
								<input type="text" name="tw_id" id="tw_id" class="form-control" value="{{ Config::get('services.twitter.client_id', '') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="tw_secret" class="col-sm-2 control-label">Twitter App Secret:</label>
							<div class="col-sm-10">
								<input type="text" name="tw_secret" id="tw_secret" class="form-control" value="{{ Config::get('services.twitter.client_secret', '') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="cacheTime" class="col-sm-2 control-label">Redirect Url:</label>
							<div class="col-sm-10">
								<p>{{ route('login.twitter') }}</p>
							</div>
						</div>
						<!-- /.box-body --
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Update</button>
						</div>
						<!-- /.box-footer -->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
        </div>
		<div class="row flex">
			<div class="col-lg-12 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					  <h3 class="box-title">Google Login</h3>
					  <!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="enable_google" name="enable_google" class="minimal" @if(Config::get('services.google.enabled', false) == 'true') checked @endif>
								Enable Login with Google
							</label>
						</div>
						<div class="form-group">
							<label for="go_id" class="col-sm-2 control-label">Google App ID:</label>
							<div class="col-sm-10">
								<input type="text" name="go_id" id="go_id" class="form-control" value="{{ Config::get('services.google.client_id', '') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="go_secret" class="col-sm-2 control-label">Google App Secret:</label>
							<div class="col-sm-10">
								<input type="text" name="go_secret" id="go_secret" class="form-control" value="{{ Config::get('services.google.client_secret', '') }}">
							</div>
						</div>
						<div class="form-group">
							<label for="cacheTime" class="col-sm-2 control-label">Redirect Url:</label>
							<div class="col-sm-10">
								<p>{{ route('login.google') }}</p>
							</div>
						</div>
						<!-- /.box-body --
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Update</button>
						</div>
						<!-- /.box-footer -->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
        </div>
	</form>
@endsection

@section('javascript')
<script>
	$( "#save" ).click(function() {
		$('#mainForm').submit();
	});
</script>
@endsection