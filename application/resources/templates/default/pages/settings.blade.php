@extends('pageLayout')

@section('title', trans('general.preferences_title') . ' - ')

@section('content')
<div class="row form_page">	
	<div class="container">
		<div class="col m4 s12 left-side">
			@include('inc.leftMenu', ['activeItem' => 'preferences'])
		</div>
		<div class="col m8 s12">
			@if(Session::has('message'))
				<div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
			@endif
			<form action="{{ route('preferences') }}" method="post">
				<div class="block">
					<p class="block-title">{{  trans('general.safesearch_filters') }}</p>
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col s12">
									<input name="safeSearch" type="checkbox" value="2" class="filled-in" id="filled-in-box" 
									@if(Auth::check()) 
										@if($user->getSearchReference('safeSearch')) checked="checked" @endif 
									@else
										@if(Session::has('safeSearch')) 
											@if(Session::get('safeSearch')) checked="checked" @endif 
										@else 
											@if($settings['safeSearch']) checked="checked" @endif
										@endif 
									@endif 
									/>
									<label for="filled-in-box">{{  trans('general.turn_safesearch') }}</label>
									<p>{{  trans('general.sefesearch_help', ['name' => $settings['siteName']]) }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="block">
					<p class="block-title">{{  trans('general.restrict_region') }}</p>
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col s12">
									<select name="regionMode" id="regionMode" class="browser-default">
										<option value="0" @if($regionMode == 0) selected @endif>{{  trans('general.all_countries') }}</option>
										<option value="1" @if($regionMode == 1) selected @endif>{{  trans('general.only_country') }}</option>
										<option value="2" @if($regionMode == 2) selected @endif>{{  trans('general.boost_country') }}</option>
									</select>
									<p>{{ trans('general.restrict_region_help') }}</p>
									
								</div>
							</div>
							<div class="row" id="region-block">
								<hr/>
								<div class="col s12">
									<p>{{ trans('general.region_set_to') }} <b>{{ config('locales.'.$region) }}</b></p>
									<select name="region" class="browser-default">
										<option value="">{{ trans('general.change_country') }}</option>
										@foreach(explode(',', $settings['countries']) as $Ccode)
											<option value="{{ $Ccode }}" @if($Ccode == $region) selected @endif> {{ config('locales.'.$Ccode) }} </option>
										@endforeach
									</select>
									<p>{{ trans('general.change_country_help') }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="block">
					<p class="block-title">{{ trans('general.display_lang') }}</p>
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="cols12">
									<p>{{ trans('general.chnage_lang') }}</p>
									<select name="language" id="language" class="browser-default">
										@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
											<option value="{{ $localeCode }}" @if($regionMode == 0) selected @endif>{{ $properties['native'] }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="block">
					<p class="block-title">{{ trans('general.where_results_open') }}</p>
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col s12">
									<input name="resultsTarget" type="checkbox" value="1" class="filled-in" id="resultsTarget"
									@if(Auth::check()) 
										@if($user->getSearchReference('resultsTarget')) checked="checked" @endif 
									@else
										@if(Session::has('resultsTarget')) 
											@if(Session::get('resultsTarget')) checked="checked" @endif 
										@else 
											@if($settings['resultsTarget']) checked="checked" @endif
										@endif
									@endif />
									<label for="resultsTarget">{{ trans('general.open_results_new_win') }}</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="block">
					<p class="block-title">{{ trans('general.advanced') }}</p>
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col s12">
									<input name="darkMode" type="checkbox" value="1" class="filled-in" id="darkMode"
									@if(Auth::check())
										@if($user->getSearchReference('darkMode')) checked="checked" @endif
									@else
										@if(Session::has('darkMode'))
											@if(Session::get('darkMode')) checked="checked" @endif
										@else
											@if($settings['darkMode']) checked="checked" @endif
										@endif
									@endif />
									<label for="darkMode">{{ trans('general.enable_dark_mode') }}</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<input name="collectData" type="checkbox" value="1" class="filled-in" id="collectData"
									@if(Auth::check())
										@if($user->getSearchReference('collectData')) checked="checked" @endif
									@else
										@if(Session::has('collectData'))
											@if(Session::get('collectData')) checked="checked" @endif
										@else
											@if($settings['collectData']) checked="checked" @endif
										@endif
									@endif />
									<label for="collectData">{{ trans('general.let_our_se_collect') }}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row center"><button name="submitSettings" value="Submit" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.submit') }}</button></div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script>
$('#regionMode').change(function(){
	block = $('#region-block');
	if($(this).val() == 2){
		block.show();
	}else if($(this).val() == 1){
		block.show();
	}else{
		block.hide();
	}
});

@if($regionMode == 0) 
	$('#region-block').hide();
@endif


$('#langLimitN').on('click', function(){
	$('#selectLimitLangs').hide();
});
$('#langLimitY').on('click', function(){
	$('#selectLimitLangs').show();
});

$('#language').val("{{ LaravelLocalization::getCurrentLocale() }}");
</script>
@endsection