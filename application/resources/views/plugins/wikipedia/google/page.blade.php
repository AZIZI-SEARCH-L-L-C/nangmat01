@extends('layouts.page')

@section('pagetitle', $title)

@section('content')
	<link type="text/css" rel="stylesheet" href="{{ Asset('assets/plugins/wikipedia/wikipedia.css') }}?v={{ $assets_v }}"  media="screen,projection"/>
	<div class="row last">
		<div class="container">
			<div class="card-content ase-wiki-content">
				{!! $content !!}
			</div>
		</div>
	</div>
@endsection