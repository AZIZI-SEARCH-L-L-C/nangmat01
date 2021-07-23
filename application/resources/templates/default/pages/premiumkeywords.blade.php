@extends('pageLayout')

@section('title', trans('general.premium_keywords') . ' - ')

@section('content')
    <div class="row">
        <div class="row">
            <div class="container">
                <div class="col l12">
                    <div class="card">
                        <div class="card-content">
                            <h3>{{ trans('general.premium_keywords') }}</h3>
                            <p>{!! trans('general.premium_keywords_text') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection