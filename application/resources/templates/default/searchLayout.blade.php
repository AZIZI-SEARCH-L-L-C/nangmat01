<!DOCTYPE html>
  <html>
    @section('title', $query . ' - ')
	@include('inc.head')
	
    <body data-base="{{ url('/') }}">
<div class="page"> <!-- class grey lighten-3 -->

@include('inc.nav')


<div class="row">	

<div class="front-paper">
<div class="raw">
<form action="{{ URL::action($action) }}" method="get" class="search-form" id="search-form">
	<div class="search-wrapper card">
		<input id="search" class="search" name="q" autofocus onfocus="this.value = this.value;" placeholder="{{ trans('general.type_keyword') }}" value="{{ $query }}" required>
		@if($settings['keepFilters'])
			@foreach(array_except($urlParams, ['q', 'p']) as $Cname => $Cvalue)
				<input type="hidden" name="{{ $Cname }}" value="{{ $Cvalue }}">
			@endforeach
		@endif
		@if($settings['speachInput']) <i id="speach-btn" class="voice jaafar jaafar-24px">mic_none</i> @endif
		<button type="submit"><i class="jaafar jaafar-24px">search</i></button>
	</div>
</form>
</div>
</div>	

<div class="row hide-on-med-and-down nobottommargin">
      <ul id="links" class="tabs-menu">
	  @foreach(array_slice($engines, 0, 10) as $Cengine)
		  <li class="tab"><a @if($Cengine['slug'] == $engine) class="active" @endif href="{{ URL::action($Cengine['controller'].'@search', ['q' => $query]) }}">{{ $Cengine['name'] }}</a></li>
      @endforeach
      </ul>
</div>
</div>


<div class="row">	
		<div class="container">
		    @yield('filters')
			<div id="content" class="col l9 s12">
				@yield('widgets')
				<div class="card" style="margin-top:0;">
					<div class="card-content">
						@if(isset($ad_blocks['ad_resultstop_reserved3'])) {!! $ad_blocks['ad_resultstop_reserved3'] !!} @endif
							@yield('content')
						@if(isset($ad_blocks['ad_resultsbottom_reserved4'])) {!! $ad_blocks['ad_resultsbottom_reserved4'] !!} @endif
					</div>
				</div>
			</div>
			
			<div id="rightPanels" class="col l3 s12">
				@hook('wikiAAAinfoContainer')

				@yield('rightSide')
			
				<div class="card ads" id="ads" style="display:none;margin-top:0;">
					<a class="advertise" href="{{ URL::action('GeneralController@Advertise') }}"><span class="badge"><span>{{ trans('general.your_ad_here') }}</span> <i class="jaafar">error_outline</i></span></a>
					<div id="ad-item"></div>
				</div>
			
{{--				 @if(!empty($advertisements))--}}
{{--				 <div class="card ads" id="ids"  style="margin-top:0;">--}}
{{--					<a class="advertise" href="{{ URL::action('GeneralController@Advertise') }}"><span class="badge"><span>{{ trans('general.your_ad_here') }}</span> <i class="jaafar">error_outline</i></span></a>--}}
{{--					@foreach($advertisements as $advertisement)--}}
{{--					<div class="card-content">--}}
{{--						<a href="{{ $advertisement['url'] }}"><span class="result-title" style="line-height:18px;">{{ $advertisement['title'] }}</span></a>--}}
{{--						<p class="green-text"><span class="ad badge">{{ trans('general.ad') }}</span> {{ $advertisement['Vurl'] }}</p>--}}
{{--						<p>{{ $advertisement['description'] }}</p>--}}
{{--					</div>--}}
{{--					@endforeach--}}
{{--				  </div>--}}
{{--				 @endif--}}

{{--				@if(!empty($suggestions))--}}
					<div class="collection related" id="related" style="margin-top:0;">
						<a class="collection-item head black-text">{{ trans('general.related_keywords') }}</a>
{{--						@foreach($suggestions as $suggestion)--}}
{{--							<a href="{{ action($action, ['q' => $suggestion['text']]) }}" class="collection-item">{!! boldQueryWords($query, $suggestion['text']) !!}</a>--}}
{{--						@endforeach--}}
					</div>
{{--				@endif--}}

				@if(isset($ad_blocks['ad_resultsright_reserved5'])) {!! $ad_blocks['ad_resultsright_reserved5'] !!} @endif
			  
			</div> 
		</div>
</div>
		
<script>
     var relatedKeywords = {{ $settings['relatedKeywords'] }};
     var keywordsSuggestion = {{ $settings['keywordsSuggestion'] }};
	 var resultsPage = true;
</script>		
	@include('inc.footer')
</div>
<script>	 
if(relatedKeywords){
$.getJSON( "{{ action('autoCompleteController@suggetions') }}", { q : '{{ $query }}' }, function( data ) {
	if(jQuery.isEmptyObject(data)){
		$("#related").hide();
		@if(empty($advertisements))
			$("#content").removeClass( "l9" ).addClass( "l12" );
			$("#filters").removeClass( "l9" ).addClass( "l12" );
		@endif
	}else{
      $.each( data, function( key , val ) {
		  $("#related").append( '<a href="{{ url('/') }}/{{ $engine }}/search?q=' + val.replace(/(<([^>]+)>)/ig,"").replace(/\s/g,"+") + '" class="collection-item">' + val + '</a>' );
      });
	}
});
}else{
	$("#related").hide();
	@if(empty($advertisements))
		$("#content").removeClass( "l9" ).addClass( "l12" );
		$("#filters").removeClass( "l9" ).addClass( "l12" );
	@endif
}

$.getJSON( "{{ route('ad.ajax') }}", { q : '{{ $query }}', t : '{{ $engine }}' }, function( data ) {
	if(jQuery.isEmptyObject(data)){
		$("#ads").hide();
		// $("#content").removeClass( "l9" ).addClass( "l12" );
		// $("#filters").removeClass( "l9" ).addClass( "l12" );
	}else{
	  $("#ads").show();
      $.each( data, function( key , val ) {
		   $("#ad-item").append( '<div class="card-content"><a target="_blank" href="'+ val.click +'"><span class="result-title" style="line-height:18px;">'+ val.title +'</span></a><p class="green-text"><span class="ad badge">{{ trans("general.ad") }}</span>'+ val.Vurl +'</p><p>'+ val.description+'</p></div>' );
      });
	}
});
// }else{
	// $("#ads").hide();
	// $("#content").removeClass( "l9" ).addClass( "l12" ); 
	// $("#filters").removeClass( "l9" ).addClass( "l12" ); 
// }

@hook('wikiAAAinfoScript')
</script>

@yield('javascript')
	</body>
  </html>