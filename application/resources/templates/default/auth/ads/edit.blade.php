@extends('pageLayout')

@section('title', trans('general.edit').' '.$ad->name.' - '.$compain->name.' - ')

@section('content')
<div class="row form_page">
    <div class="row">
		<div class="container">
			<div class="col s12">
				<form action="{{ route('ads.compains.ad.edit.post', ['compainId' => $compain->id, 'slug' => $ad->slug]) }}" method="post">
					<div class="row">
						<div class="col s12 bottommargin">
							<a href="{{ route('ads.compains.ads', ['id' => $compain->id]) }}" class="waves-effect btn_form_page modal-trigger"><i class="material-icons tiny">navigate_before</i> {{ trans('general.back') }}</a>
						</div>
						<div class="block">
							<div class="col m8 s12">
								<p class="block-title">{{ $compain->name }}: {{ trans('general.edit') }} {{ $ad->name }}</p>
								<div class="card">
									<div class="card-content">
										@if ($errors->any())
											@foreach ($errors->all() as $error)
												<div class="card-panel red lighten-2">{{ $error }}</div>
											@endforeach
										@endif
										@if(Session::has('message'))
											<div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
										@endif
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.ad_unit_name') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<input name="adUnitName" type="text" value="{{ $ad->name }}" id="adUnitName" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col m8 s12">
								<div class="card">
									<div class="card-content">
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.ad_form_title') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<input name="adTitle" type="text" value="{{ $ad->title }}" id="adTitle" />
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p for="adDescription">{{ trans('general.ad_form_desc') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<textarea id="adDescription" name="adDescription" class="textarea" rows="5">{{ $ad->description }}</textarea>
												<span class="charNum"><span id="charNum"></span>/255</span>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.ad_form_vurl') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<input name="adVurl" type="text" value="{{ $ad->Vurl }}" id="adVurl" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col m4 s12">
								<span class="">{{ trans('general.ad_form_ad_example_title') }}:</span>
								<div class="card">
									<div class="card-content">
										<a target="_blank" href="{{ $ad->url }}">
											<span class="result-title" style="line-height:18px;" id="showAdTitle">{{ $ad->title }}</span>
										</a>
										<p class="green-text"><span class="ad badge">Ad</span><span id="showAdVurl">{{ $ad->Vurl }}</span></p>
										<p id="showAdDescription">{{ $ad->description }}</p>
									</div>
								</div>
							</div>
							<div class="col m8 s12">
								<div class="card">
									<div class="card-content">
										<div class="row">
											<div class="col m3 s12 input-field">
												<p for="adKeywords">{{ trans('general.ad_form_keywords') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<textarea id="adKeywords" name="adKeywords" class="textarea" rows="5">{{ $ad->keywords }}</textarea>
											</div>
										</div>
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.ad_form_url') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<input name="adURL" type="text" value="{{ $ad->url }}" id="adURL" />
											</div>
										</div>
										<div class="row center"><button name="submitEditAd" value="Update" type="submit" class="waves-effect btn modal-trigger"/>
											{{ trans('general.ad_form_ad_update') }}</button></div>
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
<script>
var $maxLength = 255;
$("#adTitle").keyup(function(){
    $("#showAdTitle").html($(this).val());
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
});
$("#adVurl").keyup(function(){
    $("#showAdVurl").html($(this).val());
});
$('#charNum').text($maxLength - $("#adDescription").val().length);
</script>
@endsection

