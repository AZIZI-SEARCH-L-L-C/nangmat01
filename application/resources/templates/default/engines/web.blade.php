@extends('searchLayout')

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/default.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/component.css') }}" />
	<script src="{{ URL::asset('assets/js/modernizr.custom.js') }}"></script>
	<style>
		.widget{
			margin-bottom: 0 !important;
		}
		.widget .title{
			color:#0000cc;
			font-size:20px;
		}
		.spelling{
			padding: 4px 0;
			font-family: 'Roboto',arial,sans-serif;
			font-size: 20px;
		}
		.spelling a{
			color:#0000cc;
		}
		.entities{
			display: flex;
			flex-wrap: wrap;
		}
		.entity{
			flex: 1;
			display: flex;
		}
		.entity img{
			float:left;
			margin:0 15px 20px 0;
			width:120px;
			height:120px;
		}
		.entity .title h3{
			margin-top: 0;
			margin-bottom:0;
			font-size:25px;
		}
		.entity a{
			color:#0000cc;
		}
		.entity .card{
			margin-top: 0;
		}
		.result-container .title a.mark-as-bookmark{
			color: #ffa500 !important;
		}
		.result-container .title a.mark-as-bookmark i{
			font-size: 18px !important;
		}
	</style>
@endsection

@section('content')
	@if(!empty($results))
		@if(Auth::check()) @if(Auth::user()->isAdmin())
			@if($lastOneEdit)
				<span class="results-info" style="color: red;">{{ trans('general.adjusted_by', ['name' => $lastOneEdit->username]) }}</span><br>
			@endif
		@endif @endif
		@if($totalResults && $settings['resultsInfo'])<span class="results-info">{{ trans('general.about_results', ['total' => $totalResults, 'time' => $renderTime]) }}</span>@endif
		@if($spelling)<p class="spelling">{{ trans('general.did_you_mean') }}: <a href="{{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['q' => $spelling['correctedQuery']])) }}">{{ $spelling['correctedQuery'] }}</a> ?</p>@endif
		<?php $i = 1; ?>
		@foreach($results as $result)
			@if(\AziziSearchEngineStarter\Engines::where('name', 'images')->first()->turn && $settings['imagesAllturn'] && $counter == $settings['imagesPosition'] && $page == 1 && !empty($images))
				<div class="result-container imgs">
					<div class="title">
					<!--a target="{{ $settings['resultsTarget'] }}" href="{{ URL::action('ImagesController@search', ['q' => $query]) }}">Images of {{ $query }}</a-->
						{{ trans('general.images_of') }} {{ $query }}
					</div>
					<div class="disurl">{{ action('GeneralController@indexType', ['type' => 'images']) }}</div>
					<ul id="og-grid" class="og-grid">
						@foreach($images as $image)
							<li>
								<a target="{{ $settings['resultsTarget'] }}" href="{{ $image['url'] }}" data-image="{{ $image['thumbnailLink'] }}" data-largesrc="{{ $image['src'] }}" data-title="{{ $image['title'] }}" data-description="{{ trans('general.img_type') }}: {{ $image['mime'] }} ; {{ trans('general.img_width') }}: {{ $image['width'] }} ; {{ trans('general.img_height') }}: {{ $image['height'] }} ; {{ trans('general.img_size') }}: {{ $image['size'] }} <br>{{ $image['displayLink'] }}">
									<img class="img-prev" src="{{ $image['thumbnailLink'] }}" alt="{{ $image['title'] }}"/>
								</a>
							</li>
						@endforeach
					</ul>
					<div class="img-under"><a href="{{ URL::action('ImagesController@search', ['q' => $query]) }}"><i class="jaafar">arrow_forward</i> {{ trans('general.see_imgs_of') }} {{ $query }}</a></div>
				</div>
			@endif
			@if(\AziziSearchEngineStarter\Engines::where('name', 'videos')->first()->turn && $settings['videosAllturn'] && $counter == $settings['videosPosition'] && $page == 1 && !empty($videos))
				<!--div class="card"><div class="card-content"-->
				<div class="result-container news videos" style="display:block;">
					<div class="title">
					<!--a target="{{ $settings['resultsTarget'] }}" href="{{ URL::action('VideosController@search', ['q' => $query]) }}">Videos of {{ $query }}</a-->
						{{ trans('general.see_videos_of') }} {{ $query }}
					</div>
					<div class="disurl">{{ action('GeneralController@indexType', ['type' => 'videos']) }}</div>
					<div class="row">
						@foreach($videos as $video)
							<div class="col s12 m6 l4 story">
								<div class="card">
									<div class="card-image">
										<img style="height:115px;" src="{{ $video['thumbnailLink'] }}">
										<span class="duration"><i class="material-icons tiny">play_arrow</i> @if(isset($video['duration'])){{ $video['duration'] }} @endif</span>
									</div>
									<div class="card-stacked">
										<div class="card-content">
											<a href="{{ $video['url'] }}">{{ $video['title'] }}</a>
											<div class="disurl">
												{{ $video['publisher'] }}
												<span style="color: #808080;">
												@if(isset($video['views']))
														- {{ $video['views'] }}+ {{ trans('general.views') }}
													@endif
													@if(isset($video['date']))
														<br/>{{ $video['date'] }}
													@endif
											</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="img-under"><a href="{{ URL::action('VideosController@search', ['q' => $query]) }}"><i class="jaafar">arrow_forward</i> {{ trans('general.see_more_videos') }} {{ $query }}</a></div>
				</div>
				<!--/div></div-->
			@endif
			@if(\AziziSearchEngineStarter\Engines::where('name', 'news')->first()->turn && $settings['newsAllturn'] && $counter == $settings['newsPosition'] && $page == 1 && !empty($news))
				<div class="result-container news">
					<div class="title">
					<!--a target="{{ $settings['resultsTarget'] }}" href="{{ URL::action('NewsController@search', ['q' => $query]) }}">Top stories</a-->
						{{ trans('general.top_stories') }}
					</div>
					<div class="disurl">{{ action('GeneralController@indexType', ['type' => 'news']) }}</div>
					<div class="row">
						@foreach($news as $story)
							<div class="col s12 m6 l4 story">
								<div class="card">
									@if($story['thumbnail'])
										<div class="card-image">
											<img style="height:115px;" src="{{ $story['thumbnail'] }}">
										</div>
									@endif
									<div class="card-stacked">
										<div class="card-content">
											<a href="{{ $story['url'] }}">{{ $story['title'] }}</a>
											<div class="disurl">{{ $story['provider'] }} - <span style="color: #808080;">
										@if($settings['newsDateFormat'] == 1)
														{{ get_readable_time($story['datePublished'], $settings['newsDateFormatform']) }}
													@elseif($settings['newsDateFormat'] == 2)
														{{ get_time_ago($story['datePublished'], $settings['newsDateFull']) }}
													@endif
									  </span>
											</div>
											@if(!$story['thumbnail'])
												<p>{{ str_limit($story['description'], 100) }}</p>
											@endif
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="img-under"><a href="{{ URL::action('NewsController@search', ['q' => $query]) }}"><i class="jaafar">arrow_forward</i> {{ trans('general.more_stories_for') }} {{ $query }}</a></div>
				</div>
			@endif
			<div class="result-container">
			<!--  - {{ $result['source'] }} {{ $result['order'] }} ({{ $result['score'] }}) -->
				<div class="title">
					<a target="{{ $settings['resultsTarget'] }}" href="{{ $result['url'] }}">{!! boldQueryWords($query, $result['title']) !!}</a>
					@if($settings['enable_bookmarks'])
						<a class="mark-as-bookmark" href="#" data-url="{{ $result['url'] }}" data-title="{{ $result['title'] }}" data-description="{{ $result['description'] }}"><i class="material-icons">star_border</i></a>
					@endif
					@if(Auth::check()) @if(Auth::user()->isAdmin())
						- <a class="modal-trigger" href="#editRankModal" onclick="fillEditRankModal(this);" data-rank="{{ $i }}" data-title="{{ $result['title'] }}" data-description="{{ $result['description'] }}" data-vurl="{{ $result['displayLink'] }}" data-url="{{ $result['url'] }}" data-source="{{ $result['source'] }}"><i class="material-icons">edit</i></a>
					@endif @endif
				</div>
				<?php $i++; ?>
				<div class="disurl">{!! boldQueryWords($query, $result['displayLink']) !!} @if($settings['enable_comments']) - <a class="comment-link" href="#" data-url="{{ $result['url'] }}">{{ trans('general.comments') }} (<span class="comments-count" data-url="{{ $result['url'] }}">0</span>)</a> @endif</div>
				<div class="desc" style="color:#666;">{!! boldQueryWords($query, $result['description']) !!}</div>
				<div class="deepLinks">
					<?php $i1 = 0; ?>
					@if(!empty($result['deepLinks']))
						@foreach($result['deepLinks'] as $deepLink)
							<a target="{{ $settings['resultsTarget'] }}" href="{{ getUncryptedUrl($deepLink['url']) }}">{{ $deepLink['name'] }}</a>
							@if(++$i1 != count($result['deepLinks'])) <i class="material-icons">filter_tilt_shift</i> @endif
						@endforeach
					@endif
				</div>
				{{--<div class="desc"><a class="comment-link" href="#" data-url="{{ $result['url'] }}">Comments (<span class="comments-count" data-url="{{ $result['url'] }}">0</span>)</a></div>--}}
			</div>
			<?php $counter++; ?>
		@endforeach

		<div class="row">
			@if($settings['webPagination'] == 1)
				<ul class="pagination center">
					<li class="@if($page == 1) disabled @endif left"><a href="@if($page == 1) # @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page - 1])) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li><li class="disabled center"><a href="#">{{ $page }}</a></li>
					<li class="waves-effect @if($lastPage == true) disabled @endif right"><a href="@if($lastPage == true) @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page + 1])) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
				</ul>
			@elseif($settings['webPagination'] == 2)
				{{--<ul class="pagination center">--}}
				{{--<li class="@if($page == 1) disabled @endif"><a href="@if($page == 1) # @else {{ URL::action('WebController@search', ['q' => $query, 'p' => $page - 1]) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li>--}}
				{{--@for ($i = 1; $i <= $pages; $i++)--}}
				{{--<li class="@if($page == $i) active @endif center"><a href="{{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $i])) }}">{{ $i }}</a></li>--}}
				{{--@endfor--}}
				{{--<li class="waves-effect @if($lastPage == true) disabled @endif"><a href="@if($lastPage == true) @else {{ URL::action('WebController@search', ['q' => $query, 'p' => $page + 1]) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>--}}
				{{--</ul>--}}
				{{ $paginated->appends(array_except($urlParams, ['p']))->links() }}
			@endif
		</div>

	@else
		@include('inc.noResults')
	@endif

	<!-- Modal Structure -->
	<div id="editRankModal" class="modal">
		<div class="modal-content">
			<h4>{{ trans('general.upadate_rank') }}</h4>
			<form action="{{ route('updaterank') }}" method="post">
				<div class="row">
					<div class="input-field col s12">
						<input id="page" name="page" type="number" value="{{ $page }}">
						<label for="page">{{ trans('general.page') }}</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="rank" name="rank" type="number" value="1">
						<input id="url" name="url" type="hidden">
						<input id="keyword" name="keyword" value="{{ $query }}" type="hidden">
						<input id="title" name="title" type="hidden">
						<input id="description" name="description" type="hidden">
						<input id="Vurl" name="Vurl" type="hidden">
						<label for="rank">{{ trans('general.rank_on_page') }}</label>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" id="updateRankButton" class="waves-effect waves-blue btn-flat">{{ trans('general.update') }}</a>
			<a href="#" class="modal-close waves-effect waves-blue btn-flat">{{ trans('general.close') }}</a>
		</div>
	</div>
	<!-- Modal Structure -->
	<div id="commentsModal" class="modal">
		<div class="modal-content">
			<h4>{{ trans('general.comment_to') }} <span id="comments-show-url"></span></h4>
			<div id="comments-block">
				<div class="center">
					<div class="preloader-wrapper big active">
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
			<form action="#" method="post">
				<div class="row">
					<div class="input-field col s12">
						<textarea id="comment-input" name="rank" class="materialize-textarea input-all" type="number"></textarea>
						<label for="comment-input">{{ trans('general.post_comment') }}</label>
						<a href="#" id="post-comment-btn" onclick="postComment(this);" data-reply="0" class="waves-effect waves-blue btn">{{ trans('general.post') }}</a>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="modal-close waves-effect waves-blue btn-flat">{{ trans('general.close') }}</a>
		</div>
	</div>
@endsection

@section('widgets')
	@if($settings['mathCalc'] && $mathCalc)
		<div class="row widget">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<h5>{{ $mathCalc['expression'] }} = {{ $mathCalc['value'] }}</h5>
					</div>
				</div>
			</div>
		</div>
	@endif

	@if($settings['timeZone'] && $timeZone)
		<div class="row widget">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<h3 style="margin-top: 0;margin-bottom:0;">{{ get_readable_time($timeZone['time'], 'H:i A') }}</h3>
						<p style="color:#808080">{{ get_readable_time($timeZone['time'], 'l, F d, Y') }} ({{ $timeZone['utcOffset'] }})</p>
						<p style="color:#808080">{{ trans('general.time_in') }} {{ $timeZone['location'] }}</p>
					</div>
				</div>
			</div>
		</div>
	@endif

	@if($settings['facts'] && $facts)
		<div class="row widget">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						@if(!empty($facts['value'][0]['description']))<p>{!! boldQueryWords($query, $facts['value'][0]['description']) !!}</p>@endif
						@if(!empty($facts['value'][0]['subjectName']))<a target="{{ $settings['resultsTarget'] }}" class="title" href="{{ getUncryptedUrl($facts['attributions'][0]['seeMoreUrl']) }}">{{ $facts['value'][0]['subjectName'] }}</a>@endif
						@if(!empty($facts['attributions'][0]['providerDisplayName']))<p style="color:#008000">{{ $facts['attributions'][0]['providerDisplayName'] }}</p>@endif
						@if(empty($facts['value'][0]['subjectName']))<a target="{{ $settings['resultsTarget'] }}" class="title" href="{{ getUncryptedUrl($facts['attributions'][0]['seeMoreUrl']) }}">{{ trans('general.read_more') }} >>></a>@endif
					</div>
				</div>
			</div>
		</div>
	@endif

	@if($settings['translations'] && $translations)
		<div class="row widget">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col m6 s12">
								<h3 style="margin-top: 0;margin-bottom:0;">{{ $translations['originalText'] }}</h3>
								<p>{{ config('allLanguages.'.$translations['inLanguage']. '.native') }}</p>
							</div>
							<div class="col m6 s12">
								<h3 style="margin-top: 0;margin-bottom:0;">{{ $translations['translatedText'] }}</h3>
								<p>{{ config('allLanguages.'.$translations['translatedLanguageName']. '.native') }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

	@if($settings['entities'] && $entities)
		<div class="row entities widget">
			@foreach($entities as $key => $entity)
				<?php if(!isset($entity['entityPresentationInfo']['entityTypeHint'])){ $entity['entityPresentationInfo']['entityTypeHint'] = 'Generic'; } ?>
				@if(in_array_array($entitiesAllowed, $entity['entityPresentationInfo']['entityTypeHint']))
					<div class="col entity">
						<div class="card">
							<div class="card-content">
								@if(!empty($entity['image']['hostPageUrl']))
									<img src="{{ $entity['image']['hostPageUrl'] }}" onerror="this.src='{{ $entity['image']['thumbnailUrl'] }}';"/>
								@elseif(!empty($entity['image']['thumbnailUrl']))
									<img src="{{ $entity['image']['thumbnailUrl'] }}"/>@endif
								@if(!empty($entity['url']))
									<a target="{{ $settings['resultsTarget'] }}" class="title" href="{{ getUncryptedUrl($entity['url']) }}">
										@endif
										<h3>{{ $entity['name'] }}</h3>
										@if(!empty($entity['url']))
									</a>
								@endif
								@if(!empty($entity['entityPresentationInfo']['entityTypeDisplayHint']))
									<p class="grey-text">{{ $entity['entityPresentationInfo']['entityTypeDisplayHint'] }}</p>
								@endif
								@if(isset($entity['contractualRules']))
									@foreach($entity['contractualRules'] as $contractualRules)
										@if($contractualRules['targetPropertyName'] && isset($contractualRules['url']) && ($contractualRules['targetPropertyName'] == 'description'))
											<a target="{{ $settings['resultsTarget'] }}" href="{{ $contractualRules['url'] }}">{{ $contractualRules['text'] }}</a>
										@endif
									@endforeach
								@endif
								@if(!empty($entity['description']))
									<p id="entity-description-{{ $key }}">{!! boldQueryWords($query, str_limit($entity['description'], $settings['entityTruncate'], '... <a class="seeMore" id="description-'. $key .'" target="'. $settings["resultsTarget"] .'" data-text="' . boldQueryWords($query, htmlentities($entity['description'])) . '" href="#">See more >>></a>')) !!}</p>
								@endif
								<p>
									@if(isset($entity['entityPresentationInfo']['entityTypeHints']))
										<?php $i2 = 0; ?>
										@foreach($entity['entityPresentationInfo']['entityTypeHints'] as $entityTypeHint)
											<span class="grey-text">{{ $entityTypeHint }} </span>
											@if(++$i2 != count($entity['entityPresentationInfo']['entityTypeHints'])) <i class="material-icons tiny">filter_tilt_shift</i> @endif
											<?php $i2++; ?>
										@endforeach
									@else
										{{ $entity['entityPresentationInfo']['entityTypeHint'] }}
									@endif
								</p>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		</div>
	@endif
@endsection

@section('filters')
	<div class="col l9 s12" id="filters">
		<div id="toolsCard" class="scale-transition @if(!$hasFilters) Ndsp @endif left">
			@if($settings['documentsFilter'])
				<a class='dropdown-button mt' href='#' data-activates='filetype' data-beloworigin='true' data-hover='false'>@if(in_array($fileType, $fileTypes)) {{ trans('general.only').': '.$fileType }} @else {{ trans('general.documents') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['dateFilter'])
				<a class='dropdown-button mt' href='#' data-activates='date' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($date, $datesK)) {{ $dates[$date] }} @else {{ trans('general.time') }} @endif<i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['countryFilter'])
				<a class='dropdown-button mt' href='#' data-activates='countries' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($region, $countries)) {{ trans('general.only').': '.array_get(config('locales'), $region) }} @else {{ trans('general.region') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif


			@if($settings['documentsFilter'])
				<ul id='filetype' class='dropdown-content dpFi'>
					<li>
						@if(!in_array($fileType, $fileTypes)) <i class="material-icons">check</i> @endif
						<a @if(!in_array($fileType, $fileTypes)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['f', 'p']))) }}">All</a>
					</li>
					@foreach($fileTypes as $CfileType)
						<li>
							@if($CfileType == $fileType) <i class="material-icons">check</i> @endif
							<a @if($CfileType == $fileType) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['f', 'p']), ['f' => $CfileType])) }}">{{ ucfirst($CfileType) }}</a>
						</li>
					@endforeach
				</ul>
			@endif


			@if($settings['countryFilter'])
				<ul id='countries' class='dropdown-content dpFi' style="min-width:150px;">
					<li>
						@if(!in_array($region, $countries)) <i class="material-icons">check</i> @endif
						<a @if(!in_array($region, $countries)) class="active" @endif href="{{ URL::action($action, array_except($urlParams, ['c', 'p'])) }}">{{ trans('general.any_region') }}</a>
					</li>

					@foreach($firstCountries as $fc)
						@if(in_array($fc, $countries))
							<li>
								@if($fc == $region) <i class="material-icons">check</i> @endif
								<a @if($fc == $region) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['c', 'p']), ['c' => $fc])) }}">{{ array_get(config('locales'), $fc) }}</a>
							</li>
						@endif
					@endforeach
					<li><a href="#countriesModal">{{ trans('general.more_regions') }}</a></li>
				</ul>
			@endif

			@if($settings['dateFilter'])
				<ul id='date' class='dropdown-content dpFi' style="min-width:150px;">
					<li>
						@if(!in_array($date, $datesK)) <i class="material-icons">check</i> @endif
						<a @if(!in_array($date, $datesK)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['d', 'p']))) }}">{{ trans('general.any_time') }}</a>
					</li>
					@foreach($dates as $dt => $dtV)
						<li>
							@if($dt == $date) <i class="material-icons">check</i> @endif
							<a @if($dt == $date) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['d', 'p']), ['d' => $dt])) }}">{{ $dtV }}</a>
						</li>
					@endforeach
				</ul>
			@endif

			@if($hasFilters)<a class="clearFilter" href="{{ URL::action($action, ['q' => $query]) }}">{{ trans('general.clear_filters') }}</a>@endif

		</div>
		@if( ($settings['documentsFilter'] or $settings['countryFilter'] or $settings['dateFilter']))
			<a id="tools" href="#" class="black-text @if($hasFilters) right @endif">
				<i id="leftArrow" class="material-icons tiny @if(!$hasFilters) Ndsp @endif">chevron_left</i> {{ trans('general.search_tools') }}
				<i id="rightArrow" class="material-icons tiny @if($hasFilters) Ndsp @endif">keyboard_arrow_right</i><br/></a>
		@endif
	</div>
	<div class="clear"></div>

	@if($settings['countryFilter'])
		<div id="countriesModal" class="modal modal-fixed-footer">
			<div class="modal-content">
				<p>{{ trans('general.find_pages_region') }}</p>
				@foreach($countries as $Ccode)
					<div class="col m6 s12">
						<img src="{{ url('assets/flags/'.strtolower($Ccode).'.png') }}"/> <a href="{{ URL::action($action, array_merge(array_except($urlParams, ['c', 'p']), ['c' => $Ccode])) }}">{{ array_get(config('locales'), $Ccode) }}</a><br/>
					</div>
				@endforeach
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('general.close') }}</a>
			</div>
		</div>
	@endif

@endsection

@section('rightSide')

@endsection

@section('javascript')
	<script src="{{ URL::asset('assets/js/grid.js') }}"></script>
	<script>
		$(function() {
			Grid.init();
		});
	</script>
	<script>
		if ($('#toolsCard').length && $('#tools').length) {
			$('#tools').click(function() {
				$('#toolsCard').toggleClass('Ndsp');
				$('#leftArrow').toggleClass('Ndsp');
				$('#rightArrow').toggleClass('Ndsp');
				$('#toolsCard').toggleClass('scale-in');
				$('#toolsCard').css({'-webkit-transform': 'inherit', 'transform' : 'inherit'});
				$('#tools').toggleClass('right');
				return false;
			});
		}

		$(document).ready(function(){
			$('.comments-count').each(function () {
				var $elm = $(this);
				$url = $elm.data('url');
				$.ajax({
					url: '{{ route('comments.count') }}',
					data: {url: $url, engine: {{ $engineObj->id }}},
					success: function (data) {
						$elm.html(data);
					},
					dataType: 'json'
				});
			});
			@if(Auth::check())
			$('.mark-as-bookmark').each(function (){
				var $elm = $(this);
				$url = $elm.data('url');
				$.ajax({
					url: '{{ route('isbookmarked') }}',
					data: {url: $url},
					success: function (data) {
						if(data){
							$elm.html('<i class="material-icons">star</i>');
						}else{
							$elm.html('<i class="material-icons">star_border</i>');
						}
					},
					dataType: 'json'
				});
			});

			$('.mark-as-bookmark').click(function (){
				var $elm = $(this);
				$url = $elm.data('url');
				$title = $elm.data('title');
				$description = $elm.data('description');
				var $html = $elm.html();
				$.ajax({
					url: '{{ route('bookmark') }}',
					data: {url: $url, title: $title, description: $description, engine: {{ $engineObj->id }}},
					success: function (data) {
						if($html == '<i class="material-icons">star_border</i>'){
							$elm.html('<i class="material-icons">star</i>');
						}else{
							$elm.html('<i class="material-icons">star_border</i>');
						}
						Materialize.toast(data, 2000);
					}
				});
				return false;
			});
			@else
			$('.mark-as-bookmark').click(function (){
				Materialize.toast("{{ trans('bookmarks.logintobook') }}", 2000);
			});
			@endif



			$('.modal').modal({
				dismissible: true,
				opacity: .5,
				ready: function(modal, trigger){
					$rank = $(trigger).data('rank');
					$url = $(trigger).data('url');
					$source = $(trigger).data('source');
					$('#url').val($url);
					$('#rank').val($rank);
					$('#source').val($source);
				}
			});
		});

		$('.seeMore').on('click', function(){
			$id = $(this).attr('id');
			$text = $(this).attr('data-text');
			$('#entity-' + $id).html($text);
			return false;
		});

		function fillEditRankModal($this){
			$('#url').val($($this).data('url'));
			$('#Vurl').val($($this).data('vurl'));
			$('#description').val($($this).data('description'));
			$('#title').val($($this).data('title'));
		}

		$('#updateRankButton').click(function(){
			$url = $('#url').val();
			$vurl = $('#Vurl').val();
			$description = $('#description').val();
			$title = $('#title').val();
			$rank = $('#rank').val();
			$pageLa = $('#page').val();
			$keyword = $('#keyword').val();
			$.ajax({
				url: '{{ route('updaterank') }}',
				data: {
					title: $title,
					description: $description,
					url: $url,
					Vurl: $vurl,
					page: $pageLa,
					rank: $rank,
					keyword: $keyword,
				},
				success: function (data) {
					Materialize.toast(data, 2000);
					$('#editRankModal').modal('close');
					$('.modal-overlay').remove();
				},
				error: function (e) {
					Materialize.toast(e.responseText, 2000);
				}
			});
		});

		var $page = 1;
		$('.comment-link').click(function () {
			$url = $(this).data('url');
			$('#comments-show-url').html($url);
			$('#post-comment-btn').data('url', $url);
			$('#commentsModal').modal('open');

			$.ajax({
				url: '{{ route('comments') }}',
				data: {url: $url, engine: {{ $engineObj->id }}},
				success: function (data) {
					$('#comments-block').html(data);
					$page++;
				},
				error: function (e) {
					Materialize.toast(e.responseText, 2000);
				}
			});
		});

		function goToCommentInput($id, $url){
			$('#replies-'+$id + ' .loader').removeClass('hide');
			$.ajax({
				url: '{{ route('comments') }}',
				data: {url: $url, engine: {{ $engineObj->id }}, r: 1, comment: $id},
				success: function (data) {
					$('#replies-'+$id).html(data);
				},
				error: function (e) {
					Materialize.toast(e.responseText, 2000);
				}
			});
		}

		function postComment($this, $url = null, $comment_id = null){
			var $elem = $($this);
			if($url == null)
				$url = $elem.data('url');
			if($comment_id == null)
				$comment_id = 'all';
			var $comment = $('#comment-input.input-'+$comment_id).val();
			var $reply = $elem.data('reply');
			if($reply == 0)
				$comment_id = 0;
			$engine = {{ $engineObj->id }};

			$.ajax({
				url: '{{ route('comments.post') }}',
				data: {
					url: $url,
					engine: $engine,
					reply: $reply,
					comment: $comment,
					comment_id: $comment_id
				},
				success: function (data){
					if($reply) {
						$('#replies-' + $comment_id).prepend(data);
						Materialize.toast('{{ trans('general.reply_posted') }}', 2000);
					}else{
						$('#comments-block').prepend(data);
						Materialize.toast('{{ trans('general.comment_posted') }}', 2000);
					}
					$('#comment-input.input-'+$comment_id).val('');
				},
				error: function (e) {
					Materialize.toast(e.responseText, 2000);
				}
			});
		}
		function loadMoreComments($this, $url) {
			$.ajax({
				url: '{{ route('comments') }}',
				data: {url: $url, engine: {{ $engineObj->id }}, page: $page},
				success: function (data) {
					$('#comments-block').append(data);
					$this.remove();
					$page++;
				},
				error: function (e) {
					Materialize.toast(e.responseText, 2000);
				}
			});
		}
		function loadMoreReplies($this, $url, $comment_id) {
			$.ajax({
				url: '{{ route('comments') }}',
				data: {url: $url, engine: {{ $engineObj->id }}, r: 1, comment: $comment_id, page: $page},
				success: function (data) {
					$('#block-reply-' + $comment_id).remove();
					$('#replies-' + $comment_id).append(data);
					$this.remove();
					$page++;
				},
				error: function (e) {
					Materialize.toast(e.responseText, 2000);
				}
			});
		}
	</script>
@endsection