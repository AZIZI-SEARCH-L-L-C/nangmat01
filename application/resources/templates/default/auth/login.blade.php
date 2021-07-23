@extends('pageLayout')

@section('title', trans('general.sign_in') . ' -')

@section('content')
<div class="row form_page">
	<!--p class="sub_title center">with your {{ $settings['siteName'] }} Account</p-->	
    <div class="row">
		<div class="container">
			<form action="{{ route('login.post') }}" method="post">
				<div class="col m6 s12 offset-m3">
					<div class="block">
						<p class="block-title center">{{ trans('general.sign_in') }}</p>
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
									@if(config('services.facebook.enabled') == 'true') <a href="{{ route('login.facebook') }}" class="waves-effect btn modal-trigger blue darken-4"/>{{ trans('general.facebook') }}</a> @endif
									@if(config('services.twitter.enabled') == 'true') <a href="{{ route('login.twitter') }}" class="waves-effect btn modal-trigger blue lighten-1"/>{{ trans('general.twitter') }}</a> @endif
									@if(config('services.google.enabled') == 'true') <a href="{{ route('login.google') }}" class="waves-effect btn modal-trigger red darken-4"/>{{ trans('general.google_plus') }}</a> @endif
								</div>
								@if(config('services.facebook.enabled') == 'true' || config('services.twitter.enabled') == 'true' || config('services.google.enabled') == 'true')
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
										<p>{{ trans('general.password') }}:</p>
									</div>
									<div class="col m9 s12 input-field" style="margin-bottom:10px;">
										<input style="margin-bottom:3px;" name="password" type="password" value="" id="password" placeholder="{{ trans('general.enter_your_pass') }}"/>
										<a href="{{ route('password.reset') }}">{{ trans('general.forget_pass') }}</a><br/>
										<a href="{{ route('register') }}">{{ trans('general.no_account') }}</a>
									</div>
								</div>
								<div class="row center"><button name="token" value="{{ csrf_token() }}" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.login') }}</button></div>
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