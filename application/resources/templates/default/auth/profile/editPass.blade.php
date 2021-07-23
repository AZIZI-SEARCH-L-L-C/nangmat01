@extends('pageLayout')

@section('title', $user->username . ' - ')

@section('content')
<div class="row form_page">
    <div class="row">
		<div class="container">
			<div class="col m4 s12 left-side">
				@include('inc.leftMenu', ['activeItem' => 'pass'])
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
					<p class="block-title center">{{ trans('general.change_pass') }}</p>
					<div class="card">
						<div class="card-content">
							<form action="{{ route('profile.edit.pass.post') }}" method="post">
								<div class="row">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.old_pass') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="password" type="password" value="" id="password" placeholder="{{ trans('general.enter_old_pass') }}"/>
									</div>
								</div>
								<div class="row">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.new_pass') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="new_password" type="password" value="" id="new_password" placeholder="{{ trans('general.enter_new_pass') }}"/>
									</div>
								</div>
								<div class="row">
									<div class="col m3 s12 input-field">
										<p>{{ trans('general.confirm_pass') }}:</p>
									</div>
									<div class="col m9 s12 input-field">
										<input name="new_password_confirmation" type="password" value="" id="new_password_confirmation" placeholder="{{ trans('general.enter_your_pass_confirmation') }}"/>
									</div>
								</div>
								<div class="row center"><button name="submitEditPass" value="submit" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.update_pass') }}</button></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')

@endsection
