<footer class="page-footer">
	<div class="container">
	  <div class="footer-copyright">
	  {{ trans('general.copyright') }} © 2013 - {{ date('Y') }}. {{ $settings['siteName'] }}. {{ trans('general.rights') }}. 
		<div class="right">
		<a href="{{ URL::action('GeneralController@Advertise') }}">{{ trans('general.adver_with_us') }}</a> |
		<a href="{{ route('submit.site') }}">{{ trans('general.submit_your_site') }}</a>
		</div>
	  </div>
	</div>
</footer>
		
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!--script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script-->
<script type="text/javascript">
function getBase(e) {
    return $("body").attr("data-base") + "/" + e
}

@if($settings['keywordsSuggestion'])
	window.acpObj	 = {
		acp_searchbox_id: "search",						
		acp_search_form_id: "search-form",
		acp_suggestions: "10",
		acp_showOnDocumentClick: "off",
		acp_sig_html: "{{ trans('general.powered_by') }} <a href='#'>{{ $settings['siteName'] }}</a>",
		acp_api: "{{ action('autoCompleteController@auto') }}" 
	};		
@endif

@if(Auth::check())
	@if(Auth::user()->getSearchReference('collectData'))
		if(resultsPage){$.getJSON( "{{ action('GeneralController@registerQuery') }}", { q : '{{ $query }}' }, function( data ) {});}
	@endif
@else
	@if(Session::has('collectData'))
		@if(Session::get('collectData'))
			if(resultsPage){$.getJSON( "{{ action('GeneralController@registerQuery') }}", { q : '{{ $query }}' }, function( data ) {});}
		@endif
	@else
		@if($settings['collectData'])
			if(resultsPage){$.getJSON( "{{ action('GeneralController@registerQuery') }}", { q : '{{ $query }}' }, function( data ) {});}
		@endif
	@endif
@endif

</script>
<script type="text/javascript" src="{{ URL::asset('assets/templates/' . Config::get('app.template') . '/js/functions.js') }}"></script>
<style type="text/css">
	.acp_ltr { margin-left: 0px; margin-top: -2px; width: 100%; text-shadow: none; border:2px #eaeaea solid}	/* width of the suggestion table	*/
	.acp_ltr tfoot {float: right;}
	#suggestions {width: 100%; display: inline-table;}
	.acp_ltr tbody td	{ width:100%;	padding-left:7px; padding-bottom:5px; padding-top:5px}			/* width of a suggestion line		*/
</style>