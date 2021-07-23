@extends('searchLayout')

@section('content')
	@if(!empty($results))
		@if($totalResults)<span class="results-info">{{ trans('general.about_results', ['total' => $totalResults, 'time' => $renderTime]) }}</span>@endif
		<ul class="row videos" id="videos">
			@foreach($results as $key => $result)
				<li class="result-container col l3 m6 s12">
					<div class="card">
						<div class="card-image">
						@if(isset($result['preview']))
							<!--video style="display: none;" id="video-{{ $key }}" onmouseout="stopPlayingVideo({{ $key }});">
							  <source src="{{ $result['preview'] }}" type="video/mp4">
							  <source src="{{ $result['preview'] }}" type="video/ogg">
							  Your browser does not support HTML5 video.
							</video-->
							@endif
							<a @if(isset($result['preview'])) @endif data-id="video-{{ $key }}" class="preview" id="image-{{ $key }}" target="{{ $settings['resultsTarget'] }}" href="{{ $result['src'] }}">
								<img width="250" height="250" src="{{ $result['thumbnailLink'] }}">
							</a>
							<span class="duration"><i class="material-icons tiny">play_arrow</i> @if(isset($result['duration'])){{ $result['duration'] }} @endif</span>
						</div>
						<div class="card-content">
							<a target="{{ $settings['resultsTarget'] }}" href="{{ $result['src'] }}"><p>{{ $result['title'] }}</p></a>
							<div class="disurl">
								{{ $result['publisher'] }}
								<span style="color: #808080;">
							@if(isset($result['views']))
										- {{ $result['views'] }}+ views
									@endif
									@if(isset($result['date']))
										<br/>{{ $result['date'] }}
									@endif
									@if($settings['enable_bookmarks'])
										<a class="mark-as-bookmark" href="#" data-url="{{ $result['url'] }}" data-title="{{ $result['title'] }}" data-image="{{ $result['thumbnailLink'] }}"><i class="material-icons">star_border</i></a>
									@endif
									@if($settings['enable_comments'])
										<a class="comment-link" href="#" data-url="{{ $result['url'] }}"><i class="material-icons">comment</i>(<span class="comments-count" data-url="{{ $result['url'] }}">0</span>)</a>
									@endif
						</span>
							</div>
						</div>
					</div>
				</li>
			@endforeach
		</ul>
		<br/>

		@if($settings['videosPagination'] == 1)
			<ul class="pagination center">
				<li class="@if($page == 1) disabled @endif left"><a href="@if($page == 1) # @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page - 1])) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li><li class="disabled center"><a href="#">{{ $page }}</a></li>
				<li class="waves-effect @if($lastPage == true) disabled @endif right"><a href="@if($lastPage == true) @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page + 1])) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
			</ul>
		@elseif($settings['videosPagination'] == 2)
			<!--ul class="pagination center">
		<li class="@if($page == 1) disabled @endif"><a href="@if($page == 1) # @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page - 1])) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li>
		@for ($i = 1; $i <= $pages; $i++)
				<li class="@if($page == $i) active @endif center"><a href="{{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $i])) }}">{{ $i }}</a></li>
		@endfor
					<li class="waves-effect @if($lastPage == true) disabled @endif"><a href="@if($lastPage == true) @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page + 1])) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
	</ul-->
			{{ $paginated->appends(array_except($urlParams, ['p']))->links() }}
		@elseif($settings['videosPagination'] == 3)
			<div class="row center">
				<a id="showMoreVideos" style="display:none;" href="#showMoreVideos" class="waves-effect btn modal-trigger">See more videos</a>
				<div id="videosPreloader" class="preloader-wrapper big active">
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
		@endif

	@else
		@include('inc.noResults')
	@endif


	@if(Auth::check())
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
	@endif
@endsection


@section('filters')
	<div class="col l12 s12" id="filters">
		<div id="toolsCard" class="scale-transition @if(!$hasFilters) Ndsp @endif left">
			@if($settings['videosPricingFilter'])
				<a class='dropdown-button mt' href='#' data-activates='pricing' data-beloworigin='true' data-hover='false'>@if(in_array($pricing, $pricingsK)) {{ trans('general.only').': '.$pricing }} @else {{ trans('general.pricing') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['videosLengthFilter'])
				<a class='dropdown-button mt' href='#' data-activates='length' data-beloworigin='true' data-hover='false'>@if(in_array($length, $lengthsK)) {{ trans('general.only').': '. $lengths[$length] }} @else {{ trans('general.length') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['videosResolutionFilter'])
				<a class='dropdown-button mt' href='#' data-activates='resolution' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($resolution, $resolutions)) {{ trans('general.only').': '. $resolutions[$resolution] }} @else {{ trans('general.resolution') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif


			@if($settings['videosPricingFilter'])
				<ul id='pricing' class='dropdown-content dpFi'>
					<li>@if(!in_array($pricing, $pricingsK)) <i class="material-icons">check</i> @endif<a @if(!in_array($pricing, $pricingsK)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['pr', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($pricings as $CpriceK => $Cprice)
						<li>@if($CpriceK == $pricing) <i class="material-icons">check</i> @endif<a @if($CpriceK == $pricing) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['pr', 'p']), ['pr' => $CpriceK])) }}">{{ ucfirst($Cprice) }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($settings['videosLengthFilter'])
				<ul id='length' class='dropdown-content dpFi' style="min-width:130px;">
					<li>@if(!in_array($length, $lengthsK)) <i class="material-icons">check</i> @endif<a @if(!in_array($length, $lengthsK)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['l', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($lengths as $ClengthK => $Clength)
						<li>@if($ClengthK == $length) <i class="material-icons">check</i> @endif<a @if($ClengthK == $length) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['l', 'p']), ['l' => $ClengthK])) }}">{{ ucfirst($Clength) }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($settings['videosResolutionFilter'])
				<ul id='resolution' class='dropdown-content dpFi'>
					<li>@if(!in_array($resolution, $resolutions)) <i class="material-icons">check</i> @endif<a @if(!in_array($resolution, $resolutions)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['r', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($resolutions as $CresolutionK => $Cresolution)
						<li>@if($CresolutionK == $resolution) <i class="material-icons">check</i> @endif<a @if($CresolutionK == $resolution) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['r', 'p']), ['r' => $CresolutionK])) }}">{{ $Cresolution }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($hasFilters)<a class="clearFilter" href="{{ URL::action($action, ['q' => $query]) }}">{{ trans('general.clear_filters') }}</a>@endif

		</div>
		@if($settings['videosResolutionFilter'] or $settings['videosLengthFilter'] or $settings['videosResolutionFilter'])
			<a id="tools" href="#" class="black-text @if($hasFilters) right @endif"><i id="leftArrow" class="material-icons tiny @if(!$hasFilters) Ndsp @endif">chevron_left</i> {{ trans('general.search_tools') }} <i id="rightArrow" class="material-icons tiny @if($hasFilters) Ndsp @endif">keyboard_arrow_right</i><br></a>
		@endif
	</div>
	<div class="clear"></div>
@endsection

@section('javascript')
	<script>
		if ($('#toolsCard').length && $('#tools').length) {
			$('#tools').click(function() {
				$('#toolsCard').toggleClass('Ndsp');
				$('#leftArrow').toggleClass('Ndsp');
				$('#rightArrow').toggleClass('Ndsp');
				$('#toolsCard').toggleClass('scale-in');
				$('#toolsCard').css({'-webkit-transform': 'inherit', 'transform' : 'inherit'});
				$('#tools').toggleClass('right');
			});
		}

		$(document).ready(function(){
			// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
			$('.modal').modal();
		});

		@if($settings['videosPagination'] == 3)
		// load unlimited times
		var $pageNumber = {{ $page + 1}};
		function getExtraVideos($number){
			$.ajax({
				url: '{{ action("VideosController@videosAjax") }}',
				type: 'get',
				data: { @foreach($urlParams as $paramName => $paramValue) {{ $paramName }} : "{{ $paramValue }}", @endforeach p : $number },
			dataType: 'json',
					cache: true,
					success: function(data) {
				count = data.length;
				// if(count > 0){ // IF OBJECT not EMPTY
				$.each(data, function(i, result) {
					$( "#videos" ).append( '<li class="result-container col l3 m6 s12"><div class="card"><div class="card-image"><a target="'+ result.resultsTarget +'" href="'+ result.src +'"><img width="250" height="250" src="'+ result.thumbnailLink +'"></a></div><div class="card-content"><a target="'+ result.resultsTarget +'" href="'+ result.src +'"><p>'+ result.title +'</p></a><p>{{ trans('general.duration') }}: '+ result.duration +'</p></div></div></li>' );
					if (!--count) {
						$("#showMoreVideos").show();
						$("#videosPreloader").hide();
						// Grid.init();
					}
				});
				// }else{
				// $("#showMoreVideos").hide();
				// $("#videosPreloader").hide();
				// console.log('lkhra');
				// }
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$("#showMoreVideos").hide();
				$("#videosPreloader").hide();
				// alert(thrownError + ': ' + xhr.status);
			},
			async:true,
		});
		};

		$(window).on("load", function() {
			getExtraVideos($pageNumber);
			$pageNumber++;
		});

		$("#showMoreVideos").on("click", function() {
			$("#showMoreVideos").hide();
			$("#videosPreloader").show();
			getExtraVideos($pageNumber);
			$pageNumber++;
			return false;
		});

		$(document).ready(function() {
			@if(Auth::check())
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
			$('.mark-as-bookmark').each(function () {
				var $elm = $(this);
				$url = $elm.data('url');
				$.ajax({
					url: '{{ route('isbookmarked') }}',
					data: {url: $url},
					success: function (data) {
						if (data) {
							$elm.html('<i class="material-icons">star</i>');
						} else {
							$elm.html('<i class="material-icons">star_border</i>');
						}
					},
					dataType: 'json'
				});
			});

			$('.mark-as-bookmark').click(function () {
				var $elm = $(this);
				$url = $elm.data('url');
				$title = $elm.data('title');
				$image = $elm.data('image');
				var $html = $elm.html();
				$.ajax({
					url: '{{ route('bookmark') }}',
					data: {url: $url, title: $title, image: $image, engine: {{ $engineObj->id }}},
					success: function (data) {
						if ($html == '<i class="material-icons">star_border</i>') {
							$elm.html('<i class="material-icons">star</i>');
						} else {
							$elm.html('<i class="material-icons">star_border</i>');
						}
						Materialize.toast(data, 2000);
					}
				});
				return false;
			});
			@else
			$('.mark-as-bookmark').click(function () {
				Materialize.toast("{{ trans('bookmarks.logintobook') }}", 2000);
			});
			@endif
		});
		@endif

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


		// function playVideo($id){
		// $video = $('#video-'+$id);
		// $image = $('#image-'+$id);
		// $video.show();
		// $image.hide();
		// $video.trigger('play');
		// }


		// function stopPlayingVideo($id){
		// $video = $('#video-'+$id);
		// $image = $('#image-'+$id);
		// $video.trigger('pause');
		// $video.hide();
		// $image.show();
		// }

		$("#related").hide();
		@if(empty($advertisements))
		$("#rightPanels").hide();
		$("#content").removeClass( "l9" ).addClass( "l12" );
		$("#filters").removeClass( "l9" ).addClass( "l12" );
		@endif
	</script>
@endsection