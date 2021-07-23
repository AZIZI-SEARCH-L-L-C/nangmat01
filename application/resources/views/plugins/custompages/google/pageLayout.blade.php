@extends('pageLayout')

@section('pagetitle', $title)

@section('content')
	<div class="row last">
		<div class="container">
			{!! $content !!}
		</div>
	</div>
@endsection