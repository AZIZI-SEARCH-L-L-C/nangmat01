<!DOCTYPE html>
  <html>

@include('inc.head')

<style>
.left-side .collection{
	margin-top:0;
}
.left-side .collection a{
	margin: 0 !important;
    border-bottom: 0;
	color: #000;
	border-bottom: 1px solid #d9d9d9;
}
.left-side .collection a.active{
	background-color: #ddd;
	color: #000;
}
</style>

<body data-base="{{ url('/') }}">

<div class="page grey lighten-3">

@include('inc.nav')

@if($settings['front-paper'])
	<div class="row">	
		<div class="front-paper">
			<div class="raw">
			<!--	<img class="responsive-img home-logo" width="544" height="184" src="images/logo.png">-->
				<form action="{{ URL::action($action) }}" method="get" class="search-form" id="search-form">
					<div class="search-wrapper card">
						<input id="search" class="search" autocomplete="off" name="q" autofocus placeholder="{{ trans('general.type_keyword') }}" onfocus="this.value = this.value;" value="{{ $query }}" required>
						<ul id="suggetions" class="suggetions collection"></ul>
						<i id="speach-btn" class="voice jaafar jaafar-24px">mic_none</i>
						<button type="submit"><i class="jaafar jaafar-24px">search</i></button>
					</div>
				</form>
			</div>
		</div>	

		<div class="row hide-on-med-and-down">
			<ul id="links" class="tabs-menu">
				@foreach(array_slice($engines, 0, 10) as $Cengine)
					<li class="tab"><a @if($boldActMenu && $Cengine['name'] == $engine) class="active" @endif href="{{ URL::action($Cengine['controller'].'@search', ['q' => $query]) }}">{{ $Cengine['name'] }}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
	<div class="" style="margin-top: 50px;">
		@yield('content')
	</div>
<script>
    var relatedKeywords = {{ $settings['relatedKeywords'] }};
    var keywordsSuggestion = {{ $settings['keywordsSuggestion'] }};
	var realTimeSearch = false;
	var resultsPage = false;
</script>
		@include('inc.footer')
</div>

@yield('javascript')
<script>
// $('.modal-trigger').leanModal();
$(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});
</script>

    </body>
  </html>