<p>{!! trans('general.your_query_didnt_match', ['query' => $query]) !!}</p><br/>
<p>{{ trans('general.didnt_match_suggestions') }}:</p>
<ol style="list-style-type: disc;padding: 0 40px;">
	<li>{{ trans('general.didnt_match_suggestion1') }}</li>
	<li>{{ trans('general.didnt_match_suggestion2') }}</li>
	<li>{{ trans('general.didnt_match_suggestion3') }}</li>
</ol>