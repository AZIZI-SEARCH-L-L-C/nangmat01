@extends('searchLayout')

@section('content')
    @if(!empty($results))
        @if($totalResults)<span class="results-info">{{ trans('general.about_results', ['total' => $totalResults, 'time' => $renderTime]) }}</span>@endif
        @foreach($results as $result)
            <div class="result-container news-results">
                <div class="row" style="margin:0;padding:0;">
                    @if($settings['newsThumbnail'] && $result['thumbnail'])<div class="col m2 hide-on-small-only"><img style="width:100%;height:100%"; src="{{ $result['thumbnail'] }}" /></div>
                    <div class="col m10">@endif
                        <div class="title"><a target="{{ $settings['resultsTarget'] }}" href="{{ $result['url'] }}">{{ $result['title'] }}</a>
                            @if($settings['enable_bookmarks'])
                                <a class="mark-as-bookmark" href="#" data-url="{{ $result['url'] }}" data-title="{{ $result['title'] }}" data-description="{{ $result['description'] }}"><i class="material-icons">star_border</i></a>
                            @endif
                        </div>
                        <div class="desc">{{ $result['description'] }}</div>
                        <div class="disurl">
                            {{ $result['datePublished'] }}
                            @if($result['provider'])-  <span>{{ $result['provider'] }}</span> @endif @if($result['category'])- {{ $result['category'] }}@endif</div>
                        @if($settings['newsThumbnail'] && $result['thumbnail'])</div>@endif
                    @if($settings['enable_comments']) - <a class="comment-link" href="#" data-url="{{ $result['url'] }}">{{ trans('general.comments') }} (<span class="comments-count" data-url="{{ $result['url'] }}">0</span>)</a> @endif
                </div>
            </div>
        @endforeach
        <div class="row">
            @if($settings['newsPagination'] == 1)
                <ul class="pagination center">
                    <li class="@if($page == 1) disabled @endif left"><a href="@if($page == 1) # @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page - 1])) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li><li class="disabled center"><a href="#">{{ $page }}</a></li>
                    <li class="waves-effect @if($lastPage == true) disabled @endif right"><a href="@if($lastPage == true) @else {{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $page + 1])) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
                </ul>
            @elseif($settings['newsPagination'] == 2)
            <!--ul class="pagination center">
					<li class="@if($page == 1) disabled @endif"><a href="@if($page == 1) # @else {{ URL::action('WebController@search', ['q' => $query, 'p' => $page - 1]) }} @endif"><i class="material-icons">chevron_left</i> {{ trans('general.previous') }}</a></li>
					@for ($i = 1; $i <= $pages; $i++)
                <li class="@if($page == $i) active @endif center"><a href="{{ URL::action($action, array_merge(array_except($urlParams, ['p']), ['p' => $i])) }}">{{ $i }}</a></li>
					@endfor
                    <li class="waves-effect @if($lastPage == true) disabled @endif"><a href="@if($lastPage == true) @else {{ URL::action('WebController@search', ['q' => $query, 'p' => $page + 1]) }} @endif">{{ trans('general.next') }} <i class="material-icons">chevron_right</i></a></li>
				</ul-->
                {{ $paginated->appends(array_except($urlParams, ['p']))->links() }}
            @endif
        </div>

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
            @if($sorts)
                <a class='dropdown-button mt' href='#' data-activates='sort' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>{{ trans('general.sort') }}<i class="material-icons tiny">arrow_drop_down</i></a>
            @endif

            @if($settings['dateFilter'] && $sort != 'date')
                <a class='dropdown-button mt' href='#' data-activates='date' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($date, $datesK)) {{ $dates[$date] }} @else {{ trans('general.time') }} @endif<i class="material-icons tiny">arrow_drop_down</i></a>
            @endif

            @if($sorts)
                <ul id='sort' class='dropdown-content dpFi' style="min-width:180px;">
                    @foreach($sorts as $st)
                        <li> @if($st['isSelected']) <i class="material-icons">check</i> @endif<a @if($st['isSelected']) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['s', 'p']), ['s' => $st['id']])) }}">{{ $st['name'] }}</a></li>
                    @endforeach
                </ul>
            @endif

            @if($settings['countryFilter'])
                <a class='dropdown-button mt' href='#' data-activates='countries' data-beloworigin='true' data-constrainWidth='false' data-hover='false'>@if(in_array($region, $countries)) {{ trans('general.only').': '.array_get(config('locales'), $region) }} @else Region @endif <i class="material-icons tiny">arrow_drop_down</i></a>
            @endif

            @if($settings['dateFilter'] && $sort != 'date')
                <ul id='date' class='dropdown-content dpFi' style="min-width:180px;">
                    <li>@if(!in_array($date, $datesK)) <i class="material-icons">check</i> @endif<a @if(!in_array($date, $datesK)) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['d', 'p']))) }}">{{ trans('general.any_time') }}</a></li>
                    @foreach($dates as $dt => $dtV)
                        <li>@if($dt == $date) <i class="material-icons">check</i> @endif<a @if($dt == $date) class="active" @endif href="{{ URL::action($action, array_merge(array_except($urlParams, ['d', 'p']), ['d' => $dt])) }}">{{ $dtV }}</a></li>
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

            @if($hasFilters)<a class="clearFilter" href="{{ URL::action($action, ['q' => $query]) }}">{{ trans('general.clear_filters') }}</a>@endif

        </div>
        @if($settings['countryFilter'] or $settings['dateFilter'])
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
                return false;
            });
        }

        $(document).ready(function(){
            // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
            $('.modal').modal();
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
                $description = $elm.data('description');
                var $html = $elm.html();
                $.ajax({
                    url: '{{ route('bookmark') }}',
                    data: {url: $url, title: $title, description: $description, engine: {{ $engineObj->id }}},
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