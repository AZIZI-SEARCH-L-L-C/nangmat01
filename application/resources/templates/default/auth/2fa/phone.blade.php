@extends('pageLayout')

@section('title', '2-Step Verification -')

@section('content')
    <div class="row form_page">
    <!--p class="sub_title center">with your {{ $settings['siteName'] }} Account</p-->
        <div class="row">
            <div class="container">
                <form action="{{ route('2fa.phone') }}" method="post" id="form">
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
                                    <div id="LoaderBlock" class="center">
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
                                    <div id="proccessBlock" style="display: none;">
                                         <div class="row center" style="margin: 15px 0;">A text message with your code has been sent to
                                             {{ $phone_obf }}</div>
                                         <div class="row">
                                            <div class="col m3 s12 input-field">
                                                <p>6-digit Code :</p>
                                            </div>
                                            <div class="col m9 s12 input-field">
                                                <input name="smsCode" type="text" value="{{ Input::old('smsCode') }}" id="smsCode" maxlength="6" placeholder=""/>
                                                <input name="phone" id="phone" type="hidden"/>
                                                <input name="uid" id="uid" type="hidden"/>
                                            </div>
                                        </div>
                                        <div class="row center">
                                            <button id="sign-in-button" name="token" class="waves-effect btn"/>Resend Code</button>
                                            <button id="verify-code" class="waves-effect btn"/>Verify Code</button>
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
    <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>
    <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-analytics.js"></script>
    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-firestore.js"></script>


    <script>

        var phoneNumber = "{{ $phone }}";

        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyBFKc7uiHJjQ5xKLBxSedjFG49SPlerRG0",
            authDomain: "testing-140700.firebaseapp.com",
            projectId: "testing-140700",
            storageBucket: "testing-140700.appspot.com",
            messagingSenderId: "344506596050",
            appId: "1:344506596050:web:dd5c3ae87c94b82d724b0b"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.auth().languageCode = 'en';

        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
            'size': 'invisible',
            'callback': (response) => {
                // reCAPTCHA solved, allow signInWithPhoneNumber.
                onSignInSubmit();
            }
        });

        function send($phone){
            const phoneNumber = $phone;
            const appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then((confirmationResult) => {
                    // SMS sent. Prompt user to type the code from the message, then sign the
                    // user in with confirmationResult.confirm(code).
                    window.confirmationResult = confirmationResult;
                    $('#proccessBlock').show();
                    $('#LoaderBlock').hide();
                    Materialize.toast('Mobile phone verification code sent successfully.', 2000);
                    $('#sign-in-button').prop('disabled', true);

                    var sec = 60;

                    var x = setInterval(function() {
                        sec--;
                        $('#sign-in-button').html('Resend ('+sec+')');
                        if (sec < 1) {
                            clearInterval(x);
                            $('#sign-in-button').html('Resend code');
                            $('#sign-in-button').prop('disabled', false);
                        }
                    }, 1000);

                    // ...
                }).catch((error) => {
                // console.log('error');
                // console.log(error);

                window.recaptchaVerifier.render().then(function(widgetId) {
                    grecaptcha.reset(widgetId);
                });
                // Error; SMS not sent
                // ...
            });
        }

        function checkLogin($code){
            const code = $code;
            confirmationResult.confirm(code).then((result) => {
                Materialize.toast('Successful authentication.', 2000);
                // User signed in successfully.
                const user = result.user;
                $('#phone').val(user.phoneNumber);
                $('#uid').val(user.uid);
                $('#form').submit();

            }).catch((error) => {
                Materialize.toast('Incorrect code!', 2000);
                // User couldn't sign in (bad verification code?)
                // ...
            });
        }

        $(document).ready(function() {
            send(phoneNumber);
        });

        $('#sign-in-button').click(function($e){
            $e.preventDefault();
            send(phoneNumber);
        });

        $('#verify-code').click(function($e){
            $e.preventDefault();
            $code = $('#smsCode').val();
            checkLogin($code);
        });
    </script>
@endsection