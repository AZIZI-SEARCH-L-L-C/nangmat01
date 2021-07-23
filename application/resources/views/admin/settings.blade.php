@extends('admin.layout')

@section('title', 'General Settings')
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
	Site settings
	<small>breif statistics</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Settings</li>
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
	<form class="form-horizontal save" method="post" id="mainForm" action="{{ URL::action('admin\SettingsController@post') }}">
		<div class="row flex">
			<div class="col-lg-9 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					  <h3 class="box-title">Advanced settings</h3>
					  <!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<!--div class="form-group">
							<label class="col-sm-12">Time zone</label>
							<select class="form-control" style="margin: 0 auto;width:90%">
								<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
								<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
								<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
								<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
								<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
								<option value="America/Anchorage">(GMT-09:00) Alaska</option>
								<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
								<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
								<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
								<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
								<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
								<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
								<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
								<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
								<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
								<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
								<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
								<option value="America/Havana">(GMT-05:00) Cuba</option>
								<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
								<option value="America/Caracas">(GMT-04:30) Caracas</option>
								<option value="America/Santiago">(GMT-04:00) Santiago</option>
								<option value="America/La_Paz">(GMT-04:00) La Paz</option>
								<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
								<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
								<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
								<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
								<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
								<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
								<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
								<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
								<option value="America/Godthab">(GMT-03:00) Greenland</option>
								<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
								<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
								<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
								<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
								<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
								<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
								<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
								<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
								<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
								<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
								<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
								<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
								<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
								<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
								<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
								<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
								<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
								<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
								<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
								<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
								<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
								<option value="Asia/Damascus">(GMT+02:00) Syria</option>
								<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
								<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
								<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
								<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
								<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
								<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
								<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
								<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
								<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
								<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
								<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
								<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
								<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
								<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
								<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
								<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
								<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
								<option value="Australia/Perth">(GMT+08:00) Perth</option>
								<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
								<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
								<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
								<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
								<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
								<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
								<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
								<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
								<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
								<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
								<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
								<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
								<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
								<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
								<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
								<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
								<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
								<option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
								<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
							</select>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="private" name="usersLogin" class="minimal" @if(Config::get('app.private', false)) checked @endif>
								Make the search engine private (for registered users only).
							</label>
						</div-->
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="logNotifications" name="logNotifications" class="minimal" @if($settings['logNotifications']) checked @endif>
								Enable notifactions for errors
							</label>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="cache" name="cache" class="minimal" @if($settings['cache']) checked @endif>
								Enable cache
							</label>
						</div>
						<div class="form-group">
							<label for="cacheTime" class="col-sm-2 control-label">Cache time:</label>
							<div class="col-sm-10">
								<input type="number" name="cacheTime" id="cacheTime" class="form-control" value="{{ $settings['cacheTime'] }}">
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
			<div class="col-md-3 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					  <h3 class="box-title">System Mode</h3>
					</div>
					<div class="box-body">
					    <a href="#" class="btn btn-primary" id="systemProduction">Production</a>
					    <a href="#" class="btn btn-default" id="systemDevelopment">Development</a>
						<p id="systemModeShowP">Your search engine is currently in Production mode. Most error messages are hidden and caching is enabled. If you want to make changes to your CSS layout or view scripts, please switch to Development Mode first.</p>
						<p id="systemModeShowD">Your search engine is currently in Development mode. Most error messages are live and caching is disabled for testing.</p>
					</div>
					<div class="overlay" id="systemModeOverlay" style="display:none;">
					  <i class="fa fa-refresh fa-spin"></i>
					</div>
				</div>
			</div>
        </div>

		<div class="row flex">
			<div class="col-lg-6 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Site Informations</h3>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label for="siteName" class="col-sm-3 control-label">Site title:</label>
							<div class="col-sm-9">
								<input type="text" name="siteName" id="siteName" class="form-control" value="{{ $settings['siteName'] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="siteDescription" class="col-sm-3 control-label">Site description:</label>
							<div class="col-sm-9">
								<textarea col="3" name="siteDescription" id="siteDescription" class="form-control">{{ $settings['siteDescription'] }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="siteEmail" class="col-sm-3 control-label">Site Email:</label>
							<div class="col-sm-9">
								<input type="text" name="siteEmail" id="siteEmail" class="form-control" value="{{ $settings['siteEmail'] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="siteDomain" class="col-sm-3 control-label">Site domain:</label>
							<div class="col-sm-9">
								<input type="text" name="siteDomain" id="siteDomain" class="form-control" value="{{ $settings['siteDomain'] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="companyName" class="col-sm-3 control-label">Company name:</label>
							<div class="col-sm-9">
								<input type="text" name="companyName" id="companyName" class="form-control" value="{{ $settings['companyName'] }}">
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
			<div class="col-lg-6 flex">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Search settings</h3>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="resultsInfo" name="resultsInfo" class="minimal" @if($settings['resultsInfo']) checked @endif>
								Show results info
							</label>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="keywordsSuggestion" name="keywordsSuggestion" class="minimal" @if($settings['keywordsSuggestion']) checked @endif>
								Enable auto complete
							</label>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="relatedKeywords" name="relatedKeywords" class="minimal" @if($settings['relatedKeywords']) checked @endif>
								enable keywords suggestion
							</label>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="speachInput" name="speachInput" class="minimal" @if($settings['speachInput']) checked @endif>
								Enable speech input
							</label>
						</div>
						<div class="form-group">
							<label class="col-sm-12">Results target</label>
							<select class="form-control" name="resultsTarget" style="margin: 0 auto;width:90%">
								<option value="_self" @if($settings['resultsTarget'] == '_self') selected @endif>Same window</option>
								<option value="_blank" @if($settings['resultsTarget'] == '_blank') selected @endif>new window</option>
							</select>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="enable_comments" name="enable_comments" class="minimal" @if($settings['enable_comments']) checked @endif>
								Enable users comments
							</label>
						</div>
						<div class="form-group">
							<label class="col-sm-12">
								<input type="checkbox" id="enable_bookmarks" name="enable_bookmarks" class="minimal" @if($settings['enable_bookmarks']) checked @endif>
								Enable users bookmarks
							</label>
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
function updateSystemMode(sys){
	if(sys == 'local'){
		$("#systemProduction").attr('class', 'btn btn-default');
		$("#systemDevelopment").attr('class', 'btn btn-primary');
		$("#systemModeShowP").hide();
		$("#systemModeShowD").show();
	}else if(sys == 'production'){
		$("#systemDevelopment").attr('class', 'btn btn-default');
		$("#systemProduction").attr('class', 'btn btn-primary');
		$("#systemModeShowP").show();
		$("#systemModeShowD").hide();
	}
}
var systemMode = '{{ config('app.env') }}';
updateSystemMode(systemMode);

$( "#save" ).click(function() {
	$('#mainForm').submit();
});

$( "#systemProduction" ).click(function() {
	$mode = 'production';
	updateSystemModeAjax($mode);
	return false;
});

$( "#systemDevelopment" ).click(function() {
	$mode = 'local';
	updateSystemModeAjax($mode);
	return false;
});

function updateSystemModeAjax($mode){
	$('#systemModeOverlay').show();
	$.ajax({
		url: "{{ route('admin.api.ajax.systemMode') }}",
		type: "post",
        data: {mode: $mode}
	}).done(function(d) {
		updateSystemMode($mode);
		$('#systemModeOverlay').hide();
		if($mode == 'local'){
			sendMessage('alert-success', 'Development mode is now enabled.');
		}else{
			sendMessage('alert-success', $mode + ' mode is now enabled.');
		}
	}).fail(function(d) {
		sendMessage('alert-danger', d.responseText);
		$('#systemModeOverlay').hide();
	});
}
</script>
@endsection