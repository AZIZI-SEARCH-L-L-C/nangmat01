@extends('pageLayout')

@section('title', trans('general.ads') . ' - '.$compain->name.' - ')

@section('css')
<link href="{{ asset('assets/templates/default/css/tip-yellowsimple.css') }}" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="row form_page">
    <div class="row">
		<div class="container">
			<!--div class="col m3 s12 left-side">
				@include('inc.leftMenu', ['activeItem' => 'compains'])
			</div-->
			<div class="col s12">
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
						<a href="{{ route('ads.compains') }}" class="waves-effect btn_form_page modal-trigger"><i class="material-icons tiny">navigate_before</i> {{ trans('general.back') }}</a>
						<a href="{{ route('ads.new', ['compain' => $compain->id]) }}" class="waves-effect btn_form_page modal-trigger"><i class="material-icons tiny">add</i> {{ trans('general.create_an_ad') }}</a>
					</div>
					<div class="block col s12">
						<p class="block-title">{{ $compain->name }}: {{ trans('general.ads') }}</p>
						<div class="card">
							<div class="card-content center" style="padding: 10px 0 0 0;">
								@if(! $ads->isEmpty())
									<table class="responsive-table highlight bordered">
										<thead>
										    <tr>
												<th>{{ trans('general.ad_unit_name') }}</th>
												<th>{{ trans('general.ad_cost') }}</th>
												<th>{{ trans('general.ad_impressions') }}</th>
												<th>{{ trans('general.ad_clicks') }}</th>
												<th>{{ trans('general.ad_ctr') }}</th>
												<th>{{ trans('general.ad_spent') }}</th>
												<th>{{ trans('general.ad_budget') }}</th>
												<th>{{ trans('general.ad_statu') }}</th>
											    <th></th>
										    </tr>
										</thead>

										<tbody>
											@foreach($ads as $ad)
												<tr>
													<td>{{ $ad->name }}</td>
													<td>{{ $ad->costPer }}
														@if($ad->type == 0)
															({{ trans('general.per_click') }})
														@elseif($ad->type == 1)
															({{ trans('general.per_impression') }})
														@elseif($ad->type == 2)
															({{ trans('general.per_day') }})
														@endif
													</td>
													<td>{{ $ad->impressions }}</td>
													<td>{{ $ad->clicks }}</td>
													<td>{{ number_format(($ad->clicks / ($ad->impressions + 1) ) * 100, 2) }}%</td>
													<td>{{ $ad->paid }}$</td>
													<td>
													@if($ad->useBudget)
														<a href="#" class="editable editable-click" 
															@if($ad->type == 2)
																data-disabled="true"
															@endif
														data-placement="bottom" data-emptytext="enter your budget" data-pk="{{ $ad->id }}" data-name="budget" id="budget" data-send="always" data-type="text" data-url="{{ route('ajax.ads.ad.editOne', ['id' => $compain->id, 'adId' => $ad->id]) }}" data-title="Edit budget ({{ $user->credit }}$ available)">
															{{ $ad->budget }}
														</a>
													@else
														{{ trans('general.unlimited') }}
													@endif
													</td>
													<td class="
													@if($ad->approved == 0 or $ad->approved == 2)
														red-text
													@elseif(( ($ad->paid + $ad->costPer) > $ad->budget) && ($ad->budget > 0))
														green-text
													@endif">
													@if($ad->approved == 0)
														{{ trans('general.approval_pending') }}
													@elseif($ad->approved == 2)
														<a class="red-text" href="{{ route('ads.compains.ad.pay', ['compain' => $compain->id, 'ad' => $ad->id]) }}">{{ trans('general.make_payment') }}</a>
													@elseif(( ($ad->paid + $ad->costPer) > $ad->budget) && ($ad->budget > 0))
														{{ trans('general.completed') }}
													@else
														<div class="switch">
															<label>
																<input name="active" id="statu-{{ $ad->id }}" onchange="toggelActiveAd({{ $ad->id }}, {{ $compain->id }})" type="checkbox" @if($ad->turn && $ad->approved) checked @endif>
																<span class="lever"></span>
															</label>
														</div>
													@endif
													</td>
													<td class="right">
														@if(!(( ($ad->paid + $ad->costPer) > $ad->budget) && ($ad->budget > 0)))
															<a href="{{ route('ads.compains.ad.edit', ['compainId' => $compain->id, 'slug' => $ad->slug]) }}">{{ trans('general.edit') }}</a>
														@endif
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									
									{{ $ads->links() }}
								@else
									<p style="margin:20px 0;">{{ trans('general.no_ads') }}</p>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.toast .toast-action {
  color: #eeff41;
  font-weight: 500;
  margin-left: 20px;
  display: inline-block;
}
</style>
@endsection

@section('javascript')
<script src="{{ asset('assets/templates/default/js/jquery.poshytip.js') }}"></script>
<script src="{{ asset('assets/templates/default/js/jquery-editable-poshytip.js') }}"></script>
<script>
$('.editable').editable({
	display: function(value) {
      $(this).text(value + '$');
    },
	error: function(response, newValue) {
		if(response.status === 511) {
			var $toastContent = $('<span>{{ trans('general.balance_insufficient') }} <a href="{{ route('ads.payments') }}" class="toast-action">{{ trans('general.add_credits') }}</a></span>');
			Materialize.toast($toastContent, 10000);
			return 'please add credit to your acount';
		} else {
			return response.responseText;
		}
	}
});

function toggelActiveAd($id, $compainId){
	$.ajax({
	type: "POST",
		url: '{{ route('ajax.ads.toggelActive.ad') }}',
		data: {compainId: $compainId, id : $id},
		success: function(res){
			var $toastContent = $('<span>' + res + '</span>');
			Materialize.toast($toastContent, 10000);
			$("#statu-" + $id).attr('checked', true);
		}
	}).fail(function(e) {
		var $toastContent = $('<span>'+e.responseText+'</span>');
		Materialize.toast($toastContent, 10000);
		$("#statu-" + $id).attr('checked', false);
	});
}
</script>
@endsection
