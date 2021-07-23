@extends('layouts.page')

@section('content')
    <link type="text/css" rel="stylesheet" href="{{ Asset('assets/plugins/wikipedia/wiki.css') }}?v={{ $assets_v }}"  media="screen,projection"/>
    <div class="row wiki-row">
        <div id="container-results" class="container wiki-page">
            <div class="row">
                <div class="col s12">
                    <h1>{{ $title }} <span class="wiki-page-info">{{ trans('wikipedia-plugin.source', ['slug' => $slug]) }}</span></h1>
                </div>
            </div>
            <div class="row">
                <div class="col l9 s12 content-wiki">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
@endsection