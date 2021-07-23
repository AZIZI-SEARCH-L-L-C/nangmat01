@extends('layouts.page')

@section('content')
	<link type="text/css" rel="stylesheet" href="{{ Asset('assets/plugins/wikipedia/wikipedia.css') }}?v={{ $assets_v }}"  media="screen,projection"/>
	<div class="row">
		<div class="row">
			<div class="container">
				@if(Session::has('message'))
					<div class="col l12"><div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div></div>
				@endif
				<div class="col s12">
					<div class="card">
						<div class="card-content ase-wiki-content">
							<h1>{{ $title }} <span class="wiki-page-info">{{ trans('wikipedia-plugin.source', ['slug' => $slug]) }}</span></h1>
							{!! $content !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection