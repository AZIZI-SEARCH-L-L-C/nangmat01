@extends('pageLayout')

@section('title', trans('general.ads_campaigns') . ' - ')

@section('content')
	<div class="row form_page">
		<div class="row">
			<div class="container">
				<div class="col m3 s12 left-side">
					@include('inc.leftMenu', ['activeItem' => 'compains'])
				</div>
				<div class="col m9 s12">
					@if ($errors->any())
						@foreach ($errors->all() as $error)
							<div class="card-panel red lighten-2">{{ $error }}</div>
						@endforeach
					@endif
					@if(Session::has('message'))
						<div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
					@endif
					<div class="row">
						<div class="col s12 bottommargin">
							<a href="#newCompain" id="newCompain" class="waves-effect btn_form_page modal-trigger">{{ trans('general.new_campaign') }}</a>
						</div>
						<div class="block col s12">
							<p class="block-title">{{ trans('general.ads_campaigns') }}</p>
							<div class="card">
								<div class="card-content center" style="padding: 10px 0 0 0;">
									@if(! $compains->isEmpty())
										<table class="responsive-table highlight bordered">
											<thead>
											<tr>
												<th>{{ trans('general.my_campaigns') }}</th>
												<th>{{ trans('general.ads') }}</th>
												<th>{{ trans('general.ad_impressions') }}</th>
												<th>{{ trans('general.ad_clicks') }}</th>
												<th>{{ trans('general.ad_ctr') }}</th>
												<th>{{ trans('general.ad_spent') }}</th>
												<th></th>
											</tr>
											</thead>

											<tbody>
											@foreach($compains as $compain)
												<tr>
													<td>{{ $compain->name }}</td>
													<td>{{ $compain->ads->count() }}</td>
													<td>{{ $compain->ads->sum('impressions') }}</td>
													<td>{{ $compain->ads->sum('clicks') }}</td>
													<td>{{ number_format(($compain->ads->sum('clicks') / ($compain->ads->sum('impressions')+1) ) * 100, 2) }}</td>
													<td>{{ $compain->ads->sum('paid') }}$</td>
													<td class="right">
													<!--a target="_blank" href="{{ route('ads.payments.receipt.id', ['id' => $compain->id]) }}">Edit</a> | -->
														<a href="{{ route('ads.compains.ads', ['id' => $compain->id]) }}">{{ trans('general.manage_ads') }}</a>
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>

										{{ $compains->links() }}
									@else
										<p style="margin:20px 0;">{{ trans('general.no_campaigns') }}</p>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Structure -->
	<div id="newCompain" class="modal modal-fixed-footer-">
		<form action="{{ URL::action('AdsController@postCreateCompain') }}" method="post" class="col s12">
			<div class="modal-content">
				<h4>{{ trans('general.new_campaign') }}</h4>
				<div class="row">
					<div class="row">
						<div class="input-field col s12">
							<input name="compainName" id="reported_link" type="text">
							<label for="reported_link">{{ trans('general.campaign_name') }}</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="right waves-effect waves-light btn" type="submit">{{ trans('general.submit') }}</button>
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('general.close') }}</a>
			</div>
		</form>
	</div>
@endsection
