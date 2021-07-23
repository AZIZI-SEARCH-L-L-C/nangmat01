@extends('layouts.page')

@section('content')
    <link type="text/css" rel="stylesheet" href="{{ Asset('assets/plugins/wikipedia/wiki.css') }}?v={{ $assets_v }}"  media="screen,projection"/>
    <div class="row">
        <div id="container-results" class="container">
            <div class="searchresults searchresults-wiki" id="searchresults">
                <ol>
                    @foreach($results as $result)
                        <li class="searchresult">
                            <h3><a href="{{ prepWikipediaUrlFromTitle($result['title']) }}"><strong>{{ $result['title'] }}</strong></a></h3>
                            <cite>{{ prepVisibleWikipediaUrlFromTitle($result['title']) }}</cite>
                            <p>{!! $result['snippet'] !!}</p>
                        </li>
                    @endforeach
                </ol>
                <div>
                    {!! $results->links('plugins.wikipedia.boomdo.pagination') !!}
                </div>
            </div>
        </div>
    </div>
@endsection