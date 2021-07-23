@extends('admin.layout')

@section('title', 'General Settings')
@section('Aengines', 'active')

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/css/select2.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/nestable/nestable.css') }}" />
<style>
.ddicheckbox_minimal-blue{
	margin-left: 15px;
}
.form-horizontal .control-label{ 
	text-align: left !important;
}
#statu{
	display: none;
}
</style>
@endsection

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Search engines
	<small>manage engines</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Engines</li>
  </ol>
</section>
@endsection

@section('content')
	<div class="row">
	  <div class="col-sm-12">
		 <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#settingsModal">Settings</button>
		 <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#orderModal">Manage order</button>
		 <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#defaultEngineModal">Set default</button>
	  </div>
	</div><br/>
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
	<div class="row">
		<div class="col-lg-12">
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
				  <h3 class="box-title">Site Informations</h3>
				  <!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>name</th>
								<th>Status</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
						@foreach($engines as $Cengine)
							<tr>
								<td>{{ $Cengine['name'] }} @if($settings['default'] == $Cengine['name'])<i class="fa fa-asterisk text-warning"></i>@endif</td>
								<td>@if($Cengine['turn']) <span class="text-success">Active</span> @else <span class="text-danger">Inactive</span> @endif</td>
								<td class="text-right">
									<!--button onclick="editModel('{{ $Cengine['key'] }}', '{{ $Cengine['name'] }}', '{{ $settings['perPage'.ucfirst($Cengine['name'])] }}', {{ $Cengine['turn'] }});" data-toggle="modal" data-target="#formModal" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button-->
									<a href="{{ route($Cengine['edit_route'], ['name' => $Cengine['name']]) }}"><button class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button></a>
{{--									<a href="{{ URL::action('admin\DeleteController@get', ['name' => $Cengine['name']]) }}"><button class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button></a>--}}
								</td>
							</tr>
					   @endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
	<em class="text-caption"><i class="fa fa-asterisk text-warning"></i> Default search engine.</em>
	
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Edite engine</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\EnginesController@post') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="checkbox">
								<input type="checkbox" name="keepfilters" id="keepfilters" @if($settings['keepFilters']) checked @endif class="minimal">
								<label for="keepfilters">Keep filters when doing new search.</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitEditSettings" value="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->



<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="defaultEngineModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Default engine</h4>
			</div>
			<form role="form" action="{{ URL::action('admin\EnginesController@post') }}" method="post">
				<div class="modal-body">
				    <div class="row">
						<div class="form-group col-sm-12">
							<select id="select1" name="defaultEngine" class="form-control">
								@foreach($engines as $Cengine)
									<option value="{{ $Cengine['name'] }}" @if($Cengine['name'] == $settings['default']) selected @endif>{{ $Cengine['name'] }}</option>
								@endforeach
							</select>
						 </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitDefaultEngine" value="submit" class="btn btn-primary">Set</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Manage the order of engines</h4>
			</div>
			<div class="modal-body">
			    <div class="dd nestable-list">
					<ol class="dd-list">
					@foreach($engines as $Cengine)
						<li class="dd-item tile" data-id="{{ $Cengine['order'] }}" data-name="{{ $Cengine['name'] }}">
							<div class="dd-handle btn btn-default"> {{ $Cengine['name'] }} @if($settings['default'] == $Cengine['name'])<i class="fa fa-asterisk text-warning"></i>@endif <span class="pull-right"><a href="#">Edit</a></span></div>
						</li>
					@endforeach
					</ol>
				</div><!--end .dd.nestable-list -->
			</div>
			<div class="modal-footer">
				<form action="{{ URL::action('admin\EnginesController@post') }}" role="form" method="post">
				    <input id="enginesOrder" name="order" type="hidden">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitOrder" value="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->

@endsection

@section('javascript')
<script src="{{ URL::asset('assets/admin/js/nestable/jquery.nestable.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
	$('.select2').select2();
	$('[data-toggle="tooltip"]').tooltip();
});

function editModel($key, $name, $max, $active){
	$('#name').val($name);
	$('#EngineName').val($name);
	$('#key').val($key);
	$('#max').val($max);
	$('#active').prop('checked', $active);
}

(function(namespace, $) {
	"use strict";

	var DemoUILists = function() {
		var o = this;
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = DemoUILists.prototype;

	p.initialize = function() {
		this._initNestableLists();
	};
	p._initNestableLists = function() {
		if (!$.isFunction($.fn.nestable)) {
			return;
		}

		$('.nestable-list').nestable();
	};
	
	namespace.DemoUILists = new DemoUILists;
}(this, jQuery));

function serializeDD(){
	var obj = $('.dd').nestable('serialize');
	console.log(JSON.stringify(obj));
	$('#enginesOrder').val(JSON.stringify(obj));
}
$('.dd').on('change', function() {
    serializeDD();
});

// filters JS
$('#documentsFilter').on('ifChecked', function() {
	$('#documentsFilterContainer').show();
});
$('#documentsFilter').on('ifUnchecked', function() {
	$('#documentsFilterContainer').hide();
});
$('#countriesFilter').on('ifChecked', function() {
	$('#countriesFilterContainer').show();
	$('#firstCountriesFilterContainer').show();
});
$('#countriesFilter').on('ifUnchecked', function() {
	$('#countriesFilterContainer').hide();
	$('#firstCountriesFilterContainer').hide();
});
</script>
@endsection