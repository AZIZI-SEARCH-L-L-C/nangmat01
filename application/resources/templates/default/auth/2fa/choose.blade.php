@extends('pageLayout')

@section('title', '2-Step Verification -')

@section('content')
    <div class="row form_page">
    <!--p class="sub_title center">with your {{ $settings['siteName'] }} Account</p-->
        <div class="row">
            <div class="container">
                <form action="{{ route('2fa.choose.post') }}" method="post">
                    <div class="col m6 s12 offset-m3">
                        <div class="block">
                            <p class="block-title center">2-Step Verification</p>
                            <div class="card">
                                <div class="card-content">
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
                                    <div class="row" style="margin: 15px 0;">Please choose a method to confirm your identity:</div>
                                    <div class="row">
                                        @if($email_2fa)
                                            <div class="col s12">
                                                <input name="way" type="radio" value="email" class="with-gap" id="email" checked>
                                                <label for="email">Email: {{ $email_obf }}</label>
                                            </div>
                                        @endif
                                        @if($phone_2fa)
                                            <div class="col s12">
                                                <input name="way" type="radio" value="phone" class="with-gap" id="phone">
                                                <label for="phone">Phone: {{ $phone_obf }}</label>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row center"><button name="token" value="{{ csrf_token() }}" type="submit" class="waves-effect btn modal-trigger"/>Continue</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

@endsection