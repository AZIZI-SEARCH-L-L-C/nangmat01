@extends('pageLayout')

@section('title', '2-Step Verification -')

@section('content')
    <div class="row form_page">
    <!--p class="sub_title center">with your {{ $settings['siteName'] }} Account</p-->
        <div class="row">
            <div class="container">
                <form action="{{ route('2fa.email.post') }}" method="post">
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
                                    <div>
                                        <div class="row center" style="margin: 15px 0;">An email with your code has been sent to
                                            {{ $email_obf }}</div>
                                        <div class="row">
                                            <div class="col m3 s12 input-field">
                                                <p>6-digit Code :</p>
                                            </div>
                                            <div class="col m9 s12 input-field">
                                                <input name="emailCode" type="text" value="{{ Input::old('emailCode') }}" id="emailCode" maxlength="6" placeholder=""/>
                                            </div>
                                        </div>
                                        <div class="row center">
                                            <button id="verify-code" type="submit" class="waves-effect btn"/>Verify Code</button>
                                        </div>
                                    </div>
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