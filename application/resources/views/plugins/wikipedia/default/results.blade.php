@extends('searchLayout')

@section('content')
    <style>
        .searchresults-wiki .searchresult {
            margin-bottom: 5px;
            padding: 10px 0 !important;
            border-bottom: 1px solid #e0e0e0 !important;
        }
        .searchresults-wiki .title{
            display: block;
            font-size: 16px;
            line-height: 16px;
            color: #0000cc;
        }
        .searchresults-wiki .searchresult .visible-link {
            display: block;
            font-style: normal;
            color: #0e7744;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: lowercase;
            word-wrap: break-word;
        }
        .searchresults-wiki .searchmatch{
            font-weight: bold;
        }
        .pagination li.active {
            color: #fff;
        }
        .text-center{
            text-align: center;
        }
    </style>

    <div class="searchresults searchresults-wiki" id="searchresults">
        <ul>
            @foreach($results as $result)
                <li class="searchresult">
                    <a class="title" href="{{ prepWikipediaUrlFromTitle($result['title']) }}"><strong>{{ $result['title'] }}</strong></a>
                    <cite class="visible-link">{{ prepVisibleWikipediaUrlFromTitle($result['title']) }}</cite>
                    <p class="description">{!! $result['snippet'] !!}</p>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="text-center">
        {!! $results->links() !!}
    </div>
@endsection