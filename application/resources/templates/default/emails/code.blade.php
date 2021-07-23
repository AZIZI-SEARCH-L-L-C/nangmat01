@extends('emails.template')

@section('content')
    <p style="{{ $style['paragraph'] }}">
        {{ trans('email.ver_code') }}: {{ $code }}
    </p>

    <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="#"
                   style="{{ $fontFamily }} {{ $style['button'] }} {{ $style['button--blue'] }}"
                   class="button"
                   target="_blank">
                    {{ $code }}
                </a>
            </td>
        </tr>
    </table>

    <p style="{{ $style['paragraph'] }}">
        {{ trans('email.thanks') }}
    </p>
@endsection