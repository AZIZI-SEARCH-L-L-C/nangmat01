<!DOCTYPE html>
  <html dir="ltr">
    
	@include('inc.head')

    <body data-base="{{ url('/') }}">
	
<div class="page">

    @include('inc.nav')


<div class="front-paper">
<div class="raw">
@if($logoType == 1)
	<img style="position: relative;z-index: 200;" class="responsive-img home-logo" width="544" height="184" src="{{ $logo }}">
@else
	<h1>{{ $logo }}</h1>
@endif
	<p>{{ trans('general.sub_title') }}</p>


<form action="{{ URL::action($action) }}" method="get" class="search-form" id="search-form">
	      <div class="search-wrapper card">
            <input id="search" class="search" autocomplete="off" name="q" placeholder="{{ trans('general.type_keyword') }}" required>
			@if($settings['speachInput']) <i id="speach-btn" class="jaafar jaafar-24px voice">mic_none</i> @endif
			<button type="submit"><i class="jaafar jaafar-24px">search</i></button>
          </div>
</form>
  <a class="front-text">{{ trans('general.sub_title2') }}</a>
</div>
</div>

<div class="row home-cool" id="topKeywords">
   <div class="container" id="topKeywordsContainer">
	    <h3>{{ trans('general.top_keywords') }}</h3>
   </div>
</div>

<div class="container">
    <div class="section">
      @if(isset($ad_blocks['ad_hometop_reserved1'])) {!! $ad_blocks['ad_hometop_reserved1'] !!} @endif
      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">flash_on</i></h2>
            <h5 class="center">{{ trans('general.fast') }}</h5>

            <p class="light">{{ trans('general.fast_block') }}</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">link</i></h2>
            <h5 class="center">{{ trans('general.relevant') }}</h5>

            <p class="light">{{ trans('general.relevant_block') }}</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">web</i></h2>
            <h5 class="center">{{ trans('general.design') }}</h5>

            <p class="light">{{ trans('general.design_block') }}</p>
          </div>
        </div>
      </div>

    </div>
    <br><br>

    <div class="section">

    </div>
  </div>

<div class="row blocks">
    <div class="container center-align">
        @if(isset($ad_blocks['ad_homebottom_reserved2'])) {!! $ad_blocks['ad_homebottom_reserved2'] !!} @endif
	</div>
</div>

<script>
     var keywordsSuggestion = {{ $settings['keywordsSuggestion'] }};
	 var resultsPage = false;
</script>

        @include('inc.footer')
	  
</div>
<script>
    $.getJSON("{{ action('GeneralController@getTopWords') }}", {}, function( data ) {
		console.log(data);
		if(jQuery.isEmptyObject(data)){
			$("#topKeywords").hide();
		}else{
		  $.each( data, function( key , val ) {
			   $("#topKeywordsContainer").append( '<a href="{{ action($controller.'@search', [ 'q' => '' ]) }}'+ key +'"><div class="chip">'+ key +'</div></a>' );
		  });
		}
	});
</script>
</body>
</html>