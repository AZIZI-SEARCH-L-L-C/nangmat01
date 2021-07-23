@extends('pageLayout')

@section('title', trans('general.pass_title') . ' - ')

@section('content')
	<div class="row form_page">
		<div class="row">
			<div class="container">
				<form action="{{ route('password.reset.post') }}" method="post">
					<div class="col m6 s12 offset-m3">
						<div class="block">
							<p class="block-title center">{{ trans('general.pass_title') }}</p>
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
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.email_email_address') }}:</p>
										</div>
										<div class="col m9 s12 input-field">
											<input name="email" type="text" value="{{ $email or old('email') }}" id="email" placeholder="{{ trans('general.email_enter_email') }}"/>
											<input type="hidden" name="token" value="{{ $token }}">
										</div>
									</div>
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.password') }}:</p>
										</div>
										<div class="col m9 s12 input-field">
											<input name="password" type="password" id="password" placeholder="{{ trans('general.enter_your_pass') }}"/>
										</div>
									</div>
									<div class="row">
										<div class="col m3 s12 input-field">
											<p>{{ trans('general.confirm_pass') }}:</p>
										</div>
										<div class="col m9 s12 input-field">
											<input name="password_confirmation" type="password" id="password_confirmation" placeholder="{{ trans('general.enter_your_pass_confirmation') }}"/>
										</div>
									</div>
									<div class="row center"><button name="token_csrf" value="{{ csrf_token() }}" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.pass_reset_button') }}</button></div>
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