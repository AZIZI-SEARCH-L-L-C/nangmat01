@extends('admin.layout')

@section('title', $plugInfo['title'])
@section('Aplugins', 'active')

@section('content')
	<style>
		input{
			margin-bottom: 8px;
		}
	</style>
@if(Session::has('message'))
	<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
		{{ Session::get('message') }}
	</div>
@endif

<div class="row">
	<div class="col-sm-12">
	@if($action != 'all')<a href="{{ action('admin\plugins\custompages\CustomPagesController@get', ['a' => 'all']) }}" class="btn ink-reaction btn-primary"><i class="md md-settings"></i> All pages</a>@endif
	@if($action != 'new')<a href="{{ action('admin\plugins\custompages\CustomPagesController@get', ['a' => 'new']) }}" class="btn ink-reaction btn-primary"><i class="md md-settings"></i> New page</a>@endif
		<br><br>
	</div>
</div>


	@if($action == 'new')
		<div class="box box-primary box-solid">
			<div class="box-header">
				<h3 class="box-title">Create new page</h3>
			</div>
			<div class="box-body">
				<form class="form" method="post" action="{{ URL::action('admin\plugins\custompages\CustomPagesController@post') }}">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="slug" class="col-sm-3 control-label">Page Slug:</label>
								<div class="col-sm-9">
									<span style="width:260px;">{{ action('plugins\custompages\CustomPagesController@get', ['slug' => '/']) }}/</span><input style="display: inline-block;width: calc(100% - 270px);" type="text" name="slug" id="slug" class="form-control" value=""/>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="title" class="col-sm-3 control-label">Page title:</label>
								<div class="col-sm-9">
									<input type="text" name="title" id="title" class="form-control" value="">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="body" class="col-sm-3 control-label">Page body:</label>
								<div class="col-sm-9">
									<textarea name="body" id="body" rows="10" class="form-control" value=""></textarea>
								</div>
							</div>
						</div>
					</div>


					<div class="text-right" style="clear:both;margin-top: 5px;">
						<button type="submit" name="submitNew" value="true" class="btn btn-flat btn-primary ink-reaction">New</button>
					</div>
				</form>
			</div>
		</div>
	@endif

	@if($action == 'edit')
		<div class="box box-primary box-solid">
			<div class="box-header">
				<h3 class="box-title">Edit page</h3>
			</div>
			<div class="box-body">
				<form class="form" method="post" action="{{ URL::action('admin\plugins\custompages\CustomPagesController@post') }}">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="title" class="col-sm-3 control-label">Page title:</label>
								<div class="col-sm-9">
									<input type="text" name="title" id="title" class="form-control" value="{{ $page->title }}">
									<input type="hidden" name="slug" value="{{ $page->slug }}">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="body" class="col-sm-3 control-label">Page body:</label>
								<div class="col-sm-9">
									<textarea name="body" id="body" rows="10" class="form-control" value="">{{ $page->body }}</textarea>
								</div>
							</div>
						</div>
					</div>


					<div class="text-right" style="clear:both;margin-top: 5px;">
						<button type="submit" name="submitEdit" value="true" class="btn btn-flat btn-primary ink-reaction">Update</button>
					</div>
				</form>
			</div>
		</div>
	@endif

	@if($action == 'all')
		<div class="box box-primary box-solid" style="margin-top:20px;">
			<div class="box-header">
				<h3 class="box-title">Edit pages</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="list-group">
						@foreach($pages as $page)
							<div class="col-sm-11"><a href="{{ action('admin\plugins\custompages\CustomPagesController@get', ['a' => 'edit', 'slug' => $page->slug]) }}" class="list-group-item">{{ $page->title }}</a></div>
							<div class="col-sm-1"><a id="{{ $page->slug }}" href="{{ action('admin\plugins\custompages\CustomPagesController@get', ['a' => 'remove', 'slug' => $page->slug]) }}" class="list-group-item remove"><i class="fa fa-remove"></i></a></div>
						@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
	@endsection


@section('javascript')
<script>
$('.remove').on('click', function(){
	var answer = confirm ("Do you want to remove: " + $(this).attr('id'));
	if (answer){
		window.location.replace($(this).attr('href'));
	}
	return false;
});
</script>
@endsection