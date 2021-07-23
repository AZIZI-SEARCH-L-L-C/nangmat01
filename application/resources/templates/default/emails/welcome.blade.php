@extends('emails.template')

@section('content')
    <?php
		$actionUrl = route('login');
		$actionText = trans('email.login_to', ['name' => $settings['siteName']]);
		$actionColor = 'button--blue';
	?>
	<p style="{{ $style['paragraph'] }}">
		{{ trans('email.thanks_account', ['name' => $settings['siteName']]) }}
	</p>
	<p style="{{ $style['paragraph'] }}">
		{{ trans('email.login_with_email') }}: {{ $email }}
	</p>
	
	<table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<a href="{{ $actionUrl }}"
					style="{{ $fontFamily }} {{ $style['button'] }} {{ $style[$actionColor] }}"
					class="button"
					target="_blank">
					{{ $actionText }}
				</a>
			</td>
		</tr>
	</table>
@endsection

@section('secondContent')
	<table style="{{ $style['body_sub'] }}">
		<tr>
			<td style="{{ $fontFamily }}">
				<p style="{{ $style['paragraph-sub'] }}">
					{{ trans('email.no_button_click', ['action' => $actionText]) }}
				</p>

				<p style="{{ $style['paragraph-sub'] }}">
					<a style="{{ $style['anchor'] }}" href="{{ $actionUrl }}" target="_blank">
						{{ $actionUrl }}
					</a>
				</p>
			</td>
		</tr>
	</table>
@endsection