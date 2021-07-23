@extends('pageLayout')

@section('title', trans('general.sign_up') . ' -')

@section('content')
	<div class="row form_page">
	<!--p class="sub_title center">with your {{ $settings['siteName'] }} Account</p-->
		<div class="row">
			<div class="container">
				<form action="{{ route('register.post') }}" method="post">
					<div class="col m6 s12 offset-m3">
						<div class="block">
							<p class="block-title center">{{ trans('general.sign_up') }}</p>
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
									<div class="row center">
										@if(config('service.facebook.enabled')) <a href="{{ route('login.facebook') }}" class="waves-effect btn modal-trigger blue darken-4"/>{{ trans('general.facebook') }}</a> @endif
										@if(config('service.twitter.enabled')) <a href="{{ route('login.twitter') }}" class="waves-effect btn modal-trigger blue lighten-1"/>{{ trans('general.twitter') }}</a> @endif
										@if(config('service.google.enabled')) <a href="{{ route('login.google') }}" class="waves-effect btn modal-trigger red darken-4"/>{{ trans('general.google_plus') }}</a> @endif
									</div>
									@if(config('service.facebook.enabled') || config('service.twitter.enabled') || config('service.google.enabled'))
										<div class="row center" style="margin: 15px 0;">{{ trans('general.or_by_email') }}:</div>
									@endif
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.username') }}:</p>
										</div>
										<div class="col m9 s12 input-field">
											<input name="username" type="text" value="{{ Input::old('username') }}" id="username" placeholder="{{ trans('general.enter_username') }}"/>
										</div>
									</div>
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.email') }}:</p>
										</div>
										<div class="col m9 s12 input-field">
											<input name="email" type="text" value="{{ Input::old('email') }}" id="email" placeholder="{{ trans('general.enter_email') }}"/>
										</div>
									</div>
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.password') }}:</p>
										</div>
										<div class="col m9 s12 input-field">
											<input name="password" type="password" value="" id="password" placeholder="{{ trans('general.enter_your_pass') }}"/>
										</div>
									</div>
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.confirm_pass') }}:</p>
										</div>
										<div class="col m9 s12 input-field" style="margin-bottom:10px;">
											<input style="margin-bottom:3px;" name="password_confirmation" type="password" value="" id="password_confirmation" placeholder="{{ trans('general.enter_your_pass_confirmation') }}"/>
											<a href="{{ route('login') }}">{{ trans('general.have_account') }}</a>
										</div>
									</div>
									<div class="row center"><button name="token" value="{{ csrf_token() }}" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.register') }}</button></div>
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