@extends('pageLayout')

@section('content')
    <div class="row">
        <div id="container-results" class="container">
            <div class="col l9 s12 customPage">
                <h2>{{ $title }}</h2>

                {!! $content !!}
            </div>
            <div class="col l3 s12 page-menu">
                <span class="related-searches-title">Other pages</span>
                @if(config('plugins.custompages.active'))
                    <ul id="related">
                        @foreach(AziziSearchEngineStarter\CustomPages::get() as $page)
{{--                            <li class="related-search"><a href="{{ action('plugins\custompages\CustomPagesController@get' ,['slug' => $page->slug]) }}">{{ trans('custompages-plugin-'.$page->slug.'.title') }}</a></li>--}}
                            <li class="related-search"><a href="{{ action('plugins\custompages\CustomPagesController@get' ,['slug' => $page->slug]) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection