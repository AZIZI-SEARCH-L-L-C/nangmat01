@extends('admin.layout')

@section('title', 'Errors log')
@section('AsystemLog', 'active')

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<style>
.dataTables_filter{
	float: right;
}
</style>
@endsection

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Log Browser
	<small>System logs</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.log') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Log Browser</li>
  </ol>
</section>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-9">
			<button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#settingsModal">Settings</button>
			<a href="?day={{ $current_day }}&download=true" type="button" class="btn ink-reaction btn-primary">Download log</a>
			<a href="?day={{ $current_day }}&clear=true" onclick="confirmClear(event);" type="button" class="btn ink-reaction btn-primary">Clear log</a>
			<a href="?day={{ $current_day }}&clearAll=true" onclick="confirmClearAll(event);" type="button" class="btn ink-reaction btn-primary">Clear all logs</a>
		</div>
		<div class="col-sm-3">
			<div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control pull-right" id="datepicker" value="{{ $current_day }}" data-date-format="yyyy-mm-dd"/>
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
	
	<div class="row">
		<div class="col-lg-12">
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
				  <h3 class="box-title">@if($today) Today logs @else log for {{ $current_day }} @endif</h3>
				  <!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive">
					@if(!empty($logs))
						<table id="logger" class="table table-bordered table-hover" data-order='[[ 0, "desc" ]]'>
							<thead>
								<tr>
									<th>Time</th>
									<th>Level</th>
									<th>Context</th>
									<th>Message</th>
									<th class="text-right">track</th>
								</tr>
							</thead>
							<tbody>
								@foreach($logs as $key => $Clog)
									<tr>
										<td>{{ $Clog['time'] }}</td>
										<td><span class="label @if($Clog['level'] == 'debug' || $Clog['level'] == 'info' || $Clog['level'] == 'notice') label-info @elseif($Clog['level'] == 'warning') label-warning @else label-danger @endif">{{ $Clog['level'] }}</span></td>
										<td>{{ $Clog['context'] }}</td>
										<td>{!! str_limit($Clog['text'], 150, '... <a data-empty-stack="' . empty($Clog['stack']) . '" data-full-date="' . str_replace([' ', ':'], '-', $Clog['full_date']) . '-'. $key .'" href="#" data-toggle="modal" data-target="#fullStack">See full stack</a>') !!}
											<span id="fullText-{{ str_replace([' ', ':'], '-', $Clog['full_date']) }}-{{ $key }}" style="display:none;">
												{{ $Clog['in_file'] }}<br/>
												{!! str_replace('#', '<br/>#', $Clog['text']) !!}
											</span>
											<span id="stackTrace-{{ str_replace([' ', ':'], '-', $Clog['full_date']) }}-{{ $key }}" style="display:none;">
												{{ $Clog['in_file'] }}<br/>
												{!! str_replace('#', '<br/>#', $Clog['stack']) !!}
											</span>
										</td>
										<td class="text-right">
											<a href="#" data-empty-stack="{{ empty($Clog['stack']) }}" data-full-date="{{ str_replace([' ', ':'], '-', $Clog['full_date']) }}-{{ $key }}" data-toggle="modal" data-target="#fullStack"><button class="btn btn-icon-toggle"><i class="fa fa-eye"></i></button></a>
										</td>
									</tr>
							   @endforeach
							</tbody>
						</table>
					@else
						<p style="text-align: center;">No matching records found.</p>
					@endif
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Change log settings</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ route('admin.log.settings') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
							<label for="logLevel" class="control-label">Log level (levels of severity):</label>
							<select id="logLevel" class="form-control " name="logLevel" >
								<option value="emergency" @if(config('app.log_level') == 'emergency') selected @endif>Emergency (system is unusable)</option>
								<option value="alert" @if(config('app.log_level') == 'alert') selected @endif>Alert (action must be taken immediately)</option>
								<option value="critical" @if(config('app.log_level') == 'critical') selected @endif>Critical (critical conditions)</option>
								<option value="error" @if(config('app.log_level') == 'error') selected @endif>Error (error conditions)</option>
								<option value="warning" @if(config('app.log_level') == 'warning') selected @endif>Warning (warning conditions)</option>
								<option value="notice" @if(config('app.log_level') == 'notice') selected @endif>Notice (normal but significant condition)</option>
								<option value="info" @if(config('app.log_level') == 'info') selected @endif>Info (informational messages)</option>
								<option value="debug" @if(config('app.log_level') == 'debug') selected @endif>Debug (debug-level messages)</option>
							</select>
							<p class="help-block">Your search engine will log all levels greater than or equal to the specified severity. Order of severity starts from <span class="label label-info">Debug</span> to <span class="label label-danger">Emergency</span></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<label for="LogMaxDays" class="control-label">Maximum days in log:</label>
							<input type="number" name="LogMaxDays" id="LogMaxDays" class="form-control" value="{{ config('app.log_max_files') }}">
							<p class="help-block">The search engine will remove logs more than Maximum days. Setting a large max days may slow down your logger load.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitLogSettings" value="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->


<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="fullStack" tabindex="-1" role="dialog" aria-labelledby="formModalLabelFullStack" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabelFullStack">Stack trace</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ route('admin.log.settings') }}" method="post">
				<div class="modal-body">
					<p class='fullTextViewer' style="word-break: break-all;"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->

@endsection

@section('javascript')
<script src="{{ URL::asset('assets/admin/plugins/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
//Date picker
$('#datepicker').datepicker({
  autoclose: true,
  todayHighlight: true,
  weekStart: 1,
  startDate: '{{ $startDate }}',
  endDate: '0d',
}).on('changeDate', function(e) {
    window.location.href = '?day=' + $(this).val();
});;
	
$(function () {
    $('#logger').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'select'      : true,
      'autoWidth'   : false
    });
});

$('#fullStack').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var fullTextId = '#fullText-'+ button.attr('data-full-date');
	var stackTraceId = '#stackTrace-'+ button.attr('data-full-date');
	var fullText = $(fullTextId).html();
	// console.log(fullTextId);
	var stackTrace = $(stackTraceId).html();
	if (!button.attr('data-empty-stack')) {
		text = stackTrace;
	}else if(button.attr('data-empty-stack')){
		text = fullText;
	}else{
		text = 'There is no stack trace.'
	}
	$(this).find('.fullTextViewer').html(text);
});

function confirmClearAll(event){
	var r = confirm("Are you sure you want to clear all logs.\nIf yes click on OK button");
	if (!r) {
        event.preventDefault();
		return false;
	}
}

function confirmClear(event){
	var r = confirm("Are you sure you want to clear this log.\nIf yes click on OK button");
	if (!r) {
        event.preventDefault();
		return false;
	}
}
</script>
@endsection