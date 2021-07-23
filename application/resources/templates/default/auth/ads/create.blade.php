@extends('pageLayout')

@section('title', trans('general.create_new_ad'))

@section('css')
	<link href="{{ asset('assets/templates/default/css/tip-yellowsimple.css') }}" rel="stylesheet"/>
	<link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
@endsection

@section('content')
	<style>
		.form_page .block .card {
			margin: 0 0 2px 0 !important;
		}
		.form_page .input-field .prefix{
			padding: .5rem;
		}
		.form_page .preview{
			position: sticky;
			top: 20px;
			z-index: 22;
		}
		.bold{
			font-weight: 700;
		}
		.second-text{
			color: #9e9e9e;
			font-size: 10px;
		}

		.collapsible input{
			background: #fff;
		}

		.collapsible{
			margin: 0 0 0 10px;
			box-shadow: none;
		}
		.collapsible-body{
			padding: 20px;
			background: #fff;
		}
		.collapsible-body p{
			padding: 0;
		}
		.chip{
			margin: 7px 2px 0 0;
			border-radius: 0;
		}
		.new_ad .card-panel{
			margin-left: 10px;
		}
	</style>
	<div class="row form_page new_ad">
		<div class="row">
			<div class="container">
				<div class="col s12">
					<form action="{{ route('ads.new.post') }}" method="post">
						<div class="row">
							<div class="col s12 bottommargin">
								<a href="{{ route('ads.compains') }}" class="waves-effect btn_form_page modal-trigger"><i class="material-icons tiny">navigate_before</i>
									{{ trans('general.back') }}</a>
							</div>
							<div class="row">
								<div class="col m8 s12">
									<div class="block">
										@if ($errors->any())
											@foreach ($errors->all() as $key => $error)
												<div class="card-panel red lighten-2">{{ $error }} </div>
											@endforeach
										@endif
										@if(Session::has('message'))
											<div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
										@endif
										<ul class="collapsible" data-collapsible="accordion">
											<li>
												<div class="collapsible-header active"><i>1</i> {{ trans('general.basic_ad_info') }} <span class="red-text">*</span></div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<span>{{ trans('general.when_you_paid') }} <span class="red-text">*</span></span>
														</div>
														<div class="col m9 s12 input-field">
															<select name="chargeType" id="chargeType" class="browser-default">
																<option value="0" @if(old('chargeType') == 0) selected @endif>{{ trans('general.per_click') }}</option>
																<option value="1" @if(old('chargeType') == 1) selected @endif>{{ trans('general.per_impression') }}</option>
																<option value="2" @if(old('chargeType') == 2) selected @endif>{{ trans('general.per_day') }}</option>
															</select>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<span>{{ trans('general.select_campaign') }} <span class="red-text">*</span></span>
														</div>
														<div class="col m9 s12 input-field" id="compain-field">
															<select name="compain" id="compain" class="browser-default">
																@if(!$compains->isEmpty())
																	@foreach($compains as $Ccompain)
																		<option value="{{ $Ccompain->id }}" @if($Ccompain->id == $compain) selected @elseif(old('compain') == $Ccompain->id) selected @endif>{{ $Ccompain->name }}</option>
																	@endforeach
																@else
																	<option value="-1"><--- {{ trans('general.no_campaigns_select') }} ---></option>
																@endif
															</select>
															<span class="charNum"><a href="#" class="editable editable-click" data-placement="bottom" data-emptytext="enter your compain name" data-value="" data-pk="1" data-name="compainName" id="compainName" data-send="always" data-type="text" data-url="{{ route('ajax.ads.compain.create') }}" data-title="{{ trans('general.create_new_campaign') }}">{{ trans('general.create_new_campaign') }}</a></span>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<span>{{ trans('general.ad_unit_name') }}:</span>
														</div>
														<div class="col m9 s12 input-field">
															<input name="adUnitName" type="text" value="{{ old('adUnitName') }}" id="adUnitName" />
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>2</i> {{ trans('general.design_your_ad') }} <span class="red-text">*</span></div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<span>{{ trans('general.ad_form_title') }} <span class="red-text">*</span></span>
														</div>
														<div class="col m9 s12 input-field">
															<input class="count" data-length="25" name="adTitle" type="text" value="{{ old('adTitle') }}" id="adTitle" />
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<span for="adDescription">{{ trans('general.ad_form_desc') }} <span class="red-text">*</span></span>
														</div>
														<div class="col m9 s12 input-field">
															<textarea id="adDescription" name="adDescription" class="textarea" rows="5">{{ old('adDescription') }}</textarea>
															<span class="charNum"><span id="charNum"></span>/255</span>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_vurl') }} <span class="red-text">*</span></p>
														</div>
														<div class="col m9 s12 input-field">
															<input name="adVurl" type="text" value="{{ old('adVurl') }}" id="adVurl" />
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>3</i> {{ trans('general.ad_form_keywords_url') }} <span class="red-text">*</span></div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<p for="adKeywords">{{ trans('general.ad_form_keywords') }} <span class="red-text">*</span></p>
														</div>
														<div class="col m9 s12 input-field">
															<input id="adKeywords" name="adKeywords" value="" data-role="materialtags"/>
															<span class="charNum">{{ trans('general.ad_form_each_word') }}</span>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_url') }} <span class="red-text">*</span></p>
														</div>
														<div class="col m9 s12 input-field">
															<input name="adURL" type="text" value="{{ old('adURL') }}" id="adURL" />
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>4</i> {{ trans('general.ad_form_when_ad') }} <span class="red-text">*</span></div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<p for="show_in" class="tooltipped" data-position="top" data-delay="50" data-tooltip="I am a tooltip">{{ trans('general.ad_form_ad_in') }}: <span class="red-text">*</span></p>
														</div>
														<div class="col m9 s12 input-field">
															<select name="show_in[]" id="show_in" multiple class="browser-default" style="height:auto;" rows="5">
																<option value="0">{{ trans('general.ad_form_engines') }}</option>
																@foreach($engines as $Cengine)
																	<option value="{{ $Cengine['name'] }}"
																			@if(old('show_in'))
																			@if(in_array($Cengine['name'], old('show_in'))) selected @endif
																			@endif
																	>{{ trans('engines.'.$Cengine['slug']) }}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>5</i>{{ trans('general.ad_form_users_interests') }}</div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_age') }}</p>
														</div>
														<div class="col m2 s6" style="margin-top:15px;">
															<select name="ageFrom" id="ageFrom" class="browser-default">
																<option value="" @if(!old('ageFrom')) selected @endif>{{ trans('general.ad_form_any') }}</option>
																@for($i = 13; $i < 65; $i++)
																	<option value="{{ $i }}" @if(old('ageFrom') == $i) selected @endif>{{ $i }}</option>
																@endfor
																<option value="65" @if(old('ageFrom') == 65) selected @endif>65+</option>
															</select>
														</div>
														<div class="col m2 s6" style="margin-top:15px;">
															<select name="ageTo" id="ageTo" class="browser-default">
																<option value="" @if(!old('ageTo')) selected @endif>{{ trans('general.ad_form_any') }}</option>
																@for($i = 13; $i < 65; $i++)
																	<option value="{{ $i }}" @if(old('ageTo') == $i) selected @endif>{{ $i }}</option>
																@endfor
																<option value="65" @if(old('ageTo') == 65) selected @endif>65+</option>
															</select>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_gender') }}</p>
														</div>
														<div class="col m4 s12" style="margin-top:15px;">
															<select name="gender" id='gender' class="browser-default">
																<option value="" @if(!old('gender')) selected @endif>{{ trans('general.ad_form_any') }}</option>
																<option value="1" @if(old('gender') == 1) selected @endif>{{ trans('general.ad_form_male') }}</option>
																<option value="2" @if(old('gender') == 2) selected @endif>{{ trans('general.ad_form_female') }}</option>
															</select>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_languages') }}</p>
														</div>
														<div class="col m9 s12" style="margin-top:15px;">
															<input id="languages" name="languages" data-role="materialtags"/>
														</div>
													</div>
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_interests') }}</p>
														</div>
														<div class="col m9 s12" style="margin-top:15px;">
															<input id="interests" name="interests" data-role="materialtags"/>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>6</i> {{ trans('general.ad_form_geo_targeting_options') }}</div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_geo_targeting') }}</p>
														</div>
														<div class="col m9 s12" style="margin-top:15px;">
															<input type="checkbox" name="geoTurn" id="geoTurn" value="1" class="filled-in" id="filled-in-box" @if(old('geoTurn') == 1) checked @endif/>
															<label for="geoTurn">{{ trans('general.ad_form_use_geo') }}</label>
														</div>
													</div>
													<div id="geoTargeting">
														<div class="row">
															<div class="col m3 s12 input-field">
																<p>{{ trans('general.ad_form_continents') }}</p>
															</div>
															<div class="col m9 s12" style="margin-top:15px;">
																<input type="checkbox" name="continentTurn" id="continentTurn" value="1" class="filled-in" id="filled-in-box" @if(old('continentTurn') == 1) checked @endif/>
																<label for="continentTurn">{{ trans('general.ad_form_only_continents') }}</label>
															</div>
														</div>
														<div class="row" id="continentsContainer">
															<div class="col m3 s12 input-field">
																<p for="continent"></p>
															</div>
															<div class="col m9 s12 input-field">
																<input id="continents" name="continents" data-role="materialtags"/>
															</div>
														</div>
														<div class="row">
															<div class="col m3 s12 input-field">
																<p>{{ trans('general.ad_form_inc_countries') }}</p>
															</div>
															<div class="col m9 s12" style="margin-top:15px;">
																<input type="checkbox" name="countriesTurn1" id="countriesTurn1" value="1" class="filled-in" id="filled-in-box" @if(old('countriesTurn1') == 1) checked @endif/>
																<label for="countriesTurn1">{{ trans('general.ad_form_inc_only_countries') }}</label>
															</div>
														</div>
														<div class="row" id="countriesContainer1">
															<div class="col m3 s12 input-field">
																<p for="inc_countries"></p>
															</div>
															<div class="col m9 s12 input-field">
																<input id="inc_countries" name="inc_countries" data-role="materialtags"/>
															</div>
														</div>
														<div class="row">
															<div class="col m3 s12 input-field">
																<p>{{ trans('general.ad_form_exc_countries') }}</p>
															</div>
															<div class="col m9 s12" style="margin-top:15px;">
																<input type="checkbox" name="countriesTurn2" id="countriesTurn2" value="1" class="filled-in" id="filled-in-box" @if(old('countriesTurn2') == 1) checked @endif/>
																<label for="countriesTurn2">{{ trans('general.ad_form_exc_only_countries') }}</label>
															</div>
														</div>
														<div class="row" id="countriesContainer2">
															<div class="col m3 s12 input-field">
																<p for="exc_countries"></p>
															</div>
															<div class="col m9 s12 input-field">
																<input id="exc_countries" name="exc_countries" data-role="materialtags"/>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>7</i> {{ trans('general.ad_form_schedule') }} <span class="red-text dateChooser">*</span></div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_schedule') }}:</p>
														</div>
														<div class="col m9 s12" style="margin-top:15px;">
															<p>
																<input class="with-gap" value="0" @if(!old('scheduleTurn')) checked @endif name="scheduleTurn" type="radio" id="scheduleTurnOff" />
																<label for="scheduleTurnOff">{{ trans('general.ad_form_run_ad_continuously') }}</label>
															</p>
															<p>
																<input class="with-gap" value="1" @if(old('scheduleTurn')) checked @endif name="scheduleTurn" type="radio" id="scheduleTurnON" />
																<label for="scheduleTurnON">{{ trans('general.ad_form_start_day') }}</label>
															</p>
														</div>
													</div>
													<div id="scheduleContainer">
														<div class="row">
															<div class="col m3 s12 input-field">
																<p for="startDate">{{ trans('general.ad_form_start') }} <span class="red-text dateChooser">*</span></p>
															</div>
															<div class="col m5 s12 input-field">
																<i class="material-icons prefix">date_range</i>
																<input type="text" name="startDate" value="{{ old('startDate') }}" id="startDate" placeholder="Start Date" class="datepicker">
															</div>
															<div class="col m4 s12 input-field">
																<i class="material-icons prefix">access_time</i>
																<input type="text" name="startTime" value="{{ old('startTime') }}" id="startTime" placeholder="Start Time" class="timepicker">
															</div>
														</div>
														<div class="row">
															<div class="col m3 s12 input-field">
																<p for="endDate">{{ trans('general.ad_form_end') }} <span class="red-text dateChooser">*</span></p>
															</div>
															<div class="col m5 s12 input-field">
																<i class="material-icons prefix">date_range</i>
																<input type="text" name="endDate" value="{{ old('endDate') }}" id="endDate" placeholder="End Date" class="datepicker">
															</div>
															<div class="col m4 s12 input-field">
																<i class="material-icons prefix">access_time</i>
																<input type="text" name="endTime" value="{{ old('endTime') }}" id="endTime" placeholder="End Time" class="timepicker">
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="collapsible-header"><i>8</i> {{ trans('general.ad_form_budget') }}</div>
												<div class="collapsible-body">
													<div class="row">
														<div class="col m3 s12 input-field">
															<p>{{ trans('general.ad_form_budget_source') }}</p>
														</div>
														<div class="col m9 s12" style="margin-top:15px;">
															<p>
																<input class="with-gap" value="0" @if(!old('budgetTurn')) checked @endif name="budgetTurn" type="radio" id="budgetTurnOff" />
																<label for="budgetTurnOff">{{ trans('general.ad_form_run_ad_from_account') }}</label>
															</p>
															<p>
																<input class="with-gap" value="1" @if(old('budgetTurn')) checked @endif name="budgetTurn" type="radio" id="budgetTurnON" />
																<label for="budgetTurnON">{{ trans('general.ad_form_ad_lifetime') }}</label>
															</p>
														</div>
													</div>
													<div id="budgetContainer">
														<div class="row">
															<div class="col m3 s12 input-field">
																<p>{{ trans('general.ad_form_budget') }}:</p>
															</div>
															<div class="col m4 s12 input-field">
																<i class="material-icons prefix">attach_money</i>
																<input name="budget" type="text" value="{{ old('budget') }}" placeholder="0.00" id="budget" />
															</div>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="col m4 s12 preview">
									<div class="block">
										<div class="col s12">
											<!--span class="">Preview Your Ad:</span-->
											<div class="card">
												<div class="card-content">
													<a target="_blank" href="#">
														<span class="result-title" style="line-height:18px;" id="showAdTitle">{{ trans('general.ad_form_ad_example_title') }}</span>
													</a>
													<p class="green-text"><span class="ad badge">Ad</span><span id="showAdVurl">example.com</span></p>
													<p id="showAdDescription">{{ trans('general.ad_form_ad_example_body') }}</p>
												</div>
											</div>
										</div>
										<div class="col s12">
											<div class="card">
												<div class="card-content">
													<div id="estimateContents">
														<p class="bold">
															<span id="costEstimType">{{ trans('general.ad_form_ad_estimated_cost') }}</span>: <span id="costEstimValue">0.00</span>$
														</p>
														<span class="second-text">{{ trans('general.ad_form_ad_cost_based') }}</span>
														<span class="second-text red-text" id="highKeywordCost"></span>
													</div>
													<div class="center" id="estimateLoader" style="display:none;">
														<div class="preloader-wrapper small active">
															<div class="spinner-layer spinner-blue-only">
																<div class="circle-clipper left">
																	<div class="circle"></div>
																</div><div class="gap-patch">
																	<div class="circle"></div>
																</div><div class="circle-clipper right">
																	<div class="circle"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col s12">
											<button style="width:100%;border-radius:0;" name="submitNewAd" value="Update" type="submit" class="waves-effect btn modal-trigger topmargin"/>{{ trans('general.create_new_ad') }}</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	<script src="{{ asset('assets/templates/default/js/jquery.poshytip.js') }}"></script>
	<script src="{{ asset('assets/templates/default/js/jquery-editable-poshytip.js') }}"></script>
	<script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
	<script>
		// keywords cost ----------------
		var primeryKeywords = new Bloodhound({datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: {
				url: '{{ route("ajax.ads.data", ["name" => "primeryKeywords"]) }}',
				cache: false,
			}
		});
		primeryKeywords.initialize();

		$('.editable').editable({
			success: function(response, newValue) {
				$('#compain').append('<option value="'+ response.id +'" selected="selected">'+ newValue +'</option>');
				Materialize.toast($('<span>{!! trans('general.ads_campaign_created', ['name' => "'+ newValue +'"]) !!}</span>'), 10000);
			}
		});
		var $maxLength = 255;

		// on change on of: -------------
		$("#adTitle").keyup(function(){
			$("#showAdTitle").html($(this).val());
			showEstimateValue();
		});
		$("#adDescription").keyup(function(){
			$elem = $(this);
			$("#showAdDescription").html($elem.val());
			var len = $elem.val().length;
			$('#charNum').text($maxLength - len);
			if (len >= $maxLength) {
				$elem.val($elem.val().substring(0, $maxLength));
				var $toastContent = $('<span>{{ trans('general.ad_form_ad_max_desc') }}</span>');
				Materialize.toast($toastContent, 10000);
			}
			showEstimateValue();
		});
		$("#adVurl").keyup(function(){
			$("#showAdVurl").html($(this).val());
			showEstimateValue();
		});
		$("#adURL").keyup(function (){showEstimateValue();});
		//-------------------------------

		$("#geoTurn").change(function (){toggleBlock("#geoTurn", "#geoTargeting");});
		$("#continentTurn").change(function (){toggleBlock("#continentTurn", "#continentsContainer");});
		$("#countriesTurn1").change(function (){toggleBlock("#countriesTurn1", "#countriesContainer1");});
		$("#countriesTurn2").change(function (){toggleBlock("#countriesTurn2", "#countriesContainer2");});


		$('#charNum').text($maxLength - $("#adDescription").val().length);

		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 10, // Creates a dropdown of 15 years to control year,
			today: 'Today',
			clear: 'Clear',
			close: 'Ok',
			format: 'dd-mm-yyyy',
			afterDone: function(){
			},
			closeOnSelect: true // Close upon selecting a date,
		});
		$('.timepicker').pickatime({
			default: 'now', // Set default time: 'now', '1:30AM', '16:30'
			fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
			twelvehour: false, // Use AM/PM or 24-hour format
			donetext: '{{ trans('general.ad_form_ad_ok') }}', // text for done-button
			cleartext: '{{ trans('general.ad_form_ad_clear') }}', // text for clear-button
			canceltext: '{{ trans('general.ad_form_ad_cancel') }}', // Text for cancel-button
			autoclose: false, // automatic close timepicker
			ampmclickable: true, // make AM PM clickable
			aftershow: function(){} // Function for after opening timepicker
		});
		$('.tooltipped').tooltip({delay: 50});

		$( "#chargeType" ).change(function() {
			showEstimateType();
			showEstimateValue();
			showDateChooser();
		});

		$('#adKeywords').on('itemAdded', function(event) {showEstimateValue();});
		$('#adKeywords').on('itemRemoved', function(event) {showEstimateValue();});

		$("#startDate, #startTime, #endDate, #endTime").change(function (){
			if($("#startDate").val() && $("#startTime").val()){
				now = new Date();
				start = parseDate($("#startDate").val() + '-' + $("#startTime").val());
				if((now.getTime() - start.getTime()) > 0){
					Materialize.toast($('<span>{{ trans('general.ad_form_ad_valid_date') }}</span>'), 10000);
					$("#startDate").val('');
					$("#startTime").val('');
				}
			}
			if($("#endDate").val() && $("#endTime").val()){
				end = parseDate($("#endDate").val() + '-' + $("#endTime").val());
				start = parseDate($("#startDate").val() + '-' + $("#startTime").val());
				if((start.getTime() - end.getTime()) > 0){
					Materialize.toast($('<span>{{ trans('general.ad_form_ad_start_after_end') }}</span>'), 10000);
					$("#endDate").val('');
					$("#endTime").val('');
				}
			}
			showEstimateValue();
			// getDaysDiffShowCost();
		});

		function getDaysDiffShowCost(){
			$start = $("#startDate").val() + '-' + $("#startTime").val();
			$end = $("#endDate").val() + '-' + $("#endTime").val();
			$days = daydiff($start, $end);
			return $days;
		}

		$("#scheduleTurnON, #scheduleTurnOff").change(function (){
			if($("#scheduleTurnON").prop('checked')){
				$("#scheduleContainer").show();
				return;
			}
			if($("#scheduleTurnOff").prop('checked')){
				$("#scheduleContainer").hide();
				return;
			}
		});

		$("#budgetTurnON, #budgetTurnOff").change(function (){
			showBudgetField();
		});

		function showBudgetField(){
			if($("#budgetTurnON").prop('checked')){
				$("#budgetContainer").show();
				return;
			}
			if($("#budgetTurnOff").prop('checked')){
				$("#budgetContainer").hide();
				return;
			}
		}

		function showDateChooser(){
			if($("#chargeType").val() == 2){
				$(".dateChooser").show();
				$("#scheduleTurnON").prop('checked', true);
				$("#scheduleTurnOff").prop('checked', false);
				$("#scheduleContainer").show();
				$("#scheduleTurnOff").prop('disabled', true);

				$("#budgetTurnON").prop('checked', true);
				$("#budgetTurnOff").prop('checked', false);
				$("#budgetContainer").show();
				$("#budgetTurnOff").prop('disabled', true);
			}else{
				$(".dateChooser").hide();
				$("#scheduleTurnON").prop('checked', false);
				$("#scheduleTurnOff").prop('checked', true);
				$("#scheduleContainer").hide();
				$("#scheduleTurnOff").prop('disabled', false);

				$("#budgetTurnON").prop('checked', false);
				$("#budgetTurnOff").prop('checked', true);
				$("#budgetContainer").hide();
				$("#budgetTurnOff").prop('disabled', false);
			}
			showEstimateValue();
		}

		function showEstimateType(){
			if($("#chargeType").val() == 0){
				$("#costEstimType").html('Estimated cost per click');
			}else if($("#chargeType").val() == 1){
				$("#costEstimType").html('Estimated cost per click');
			}else if($("#chargeType").val() == 2){
				$("#costEstimType").html('Cost per Day');
			}
		}

		function showEstimateValue(){
			// start loading
			showEstimateLoaderOrContents(true);
			// initial cost -----------------
			var cost = 0;
			if($("#chargeType").val() == 0){
				cost += {{ $settings['initialCost0'] }};
			}else if($("#chargeType").val() == 1){
				cost += {{ $settings['initialCost1'] }};
			}else if($("#chargeType").val() == 2){
				cost += {{ $settings['initialCost2'] }};
			}
			// ------------------------------

			// primery Keywords more --------
			var premKeywords = [];
			var InitialCost = cost;
			$.map(primeryKeywords.index.datums, function( id,primeryKeywordJson ) {
				var primeryKeyword = $.parseJSON(primeryKeywordJson);
				var keyword = primeryKeyword.keyword.toLowerCase();
				// primery Keywords more --------
				if (document.getElementById("adKeywords").value.toLowerCase().indexOf(keyword) >= 0
						|| document.getElementById("adTitle").value.toLowerCase().indexOf(keyword) >= 0
						|| document.getElementById("adVurl").value.toLowerCase().indexOf(keyword) >= 0
						|| document.getElementById("adURL").value.toLowerCase().indexOf(keyword) >= 0
						|| document.getElementById("adDescription").value.toLowerCase().indexOf(keyword) >= 0){
					cost += InitialCost * (primeryKeyword.leverage / 100);
					premKeywords.push(keyword);
				}
			});

			// Add premier keyword if available
			if(premKeywords.length !== 0 && premKeywords.length === 1){
				$("#highKeywordCost").html('<p>{!! trans('general.ad_form_ad_keyword_is_premium', ['keyword' => "' + premKeywords.join(\", \") + '"]) !!} <a target="_blank" href="{{ route('premium.keywords') }}">{{ trans('general.ad_form_ad_read_more') }}</a></p>');
			}else if(premKeywords.length !== 0 && premKeywords.length !== 1){
				$("#highKeywordCost").html('<p>{!! trans('general.ad_form_ad_keyword_is_premium', ['keyword' => "' + premKeywords.join(\", \") + '"]) !!}  <a target="_blank" href="{{ route('premium.keywords') }}">{{ trans('general.ad_form_ad_read_more') }}</a></p>');
			}else{
				$("#highKeywordCost").html('');
			}
			// ------------------------------

			// additinal factors--
			@if($costFactors)
					@foreach($costFactors as $costFactor)
					elem = $("#{{ $costFactor->keyword }}");
			@if($costFactor->operation)
			if(elem.attr('type') == 'checkbox'){
				if(elem.prop('checked')){
					cost += cost {{ $costFactor->operation }} ({{ $costFactor->leverage }} / 100);
				}
			}else{
				if(elem.val() != ''){
					cost += cost {{ $costFactor->operation }} ({{ $costFactor->leverage }} / 100);
				}
			}
			@elseif($costFactor->advancedOperation)
			if(elem.attr('type') == 'checkbox') {
				if (elem.prop('checked')) {
					cost += {{ str_replace(['cost', 'leverage'], ['cost', $costFactor->leverage], $costFactor->advancedOperation) }};
				}
			}else{
				if(elem.val() != ''){
					cost += {{ str_replace(['cost', 'leverage'], ['cost', $costFactor->leverage], $costFactor->advancedOperation) }};
				}
			}
			@endif
			@endforeach
			@endif
			// ------------------------------

			// days -------------------------
			$days = getDaysDiffShowCost();
			// console.log(cost);
			// console.log($days);
			if($("#chargeType").val() == 2){
				if(!isNaN($days)){
					$("#costEstimType").html('{{ trans('general.ad_form_ad_cost_per_ad_lifetime') }}');
					cost = $days * cost;
					$("#budget").val(cost.toFixed({{ $settings['costPerDecimals'] }}));
				}else{
					$("#costEstimType").html('{{ trans('general.ad_form_ad_cost_per_day') }}');
				}
				$("#budget").prop('disabled', true);
			}else{
				$("#budget").prop('disabled', false);
			}
			// console.log(cost);
			//-------------------------------

			$("#costEstimValue").html(cost.toFixed({{ $settings['costPerDecimals'] }}));
			showEstimateLoaderOrContents(false);
		}

		@if($costFactors)
		@foreach($costFactors as $costFactor)
		$("#{{ $costFactor->keyword }}").change(function() { showEstimateValue(); });
		$("#{{ $costFactor->keyword }}").keyup(function() { showEstimateValue(); });
		@endforeach
		@endif

		function showEstimateLoaderOrContents($isInLoad){
			if($isInLoad){
				$("#estimateLoader").show();
				$("#estimateContents").hide();
			}else{
				$("#estimateLoader").hide();
				$("#estimateContents").show();
			}
		}

		function toggleBlock($activator, $target){
			if($($activator).prop( "checked" )){
				$($target).show();
			}else{
				$($target).hide();
			}
		}

		showDateChooser();
		showEstimateType();
		showEstimateValue();
		showBudgetField();
		toggleBlock("#geoTurn", "#geoTargeting");
		toggleBlock("#continentTurn", "#continentsContainer");
		toggleBlock("#countriesTurn1", "#countriesContainer1");
		toggleBlock("#countriesTurn2", "#countriesContainer2");


		function parseDate(str) {
			var hi = [];
			var mdy = str.split('-');
			if(mdy[3] !== undefined){
				var hi = mdy[3].split(':');
			}else{
				hi[0] = null;
				hi[1] = null;
			}
			return new Date(mdy[2], mdy[1]-1, mdy[0], hi[0], hi[1]);
		}

		function daydiff($start, $end) {
			$fullStartDate = parseDate($start);
			$fullEndDate = parseDate($end);
			$millisecondsPerDay = 1000 * 60 * 60 * 24;
			$millisBetween  = $fullEndDate.getTime() - $fullStartDate.getTime();
			$days = $millisBetween / $millisecondsPerDay;
			return $days.toFixed({{ $settings['costPerDecimals'] }});
		}
	</script>

	<script>
		// adKeywords --------------------
		$('#adKeywords').materialtags({
			allowDuplicates: false,
			maxTags: 10,
			onTagExists: function(item, tag){
				Materialize.toast($('<span>{{ trans('general.ad_form_ad_keyword_exist') }}</span>'), 10000);
			}
		});
		$('#adKeywords').on('maxItems', function(event) {
			Materialize.toast($('<span>{{ trans('general.ad_form_ad_maw_items_reached') }}</span>'), 10000);
		});
		@if(old('adKeywords'))
		@foreach(explode(',', old('adKeywords')) as $v)
		$('#adKeywords').materialtags('add', '{{ $v }}', {preventPost: true});
		@endforeach
		@endif


		var countries = new Bloodhound({datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: {
				url: '{{ route("ajax.ads.data", ["name" => "countries"]) }}',
				cache: true,
			}
		});
		countries.initialize();

		$('#inc_countries').materialtags({
			allowDuplicates: false,
			itemValue: 'value',
			itemText: 'text',
			maxTags: 10,
			onTagExists: function(item, tag){
				Materialize.toast($('<span>{{ trans('general.ad_form_ad_country_exist') }}</span>'), 10000);
			},
			typeaheadjs: [{
				autoselect   : true,
				highlight   : true,
			},{
				name: 'countries',
				displayKey: 'text',
				source: countries.ttAdapter()
			}]
		});

		$('#exc_countries').materialtags({
			allowDuplicates: false,
			itemValue: 'value',
			itemText: 'text',
			maxTags: 10,
			onTagExists: function(item, tag){
				Materialize.toast($('<span>{{ trans('general.ad_form_ad_country_exist') }}</span>'), 10000);
			},
			typeaheadjs: [{
				autoselect   : true,
				highlight   : true,
			},{
				name: 'countries',
				displayKey: 'text',
				source: countries.ttAdapter()
			}]
		});

		$('#inc_countries').on('beforeItemAdd', function(event) {
			if($('#exc_countries').val().indexOf(event.item.value) >= 0){
				Materialize.toast($('<span>The country '+ event.item.text +' removed from excluded countries.</span>'), 10000);
				$('#exc_countries').materialtags('remove', event.item, {preventPost: true});
			}
		});
		$('#exc_countries').on('beforeItemAdd', function(event) {
			if($('#inc_countries').val().indexOf(event.item.value) >= 0){
				Materialize.toast($('<span>The country '+ event.item.text +' removed from from included countries.</span>'), 10000);
				$('#inc_countries').materialtags('remove', event.item, {preventPost: true});
			}
		});

		@if(old('inc_countries'))
		@foreach(explode(',', old('inc_countries')) as $k)
		$('#inc_countries').materialtags('add', { value: '{{ $k }}', text: '{{ config('locales.'.$k) }}' }, {preventPost: true});
		@endforeach
		@endif
		@if(old('exc_countries'))
		@foreach(explode(',', old('exc_countries')) as $k)
		$('#exc_countries').materialtags('add', { value: '{{ $k }}', text: '{{ config('locales.'.$k) }}' }, {preventPost: true});
		@endforeach
		@endif

		// continents -------------------
		var continents = new Bloodhound({datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: {
				url: '{{ route("ajax.ads.data", ["name" => "continents"]) }}',
				cache: true,
			}
		});
		continents.initialize();

		$('#continents').materialtags({
			allowDuplicates: false,
			itemValue: 'value',
			itemText: 'text',
			maxTags: 10,
			onTagExists: function(item, tag){
				Materialize.toast($('<span>{{ trans('general.ad_form_ad_continent_exist') }}</span>'), 10000);
			},
			typeaheadjs: [{
				autoselect   : true,
				highlight   : true,
			},{
				name: 'continents',
				displayKey: 'text',
				source: continents.ttAdapter()
			}]
		});
		@if(old('continents'))
		@foreach(explode(',', old('continents')) as $k)
		$('#continents').materialtags('add', { value: '{{ $k }}', text: '{{ $k }}' }, {preventPost: true});
		@endforeach
		@endif

		// -------------------------------

		// languages -------------------
		var languages = new Bloodhound({datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: {
				url: '{{ route("ajax.ads.data", ["name" => "languages"]) }}',
				cache: true,
			}
		});
		languages.initialize();

		$('#languages').materialtags({
			allowDuplicates: false,
			itemValue: 'value',
			itemText: 'text',
			maxTags: 10,
			onTagExists: function(item, tag){
				Materialize.toast($('<span>{{ trans('general.ad_form_ad_language_exist') }}</span>'), 10000);
			},
			typeaheadjs: [{
				autoselect   : true,
				highlight   : true,
			},{
				name: 'languages',
				displayKey: 'text',
				source: languages.ttAdapter()
			}]
		});
		@if(old('languages'))
		@foreach(explode(',', old('languages')) as $k)
		$('#languages').materialtags('add', { value: '{{ $k }}', text: '{{ $k }}' }, {preventPost: true});
		@endforeach
		@endif
		// -------------------------------

		// intersts --------------------
		$('#interests').materialtags({
			allowDuplicates: false,
			maxTags: 10,
			onTagExists: function(item, tag){
				Materialize.toast($('<span>{{ trans('general.ad_form_ad_interst_exist') }}</span>'), 10000);
			}
		});
		@if(old('interests'))
		@foreach(explode(',', old('interests')) as $k)
		$('#interests').materialtags('add', { value: '{{ $k }}', text: '{{ config('locales.'.$k) }}' }, {preventPost: true});
		@endforeach
		@endif
	</script>
@endsection
