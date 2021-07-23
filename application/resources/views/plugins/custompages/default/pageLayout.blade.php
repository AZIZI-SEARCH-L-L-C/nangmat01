@extends('pageLayout')

@section('content')
	<div class="col s12"><div class="card"><div class="card-content">
		<h3>{{ $title }}</h3>
		{!! $content !!}
	</div></div></div>
@endsection