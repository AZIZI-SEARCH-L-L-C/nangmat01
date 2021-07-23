@extends('searchLayout')


@section('content')
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/default.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/component.css') }}" />
	<script src="{{ URL::asset('assets/js/modernizr.custom.js') }}"></script>
	@if(!empty($results))
		@if($totalResults)<span class="results-info">{{ trans('general.about_results', ['total' => $totalResults, 'time' => $renderTime]) }}</span>@endif
		<ul id="og-grid" class="og-grid">
			@foreach($results as $key => $result)
				<li id="id-1-{{ $key }}">
					<a target="{{ $settings['resultsTarget'] }}" href="{{ $result['url'] }}" data-image="{{ $result['thumbnailLink'] }}" data-largesrc="{{ $result['src'] }}" data-title="{{ $result['title'] }}" data-description="Type: {{ $result['mime'] }} ; Width: {{ $result['width'] }} ; Height: {{ $result['height'] }} ; Size: {{ $result['size'] }} <br>{{ $result['displayLink'] }} <br> {{ $result['source'] }}">
						<img width="200" height="200" src="{{ $result['thumbnailLink'] }}" alt="{{ $result['title'] }}"/>
					</a>
				</li>
			@endforeach
		</ul>
		@if($settings['imagesPagination'] == 1)
			<ul class="pagination center">
				<li class="@if($page == 1) disabled @endif left"><a href="@if($page == 1) # @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page - 1])) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li><li class="disabled center"><a href="#">{{ $page }}</a></li>
				<li class="waves-effect @if($lastPage == true) disabled @endif right"><a href="@if($lastPage == true) @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page + 1])) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
			</ul>
		@elseif($settings['imagesPagination'] == 2)
			<!--ul class="pagination center">
		<li class="@if($page == 1) disabled @endif"><a href="@if($page == 1) # @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page - 1])) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li>
		@for ($i = 1; $i <= $pages; $i++)
				<li class="@if($page == $i) active @endif center"><a href="{{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $i])) }}">{{ $i }}</a></li>
		@endfor
					<li class="waves-effect @if($lastPage == true) disabled @endif"><a href="@if($lastPage == true) @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page + 1])) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
	</ul-->
			{{ $paginated->appends(array_except($urlParams, ['p']))->links() }}
		@elseif($settings['imagesPagination'] == 3)
			<div class="row center">
				<a id="showMoreImages" style="display:none;" href="#showMoreImages" class="waves-effect btn modal-trigger">{{ trans('general.more_images') }}</a>
				<div id="imagesPreloader" class="preloader-wrapper big active">
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
	<div id="filters" class="col l9 s12">
		<div id="toolsCard" class="scale-transition @if(!$hasFilters) Ndsp @endif left">
			@if($settings['imgColorFilter'])
				<a class='dropdown-button mt' href='#' data-activates='color' data-beloworigin='true' data-hover='false'>@if(in_array($color, $colors)) {{ trans('general.only').': '.$color }} @else
						{{ trans('general.color') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['imgTypeFilter'])
				<a class='dropdown-button mt' href='#' data-activates='type' data-beloworigin='true' data-hover='false'>@if(in_array($imgType, $imgTypesK)) {{ trans('general.only').': '. $imgTypes[$imgType] }} @else {{ trans('general.type') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['imgLicenseFilter'])
				<a class='dropdown-button mt' href='#' data-activates='license' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($license, $licensesK)) {{ trans('general.only').': '. $licenses[$license] }} @else {{ trans('general.usage_rights') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif
			@if($settings['imgSizeFilter'])
				<a class='dropdown-button mt' href='#' data-activates='size' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($imgSize, $imgSizesK)) {{ trans('general.only').': '. $imgSizes[$imgSize] }} @else {{ trans('general.size') }} @endif <i class="material-icons tiny">arrow_drop_down</i></a>
			@endif


			@if($settings['imgColorFilter'])
				<ul id='color' class='dropdown-content dpFi'>
					<li>@if(!in_array($color, $colors)) <i class="material-icons">check</i> @endif<a @if(!in_array($color, $colors)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['c', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($colors as $Ccolor)
						<li>@if($Ccolor == $color) <i class="material-icons">check</i> @endif<a @if($Ccolor == $color) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['c', 'p']), ['c' => $Ccolor])) }}">{{ ucfirst($Ccolor) }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($settings['imgTypeFilter'])
				<ul id='type' class='dropdown-content dpFi'>
					<li>@if(!in_array($imgType, $imgTypesK)) <i class="material-icons">check</i> @endif<a @if(!in_array($imgType, $imgTypesK)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['t', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($imgTypes as $Ctypek => $Ctype)
						<li>@if($Ctypek == $imgType) <i class="material-icons">check</i> @endif<a @if($Ctypek == $imgType) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['t', 'p']), ['t' => $Ctypek])) }}">{{ ucfirst($Ctype) }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($settings['imgLicenseFilter'])
				<ul id='license' class='dropdown-content dpFi' style="min-width:180px;">
					<li>@if(!in_array($license, $licensesK)) <i class="material-icons">check</i> @endif<a @if(!in_array($license, $licensesK)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['l', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($licenses as $Clicensek => $Clicense)
						<li>@if($Clicensek == $license) <i class="material-icons">check</i> @endif<a @if($Clicensek == $license) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['l', 'p']), ['l' => $Clicensek])) }}">{{ $Clicense }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($settings['imgSizeFilter'])
				<ul id='size' class='dropdown-content dpFi'>
					<li>@if(!in_array($imgSize, $imgSizes)) <i class="material-icons">check</i> @endif<a @if(!in_array($imgSize, $imgSizes)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['s', 'p']))) }}">{{ trans('general.all') }}</a></li>
					@foreach($imgSizes as $CimgSizeK => $CimgSize)
						<li>@if($CimgSizeK == $imgSize) <i class="material-icons">check</i> @endif<a @if($CimgSizeK == $imgSize) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['s', 'p']), ['s' => $CimgSizeK])) }}">{{ $CimgSize }}</a></li>
					@endforeach
				</ul>
			@endif

			@if($hasFilters)<a class="clearFilter" href="{{ URL::action($action, ['q' => $query]) }}">{{ trans('general.clear_filters') }}</a>@endif

		</div>
		@if($settings['imgColorFilter'] or $settings['imgTypeFilter'] or $settings['imgLicenseFilter'] or $settings['imgSizeFilter'])
			<a id="tools" href="#" class="black-text @if($hasFilters) right @endif"><i id="leftArrow" class="material-icons tiny @if(!$hasFilters) Ndsp @endif">chevron_left</i> {{ trans('general.search_tools') }} <i id="rightArrow" class="material-icons tiny @if($hasFilters) Ndsp @endif">keyboard_arrow_right</i><br></a>
		@endif
	</div>
	<div class="clear"></div>
@endsection

@section('javascript')
	<script>
		var enable_comments = {{ $settings['enable_comments'] }};
		var enable_bookmarks = {{ $settings['enable_bookmarks'] }};
		@if(Auth::check())
		var $logedIn = true;
		@else
		var $logedIn = true;
		@endif
		var $checkBookedUrl = '{{ route('isbookmarked') }}';
		var $getCommentsCountUrl = '{{ route('comments.count') }}';
		var $engineId = '{{ $engineObj->id }}';
	</script>
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
			// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
			$('.modal').modal();
		});

		@if($settings['imagesPagination'] == 3)
		// load unlimited times
		var $pageNumber = {{ $page + 1}};
		function getExtraImages($number){
			$.ajax({
				url: '{{ action("ImagesController@imagesAjax") }}',
				type: 'get',
				data: { @foreach($urlParams as $paramName => $paramValue) {{ $paramName }} : "{{ $paramValue }}", @endforeach p : $number },
			dataType: 'json',
					cache: true,
					success: function(data) {
				count = data.length;
				// if(count > 0){ // IF OBJECT not EMPTY
				$.each(data, function(i, result) {
					$( ".og-grid" ).append( '<li id="id-'+ $number + '-' + i +'"><a target="{{ $settings['resultsTarget'] }}" href="' + result.url + '" data-image="' + result.thumbnailLink + '" data-largesrc="' + result.src + '" data-title="' + result.title + '" data-description="Type: ' + result.mime + ' ; Width: ' + result.width + ' ; Height: ' + result.height + ' ; Size: ' + result.size + ' <br>' + result.displayLink + ' <br> ' + result.source + '"><img width="200" height="200" src="' + result.thumbnailLink + '" alt="' + result.title + '"/></a></li>' );
					Grid.addItem($('#id-'+ $number + '-' + i));
					if (!--count) {
						$("#showMoreImages").show();
						$("#imagesPreloader").hide();
						// Grid.init();
					}
				});
				// }else{
				// $("#showMoreImages").hide();
				// $("#imagesPreloader").hide();
				// console.log('lkhra');
				// }
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$("#showMoreImages").hide();
				$("#imagesPreloader").hide();
				// alert(thrownError + ': ' + xhr.status);
			},
			async:true,
		});
		};

		$(window).on("load", function() {
			getExtraImages($pageNumber);
			$pageNumber++;
		});

		$("#showMoreImages").on("click", function() {
			$("#showMoreImages").hide();
			$("#imagesPreloader").show();
			getExtraImages($pageNumber);
			$pageNumber++;
			console.log($pageNumber);
			return false;
		});

		// $(window).scroll(function () {
		// if ($(window).scrollTop() >= $(document).height() - $(window).height() - 400) {
		// $(window).unbind('scroll');
		// getExtraImages($pageNumber);
		// console.log('in scroll to Bottom excuted now');
		// $pageNumber++;
		// }
		// });
		@endif



		$("#related").hide();
		@if(empty($advertisements))
		$("#rightPanels").hide();
		$("#content").removeClass( "l9" ).addClass( "l12" );
		$("#filters").removeClass( "l9" ).addClass( "l12" );
		@endif

		@if(Auth::check())
		$('body').on('click', '.mark-as-bookmark', function (){
			var $elm = $(this);
			$url = $elm.data('url');
			$title = $elm.data('title');
			$image = $elm.data('image');
			var $html = $elm.html();
			$.ajax({
				url: '{{ route('bookmark') }}',
				data: {url: $url, title: $title, image: $image, engine: {{ $engineObj->id }}},
				success: function (data) {
					if($html == 'star_border'){
						$elm.html('star');
					}else{
						$elm.html('star_border');
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

		var $page = 1;
		$('body').on('click', '.comment-link', function () {
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
						Materialize.toast('Reply posted', 2000);
					}else{
						$('#comments-block').prepend(data);
						Materialize.toast('Comment posted', 2000);
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