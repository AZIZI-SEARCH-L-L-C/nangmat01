@extends('pageLayout')

@section('title', trans('general.submit_site_title').' - ')

@section('content')
    <div class="row">
        <div class="row">
            <div class="container">
                <div class="col l12">
                    <div class="card">
                        <div class="card-content">
                            <form action="{{ route('submit.site') }}" method="post">
                                @if ($errors->any())
                                    <div class="col s12">
                                        @foreach ($errors->all() as $error)
                                            <div class="card-panel red lighten-2">{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                @if(Session::has('message'))
                                    <div class="col s12"><div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div></div>
                                @endif
                                <div class="row">
                                    <div class="col m3 s12 input-field">
                                        <p>{{ trans('general.email') }}:</p>
                                    </div>
                                    <div class="col m9 s12 input-field">
                                        <input name="email" type="text" value="{{ Input::old('email', $email) }}" id="email" placeholder="{{ trans('general.enter_email') }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col m3 s12 input-field">
                                        <p>{{ trans('general.site_url') }}:</p>
                                    </div>
                                    <div class="col m9 s12 input-field" style="margin-bottom:10px;">
                                        <input style="margin-bottom:3px;" name="url" type="url" value="" id="url" placeholder="{{ trans('general.enter_site_url') }}"/>
                                    </div>
                                </div>
                                <div class="row center"><button name="token" value="{{ csrf_token() }}" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.submit') }}</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection