@extends('pageLayout')

@section('title', trans('general.payments_ads'). ' - ')

@section('content')
<div class="row form_page">
    <div class="row">
		<div class="container">
			<div class="col m4 s12 left-side">
				@include('inc.leftMenu', ['activeItem' => 'payments'])
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
				<div class="row">
					<div class="block col m6 s12">
						<p class="block-title center">{{ trans('general.payments_your_credits') }}</p>
						<div class="card">
							<div class="card-content center">
								<h3>{{ $user->credit }}$<h3>
							</div>
						</div>
					</div>
					<div class="block col m6 s12">
						<p class="block-title center">{{ trans('general.payments_charge_month') }}</p>
						<div class="card">
							<div class="card-content center">
								<h3>{{ $totalUsage }}$<h3>
							</div>
						</div>
					</div>
				</div>
				@if(Config::get('stripe.enabled', false) == 'true' || Config::get('paypal.enabled', false) == 'true')
				<div class="row">
					<div class="col s12">
						<ul class="tabs tabs-fixed-width">
							@if(Config::get('stripe.enabled', false) == 'true') <li class="tab col s3"><a class="active" href="#credit-card">{{ trans('general.payments_credit_card') }}</a></li> @endif
							@if(Config::get('paypal.enabled', false) == 'true') <li class="tab col s3"><a href="#paypal">{{ trans('general.payments_paypal') }}</a></li> @endif
						</ul>
						@if(Config::get('stripe.enabled', false) == 'true')
						<div id="credit-card" class="col s12 tab-content">
							<div class="card" style="margin:0;">
								<div class="card-content">
									<form action="{{ route('ads.payment.card.post') }}" method="post">
										<div class="row">
											<div class="col s12">
												<p class="slo">{{ trans('general.payments_credit_debit_card') }}</p>
												<p>{{ trans('general.payments_add_credit_from_card') }}</p>
											</div>
										</div>
										@if($sources)
											<table class="responsive-table highlight bordered" style="margin:20px -20px;width:calc(100% + 40px);">
												<thead>
													<tr>
														<th></th>
														<th>{{ trans('general.payments_type') }}</th>
														<th>{{ trans('general.payments_expire') }}</th>
														<th>{{ trans('general.payments_cvc_check') }}</th>
													</tr>
												</thead>

												<tbody>
													@foreach($sources as $source)
														<tr>
															<td><input class="with-gap" name="card" type="radio" value="{{ $source->id }}" id="{{ $source->id }}" @if($source->id == $customer->default_source) checked @endif /><label for="{{ $source->id }}">xxxx-{{ $source->last4 }}</label></td>
															<td>{{ $source->brand }}</td>
															<td>{{ $source->exp_month }}/{{ $source->exp_year }}</td>
															<td>{{ $source->cvc_check }}</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										@else
											<p class="red-text">{{ trans('general.payments_no_credit_card_added') }}</p>
										@endif
										<div class="row">
											<div class="col s12 input-field amount-field">
												<select name="amount" class="browser-default amount">
													@if(! $payments->isEmpty())
														@foreach($payments as $payment)
															@if($payment->total > 0)	
																<option value="{{ $payment->total }}">{{ $payment->total }}$ ({{ trans('general.payments_from_payment_history') }})</option>
															@endif
														@endforeach
													@endif
													<option value="custom">{{ trans('general.payments_custom_amount') }}</option>
												</select>
											</div>
											<div class="col m6 s12 input-field custom-amount-field" style="display:none;">
												<input name="customAmount" type="text" placeholder="enter your custom aount"/>
											</div>
										</div>
										<div class="row center"><button name="saveCard" value="Save card" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.payments_add_funds') }}</button></div>
									</form>
								</div>
							</div>
						</div>
						@endif
						@if(Config::get('paypal.enabled', false) == 'true')
						<div id="paypal" class="col s12 tab-content">
							<div class="card" style="margin:0;">
								<div class="card-content">
									<form action="{{ route('ads.payment.paypal.post') }}" id="paypal-form" method="post">
										<div class="row">
											<div class="col s12">
												<p class="slo">{{ trans('general.payments_paypal_payment') }}</p>
												<p>{{ trans('general.payments_add_paypal_credits') }}</p>
											</div>
										</div>
										<div class="row">
											<div class="col s12 input-field amount-field2">
												<select name="amount" class="browser-default amount2">
													@if(! $payments->isEmpty())
														@foreach($payments as $payment)
															@if($payment->total > 0)	
																<option value="{{ $payment->total }}">{{ $payment->total }}$ ({{ trans('general.payments_from_payment_history') }})</option>
															@endif
														@endforeach
													@endif
													<option value="custom">{{ trans('general.payments_custom_amount') }}</option>
												</select>
											</div>
											<div class="col m6 s12 input-field custom-amount-field2" style="display:none;">
												<input name="customAmount" type="text" placeholder="enter your custom aount"/>
											</div>
										</div>
										<div class="row">
											<div class="col s12">
												<p>{{ trans('general.payments_between') }}</p>
											</div>
										</div>
										<div class="row" id="paypal-progress" style="display:none;">
											<div class="progress">
												<div class="indeterminate"></div>
											</div>
										</div>
										<div class="row center topmargin"><button name="submitPaypal" id="submit-paypal" value="Submit" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.payments_paypal') }}</button></div>
									</form>
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
				@endif
				<div class="row">
					<div class="block col s12">
						<p class="block-title">{{ trans('general.payments_add_card') }}</p>
						<div class="card">
							<div class="card-content center">
								<form action="{{ route('ads.payment.card.new.post') }}" id="CardForm" method="post">
									<div class="row">
										<p>{{ trans('general.payments_card_details') }}</p>
										<div class="col m7 s12">
											<input type="text" id="ccNo" autocomplete="off" placeholder="1234 5678 9012 3456" class="empty">
											<input name="token" type="hidden" value="" />
										</div>
										<div class="col m3 s6">
											<input type="text" placeholder="{{ trans('general.payments_expiring_date') }}" id="exp">
										</div>
										<div class="col m2 s6">
											<input type="text" placeholder="{{ trans('general.payments_cvc_code') }}" id="cvc">
										</div>
									</div>
									<div class="row" id="card-progress" style="display:none;">
										<div class="progress">
											<div class="indeterminate"></div>
										</div>
									</div>
									<div class="row center"><button name="saveCard" value="Save card" type="submit" class="waves-effect btn modal-trigger"/>{{ trans('general.payments_save_card') }}</button></div>
								</form>
							</div>
						</div>
					</div>
				</div>
							
				<div class="row">
					<div class="block col s12">
						<p class="block-title">{{ trans('general.payments_tr_history') }}</p>
						<div class="card">
							<div class="card-content center" style="padding: 10px 0 0 0;">
								@if(! $payments->isEmpty())
									<table class="responsive-table highlight bordered">
										<thead>
										    <tr>
											    <th>{{ trans('general.payments_date') }}</th>
											    <th>{{ trans('general.payments_desc') }}</th>
											    <th>{{ trans('general.payments_amount') }}</th>
											    <th></th>
										    </tr>
										</thead>

										<tbody>
											@foreach($payments as $payment)
												<tr>
													<td>{{ get_time_ago($payment->created_at) }}</td>
													<td @if($payment->review) class="red-text" @endif>
														@if($payment->review)
															{{ trans('general.payments_payment_needs_review') }}
														@else
															@if($payment->total > 0)
																{{ trans('general.payments_add_credits') }}
															@else
																@if($payment->ad)
																	{{ trans('general.payments_pay_for') }} {{ $payment->ad->name }}
																@endif
															@endif
														@endif
													</td>
													<td>{{ number_format($payment->total, 2) }}$</td>
													<td class="right">
														@if($payment->total > 0)
															<a target="_blank" href="{{ route('ads.payments.receipt.id', ['id' => $payment->payment_id]) }}">{{ trans('general.payments_view_details') }}</a>
														@endif
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									
									{{ $payments->links() }}
								@else
									<p style="margin:20px 0;">{{ trans('general.payments_no_payments') }}</p>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.12/jquery.mask.js"></script>
<script src="{{ asset('assets/templates/default/js/jquery.creditCardValidator.js') }}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

Stripe.setPublishableKey('{{ config("stripe.public") }}');

@if($billing)
	var tokenRequest = function() {
		Stripe.card.createToken({
			number: $("#ccNo").val(),
			cvc: $("#cvc").val(),
			exp_month: getExp(0),
			exp_year: getExp(1),
			name: '{{ $billing->name }}',
			address_line1: '{{ $billing->addrLine1 }}',
			address_line2: '{{ $billing->addrLine2 }}',
			address_city: '{{ $billing->city }}',
			address_state: '{{ $billing->state }}',
			address_zip: '{{ $billing->zipCode }}',
			address_country: '{{ $billing->country }}',
		}, stripeResponseHandler);
	};
@else
	var tokenRequest = function() {
		Stripe.card.createToken({
			number: $("#ccNo").val(),
			cvc: $("#cvc").val(),
			exp_month: getExp(0),
			exp_year: getExp(1),
		}, stripeResponseHandler);
	};
@endif

function getExp($d){
	var date = $("#exp").val().split('/');
	return date[$d];
}

function stripeResponseHandler(status, response) {

    var $form = $('#payment-form');

    if (response.error) { 
		Materialize.toast($('<span>' + response.error.message + '</span>'), 10000);
    } else { 
		var token = response.id;
		$('#card-progress').fadeIn(300);
		var myForm = document.getElementById('CardForm');
		myForm.token.value = token;
		myForm.submit();

  }
}

function showPaypalProgress(){
	$('#paypal-progress').fadeIn(300);
}
  

$(function() {
	$("#CardForm").submit(function(e) {
		tokenRequest();
		return false;
    });
});

$('#ccNo').validateCreditCard(function(result){
	if(!jQuery.isEmptyObject(result.card_type)){
		$(this).addClass(result.card_type.name);
	}else{
		$(this).removeAttr('class');
		$(this).addClass('sm-form-control empty');
	}
});
$('#ccNo').mask('0000 0000 0000 0000', {selectOnFocus: true});
$('#exp').mask('00/00');
$('#cvc').mask('0000');

$('#ccNo').keyup(function(){
	if (this.value.length == this.maxLength) {
		$('#exp').focus();
    }
});
$('#exp').keyup(function(){
	if (this.value.length == this.maxLength) {
		$('#cvc').focus();
    }
});

$( document ).ready(function() {
    amountFunc($(".amount"));
    amountFunc2($(".amount2"));
});

$( ".amount" ).change(function () {
    amountFunc($(".amount"));
});

$( ".amount2" ).change(function () {
    amountFunc2($(".amount2"));
});

function amountFunc($elem){
	if($elem.val() == 'custom'){
		$(".amount-field").addClass('m6');
		$(".custom-amount-field").show();
	}else{
		$(".amount-field").removeClass('m6');
		$(".custom-amount-field").hide();
	}
}

function amountFunc2($elem){
	if($elem.val() == 'custom'){
		$(".amount-field2").addClass('m6');
		$(".custom-amount-field2").show();
	}else{
		$(".amount-field2").removeClass('m6');
		$(".custom-amount-field2").hide();
	}
}

$("#submit-paypal").on("click", function(){
	$('#paypal-progress').fadeIn(300);
	// $("#paypal-progress").show();
});
</script>
@endsection
