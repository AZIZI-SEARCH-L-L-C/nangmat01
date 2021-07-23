@extends('pageLayout')

@section('title', $user->username . ' - ')

@section('content')
<style>
#thumbnail-input, #save-button, #thumbnail-waiter{
	display: none;
}
#thumbnail{
	max-height: 140px;
}
</style>
<div class="row form_page">
    <div class="row">
		<div class="container">
			<div class="col m4 s12 left-side">
				@include('inc.leftMenu', ['activeItem' => 'info'])
			</div>
			<div class="col m8 s12">
				@if ($errors->any())
					@foreach ($errors->all() as $error)
						<div class="card-panel red lighten-2">{{ $error }}</div>
					@endforeach
				@endif
				@if(Session::has('message'))
					<div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
				@endif
				<div class="block">
					<p class="block-title center">{{ trans('general.edit_account') }}</p>
					<div class="card">
						<div class="card-content">
							<form action="{{ route('profile.edit.info.post') }}" method="post">
								<div class="row">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.username') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="username" type="text" value="{{ $user->username }}" id="username" placeholder="{{ trans('general.enter_username') }}"/>
									</div>
								</div>
								<div class="row">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.email') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="email" type="text" value="{{ $user->email }}" id="email" placeholder="{{ trans('general.enter_email') }}"/>
									</div>
								</div>
								<div class="row center"><button name="submitEditInfo" value="submit" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.update') }}</button></div>
							</form>
						</div>
					</div>
				</div>
				<div class="block">
					<p class="block-title center">{{ trans('general.two_factors') }}</p>
					<div class="card">
						<div class="card-content">
							<form action="{{ route('profile.edit.info.post') }}" id="form" method="post">
								<div class="row">
									<div class="col s12">
										<input name="email_2fa" type="checkbox" value="1" class="filled-in" id="email_2fa" @if($user->email_2fa) checked @endif>
										<label for="email_2fa">{{ trans('general.enable_email_ver') }}</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<input name="phone_2fa" type="checkbox" value="1" class="filled-in" id="phone_2fa" @if($user->phone_2fa) checked @endif>
										<label for="phone_2fa">{{ trans('general.enable_phone_ver') }}</label>
									</div>
								</div>
								<div class="row">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.phone_number') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="phone_number" type="text" value="{{ $user->phone_number }}" id="phone_number" placeholder="{{ trans('general.enter_phone') }}"/>
									</div>
								</div>
								<div class="row" id="confirm-block" style="display: none;">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.six_digit_code') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="smsCode" type="text" value="{{ Input::old('smsCode') }}" id="smsCode" maxlength="6" placeholder=""/>
										<input name="phone" id="phone" type="hidden"/>
										<input name="uid" id="uid" type="hidden"/>
										<input name="submitEdit2fa" value="submit" type="hidden"/>
									</div>
								</div>

								<div id="LoaderBlock" class="center" style="display: none;">
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

								<div id="resend-block" class="row center" style="display: none;"><button id="sign-in-button" name="token" class="waves-effect btn">{{ trans('general.send_ver_code') }}</button></div>
								<div id="update-block" class="row center"><button id="confirmCodeButton" name="submitEdit2fa" value="submit" type="submit" class="waves-effect btn">{{ trans('general.update') }}</button></div>
							</form>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="block col l6">
					<p class="block-title center">{{ trans('general.edit_account_tmb') }}</p>
					<div class="card">
						<div class="card-content center-align">
							<img class="responsive-img circle" id="thumbnail" src="{{ getUserThumbnail() }}">
							<div class="preloader-wrapper big active" id="thumbnail-waiter">
								<div class="spinner-layer spinner-blue">
									<div class="circle-clipper left">
									  <div class="circle"></div>
									</div>
									<div class="gap-patch">
									  <div class="circle"></div>
									</div>
									<div class="circle-clipper right">
									  <div class="circle"></div>
									</div>
								</div>
							</div>
							<input name="thumbnail" type="file" id="thumbnail-input"/><br>
							<button onclick="select_file();" id="upload-button" class="waves-effect btn modal-trigger"/>{{ trans('general.change') }}</button>
						</div>
					</div>
				</div>
				@if(Config::get('services.facebook.enabled', false) == 'true'
				|| Config::get('services.twitter.enabled', false) == 'true'
				|| Config::get('services.google.enabled', false) == 'true')
					<div class="block col l6">
						<p class="block-title center">{{ trans('general.social_login') }}</p>
						<div class="card">
							<div class="card-content">
								<form action="{{ route('profile.edit.info.post') }}" method="post">
									@if(Config::get('services.facebook.enabled', false) == 'true')
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.facebook') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<a href="{{ route('login.facebook') }}" class="waves-effect btn modal-trigger blue darken-4"/>@if($user->facebookID) {{ trans('general.disconnect') }} @else {{ trans('general.connect') }} @endif</a>
											</div>
										</div>
									@endif
									@if(Config::get('services.twitter.enabled', false) == 'true')
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.twitter') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<a href="{{ route('login.twitter') }}" class="waves-effect btn modal-trigger blue lighten-1"/>@if($user->twitterID) {{ trans('general.disconnect') }} @else {{ trans('general.connect') }} @endif</a>
											</div>
										</div>
									@endif
									@if(Config::get('services.google.enabled', false) == 'true')
										<div class="row">
											<div class="col m3 s12 input-field">
												<p>{{ trans('general.google_plus') }}:</p>
											</div>
											<div class="col m9 s12 input-field">
												<a href="{{ route('login.google') }}" class="waves-effect btn modal-trigger red darken-4"/>@if($user->googleID) {{ trans('general.disconnect') }} @else {{ trans('general.connect') }} @endif</a>
											</div>
										</div>
									@endif
								</form>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script>

	$current_phone = "{{ $user->phone_number }}";
	$phone_changed = false;

$('#phone_2fa, #phone_number').change(function(){
	$new_phone = $('#phone_number').val();
	if($('#phone_2fa').prop('checked') == true && $new_phone != $current_phone){
		$phone_changed = true;
		$('#resend-block').show();
		$('#update-block').hide();
	}
});

function select_file(){
    $('#thumbnail-input').click();
    return false;
}

var name = '';
var fileselect = $id("upload-button");
var form = $id("form");
var progressBlock = $id("thumbnail-waiter");
var thumbnail = $id("thumbnail");

$("input[type=file]").on('change',function(e){
	UploadFile(e.target.files[0]);
});
			

// upload JPEG files
function UploadFile(file) {

	var xhr = new XMLHttpRequest();
	if (xhr.upload) {
		xhr.upload.addEventListener("progress", function(e) {
			// var pc = parseInt(e.loaded / e.total * 100);
			thumbnail.style.display = 'none';
			progressBlock.style.display = 'inline-block';
		}, false);
		xhr.onreadystatechange = function(e) {
			progressBlock.style.display = 'inline-block';
			if (xhr.readyState == 4) {
				if(xhr.status == 200){
					console.log(e);
					thumbnail.style.display = 'inline-block';
					progressBlock.style.display = 'none';
					obj = JSON.parse(xhr.response);
					thumbnail.src = obj.src;
					Materialize.toast($('<span>' + obj.msg + '</span>').add($('<button class="btn-flat toast-action">{{ trans('general.ok') }}</button>')), 10000);
				}else{
					Materialize.toast($('<span>' + xhr.response + '</span>').add($('<button class="btn-flat toast-action">{{ trans('general.ok') }}</button>')), 10000);
				}
			}else{
				// not ready yet
			}
		};
		xhr.open("POST", "{{ route('profile.edit.thumbnail.post') }}", true);
		var formData = new FormData();
		formData.append('thumbnail', file);
		xhr.send(formData);

	}

}
	
    // file selection
    function FileSelectHandler(f) {
		
		// fetch FileList object
		// var files = e.target.files || e.dataTransfer.files;
		// var files = fileselect.files;

		// process all File objects
		// for (var i = 0, f; f = files[i]; i++) {
			// ParseFile(f);
			UploadFile(f);
		// }

	}
	
	// getElementById
	function $id(id) {
		return document.getElementById(id);
	}
	
	// getElementsByClassName
	function $getClass($class1) {
		return document.getElementsByClassName($class1);
	}

</script>

		<!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

		<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
		<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>
		<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
		<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-analytics.js"></script>
		<!-- Add Firebase products that you want to use -->
		<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-firestore.js"></script>


		<script>

			// var phoneNumber = "";

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
							$('#confirm-block').show();
							$('#update-block').show();
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
				if(!$phone_changed){
					$('#form').submit();
					return false;
				}
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

			// $(document).ready(function() {
			// 	send($('#phone_number').val());
			// });

			$('#sign-in-button').click(function($e){
				$e.preventDefault();
				$('#LoaderBlock').show();
				$('#confirm-block').hide();
				$('#update-block').hide();
				send($('#phone_number').val());
			});

			$('#confirmCodeButton').click(function($e){
				$e.preventDefault();
				$code = $('#smsCode').val();
				checkLogin($code);
			});
		</script>
@endsection
