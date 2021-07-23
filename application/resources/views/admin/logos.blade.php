@extends('admin.layout')

@section('title', 'manage logos')
@section('Alogos', 'active')

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/dropzone/dropzone-theme.css') }}" />
@endsection

@section('content')

					                        <div class="row">
											  <div class="col-sm-12">
											    <a href="{{ URL::action('admin\LogosController@getAll') }}" class="btn ink-reaction btn-primary"><i class="md md-list"></i> All logos</a>
											    <!--button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#settingsModal"><i class="md md-settings"></i> Settings</button-->
												<button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#defaultModal"><i class="md md-image"></i> Default logo</button>
												<div class="btn-group">
													<button type="button" class="btn ink-reaction btn-primary"><i class="fa fa-caret-right"></i> Add logo for</button>
													<button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-caret-down"></i></button>
													<ul class="dropdown-menu dropdown-menu-left" role="menu">
													@foreach($engines as $Cengine)
														<li><a href="{{ URL::action('admin\LogosController@get', ['name' => $Cengine['name']]) }}">{{ $Cengine['name'] }}</a></li>
													@endforeach
														<li class="divider"></li>
														<li><a href="#">Edit default logo</a></li>
													</ul>
												</div>
											  </div>
											</div><br/>

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
											
							
					@if(!empty($logos))
<div class="box box-primary box-solid" style="margin-bottom:20px;">
	<div class="box-body">
						
						<table class="table table-hover">
							<thead>
								<tr>
									<th>statu</th>
									@if(!$upload) <th>engine name</th> @endif
									<th>logo</th>
									<th>type</th>
									<th>Starts</th>
									<th>Ends</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
							@foreach($logos as $Clogo)
								<tr>
								    <td>@if($Clogo['active']) <span class="text-success">Active</span> @else <span class="text-danger">Inactive</span> @endif</td>
									@if(!$upload) <td>{{ $Clogo['engine_name'] }}</td> @endif
									<td>@if($Clogo['type'] == 1) <img style="width:250px;" src="{{ URL::asset($Clogo['content']) }}" > @else {{ $Clogo['content'] }} @endif<img src=""></td>
									<td>@if($Clogo['type'] == 1) Image @else Text @endif</td>
									<td>{{ $Clogo['starts'] }}</td>
									<td>{{ $Clogo['ends'] }}</td>
									<td class="text-right">
										<button onclick="deleteLogo({{ $Clogo['id'] }});" type="button" data-toggle="modal" data-target="#DeleteModal" class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button>
									</td>
								</tr>
						   @endforeach
							</tbody>
						</table>
	</div><!--end .card-body -->
</div>
						@endif

								
						@if(!$upload && empty($logos))
							<div class="box box-primary box-solid">
								<div class="box-body">
								
								     <p class="text-center">There are no logos right now!, please click on the top button 'Add logo for' and add logos to an engine.</p>
								</div>
							</div>
						@endif
						
						@if($upload)
							<div class="col-md-6" style="padding-left:0;">
							    <div class="box box-primary box-solid">
								  <form class="form" method="post" action="{{ URL::action('admin\LogosController@addLogoText', ['name' => $engine]) }}">
									  <div class="box-header with-border">
										  <h3 class="box-title">New logo Text for {{ $engine }}</h3>
										  <!-- /.box-tools -->
									  </div>
									<div class="box-body">
									  <div class="row">
										  <div class="form-group">
											  <div class="col-sm-4">
												  <label for="CeditAdStatu" class="control-label">Starts:</label>
											  </div>
											  <div class="col-sm-4">
												  <div class="input-group">
													  <div class="input-group-addon">
														  <i class="fa fa-calendar"></i>
													  </div>
													  <input type="text" name="startDate" class="form-control pull-right datepicker" autocomplete="off" value="{{ old('startDate') }}">
												  </div>
											  </div>
											  <div class="col-sm-4">
												  <div class="input-group bootstrap-timepicker">
													  <div class="input-group-addon">
														  <i class="fa fa-clock-o"></i>
													  </div>
													  <input type="text" name="startTime" class="form-control pull-right timepicker" autocomplete="off" value="{{ old('startTime') }}">
												  </div>
											  </div>
										  </div>
										  <div class="form-group">
											  <div class="col-sm-4">
												  <label class="control-label">Ends:</label>
											  </div>
											  <div class="col-sm-4">
												  <div class="input-group">
													  <div class="input-group-addon">
														  <i class="fa fa-calendar"></i>
													  </div>
													  <input type="text" name="endDate" class="form-control pull-right datepicker" autocomplete="off" value="{{ old('endDate') }}">
												  </div>
											  </div>
											  <div class="col-sm-4">
												  <div class="input-group bootstrap-timepicker">
													  <div class="input-group-addon">
														  <i class="fa fa-clock-o"></i>
													  </div>
													  <input type="text" name="endTime" class="form-control pull-right timepicker" autocomplete="off" value="{{ old('endTime') }}">
												  </div>
											  </div>
										  </div>
									  </div>
									  <div class="row">
										<div class="col-sm-12 form-group">
											<label for="text">Logo text</label>
											<input type="text" id="text" class="form-control" name="text" placeholder="Enter your logo text">
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn btn-flat btn-primary ink-reaction">Add New</button>
										</div>
									  </div>
									</div>
							      </form>
								</div><!--end .card -->
							</div>
							<div class="col-md-6">
								<div class="box box-primary box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">logos uploader</h3>
									</div>
									<div class="box-body">
										<form action="{{ URL::action('admin\LogosController@upload', ['name' => $engine]) }}" class="dropzone" id="my-awesome-dropzone">
											<div class="row">
											<div class="form-group">
												<div class="col-sm-4">
													<label for="CeditAdStatu" class="control-label">Starts:</label>
												</div>
												<div class="col-sm-4">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" name="startDate" class="form-control pull-right datepicker" autocomplete="off" value="{{ old('startDate') }}">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="input-group bootstrap-timepicker">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
														<input type="text" name="startTime" class="form-control pull-right timepicker" autocomplete="off" value="{{ old('startTime') }}">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-4">
													<label class="control-label">Ends:</label>
												</div>
												<div class="col-sm-4">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" name="endDate" class="form-control pull-right datepicker" autocomplete="off" value="{{ old('endDate') }}">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="input-group bootstrap-timepicker">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
														<input type="text" name="endTime" class="form-control pull-right timepicker" autocomplete="off" value="{{ old('endTime') }}">
													</div>
												</div>
											</div>
											</div>
											<div class="dz-message" style="margin-top: 20px;">
												<h3>Set start and end time then Drop Logo here or click to upload.</h3>
												<em>recommanded logos size is W:592 and H:181.</em>
											</div>
										</form>
									</div><!--end .card-body -->
								</div><!--end .card -->
								<em class="text-caption">Dropzone file upload</em>
							</div>
					   @endif	

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Delete</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LogosController@post', ['name' => $engine]) }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
						    <input name="logoId" type="hidden" id="logoId">
							<p>Please note that this action cannot be reversed so please pay careful attention with it.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitDelete" value="submit" class="btn btn-primary">Delete</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->	


<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Update Logos settings</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LogosController@postAll') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="rotationTime" class="control-label">Change logo:</label>
						</div>
						<div class="col-sm-6">
						    <select id="rotationTime" name="rotationTime" class="form-control">
													<option value="60" @if($settings['ChangeLogoTime'] == 60) selected @endif>Every minute</option>
													<option value="3600" @if($settings['ChangeLogoTime'] == 3600) selected @endif>Every hour</option>
													<option value="86400" @if($settings['ChangeLogoTime'] == 86400) selected @endif>Every day</option>
													<option value="604800" @if($settings['ChangeLogoTime'] == 604800) selected @endif>Every week</option>
													<option value="2592000" @if($settings['ChangeLogoTime'] == 2592000) selected @endif>Every month</option>
												</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitSettings" value="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->		


<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">change default logo</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LogosController@postAll') }}" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-6">
							<label class="control-label">Default logo types:</label>
						</div>
						<div class="col-sm-6">
						    <div class="radio radio-inline">
								<input type="radio" id="DefLoImage" name="defaultLogoType" value="1" @if($settings['defaultLogoType'] == 1) checked @endif><label for="DefLoImage">Image</label>
							</div>
						    <div class="radio radio-inline">
								<input type="radio" id="DefLoText" name="defaultLogoType" value="0" @if($settings['defaultLogoType'] == 0) checked @endif><label for="DefLoText">Text</label>
							</div>
						</div>
					</div>
					<div class="form-group" id="DefaultImage">
					  <div>
						<div class="col-sm-6">
							<label for="rotationTime" class="control-label">Current logo image:</label>
						</div>
						<div class="col-sm-6">
						    @if($settings['defaultLogoType'] == 1) <img src="{{ URL::asset($settings['defaultLogoContent']) }}" width="200" /> @else <p>None selected.</p> @endif
						</div>
					  </div>
					  <div>
						<div class="col-sm-6">
							<label for="rotationTime" class="control-label">Select new:</label>
						</div>
						<div class="col-sm-6">
						    <input type="file" name="DefaultLogoImage" />
						</div>
					  </div>
					</div>
					<div class="form-group" id="DefaultText">
						<div class="col-sm-6">
							<label for="DefaultLogoText" class="control-label">Default logo text:</label>
						</div>
						<div class="col-sm-6">
						    <input type="text" value="{{ $settings['defaultLogoContent'] }}" name="DefaultLogoText" id="DefaultLogoText" class="form-control" placeholder="name">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitDefaultLogo" value="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->			
@endsection

@section('javascript')
<script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script>

    $('.timepicker').timepicker({
        showInputs: false,
        showMeridian: false,
        minuteStep: 1,
    });
    $('.datepicker').datepicker({
        autoclose: true,
		default: 'today',
        format: 'dd-mm-yyyy'
    });

$( document ).ready(function() {
@if($settings['defaultLogoType'] == 1)
    $("#DefaultImage").show();	
	$("#DefaultText").hide();
	$("#DefaultLogoText").val("");
@else
	$("#DefaultImage").hide();	
	$("#DefaultText").show();
@endif
});
function deleteLogo($id){
	$('#logoId').val($id);
}

$("#DefLoImage").click(function (){
	$("#DefaultImage").show();	
	$("#DefaultText").hide();	
});

$("#DefLoText").click(function (){
	$("#DefaultImage").hide();	
	$("#DefaultText").show();	
});

</script>

<script src="{{ URL::asset('assets/admin/js/dropzone/dropzone.js') }}"></script>
@endsection