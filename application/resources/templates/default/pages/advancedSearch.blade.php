@extends('pageLayout')

@section('title', trans('general.advanced_search_title') . ' - ')

@section('content')
	<div class="row form_page">
		<div class="row">
			<div class="container">
				<div class="col m4 s12 left-side">
					@include('inc.leftMenu', ['activeItem' => 'web_adv'])
				</div>
				<div class="col m8 s12">
					@if(Session::has('message'))
						<div class="col s12"><div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div></div>
					@endif
					<form action="{{ action('GeneralController@postAdvancedSearch') }}" method="post">
						<div class="col s12">
							<div class="block">
								<p class="block-title">{{ trans('general.find_pages_with') }}</p>
								<div class="card">
									<div class="card-content">
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.all_these_words') }}:<p>
											</div>
											<div class="col m6 s12 input-field">
												<input name="q" type="text" value="" id="q" placeholder="{{ trans('general.all_these_words') }}"/>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.largest_country') }}:</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.exact_word') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<input name="exact" type="text" value="" id="exact" placeholder="{{ trans('general.exact_word') }}"/>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.eg_exact_word') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.any_words') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<input name="any" type="text" value="" id="any" placeholder="{{ trans('general.any_words') }}"/>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.eg_any_words') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.none_words') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<input name="none" type="text" value="" id="none" placeholder="{{ trans('general.none_words') }}"/>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.eg_none_words') }}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="block">
								<p class="block-title">{{ trans('general.narrow_results') }}</p>
								<div class="card">
									<div class="card-content">
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.safesearch') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<select name="safeSearch" class="browser-default">
													<option value="1" selected>{{ trans('general.filter_explicit') }}</option>
													<option value="0">{{ trans('general.show_most_relevant') }}</option>
												</select>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.tell_safesearch') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.file_type') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<select name="fileType" class="browser-default">
													<option value="" selected>{{ trans('general.any_format') }}</option>
													@foreach($fileTypes as $fileType)
														<option value="{{ $fileType }}">{{ ucfirst($fileType) }}</option>
													@endforeach
												</select>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.find_pages_format') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.last_update') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<select name="time" class="browser-default">
													<option value="-1" selected>{{ trans('general.any_time') }}</option>
													@foreach($dates as $dt => $dtV)
														<option value="{{ $dt }}">{{ $dtV }}</option>
													@endforeach
												</select>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.pages_within_time') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.region') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<select name="region" class="browser-default">
													<option value="any" selected>{{ trans('general.any_region') }}</option>
													@foreach($countries as $country)
														<option value="{{ $country }}">{{ array_get(config('locales'), $country) }}</option>
													@endforeach
												</select>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.published_region') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.site_or_domain') }}:</p>
											</div>
											<div class="col m6 s12 input-field">
												<input name="site" type="text" value="" id="site" placeholder="{{ trans('general.site_or_domain') }}"/>
											</div>
											<div class="col m3 s12 example">
												<p>{{ trans('general.eg_site_or_domain') }}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row center"><button name="token" value="{{ csrf_token() }}" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.search') }}</button></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	<script>
		$('#langLimitN').on('click', function(){
			$('#selectLimitLangs').hide();
		});
		$('#langLimitY').on('click', function(){
			$('#selectLimitLangs').show();
		});

		$('#language').val("{{ LaravelLocalization::getCurrentLocale() }}");
	</script>
@endsection