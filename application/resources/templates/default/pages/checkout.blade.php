@extends('pageLayout')

@section('content')
<div class="row">	
   <div class="row">
    <div class="container">
	@if(Session::has('message'))
	    <div class="col s12"><div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div></div>
	@endif
	
	<div class="col s12"><div class="card"><div class="card-content">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
		  <p>Review the package:</p>
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">announcement</i></h2>
            <h5 class="center">{{ $package->name }}</h5>
          </div>
        </div>

        <div class="col s12 m8">
            <p class="light">
			    <h1>{{ $package->price }}$</h1>
				@if($package->byBudget)
					<p>@if($package->type == 0) per Clicks @elseif($package->type == 1) per Impressions @elseif($package->type == 2) Pay Day @endif</p>
				@else
					<p>@if($package->type == 0) You get {{ $package->value }} Clicks @elseif($package->type == 1) You get {{ $package->value }} Impressions @elseif($package->type == 2) show ad {{ $package->value }} Days @endif</p>
				@endif <hr/>
				<p>
					<?php $i = 0; ?>
					@foreach(explode(',', $package->shown_in) as $type)
						{{ $type }} @if(++$i != count(explode(',', $package->shown_in))) <i style="font-size: 10px;" class="material-icons">filter_tilt_shift</i> @endif
					@endforeach
				</p><hr/>
				<p>{{ $package->description }}</p>
			</p>
        </div>
      </div>

    </div></div></div>
		
	<div class="col l12">
	  <ul class="collapsible" data-collapsible="accordion">
		<li>
		  <div class="collapsible-header"><i>1</i>{{ trans('general.advertise_question1') }}</div>
		  <div class="collapsible-body"><p>{{ trans('general.advertise_answer1') }}</p></div>
		</li>
		<li>
		  <div class="collapsible-header"><i>2</i>{{ trans('general.advertise_question2') }}</div>
		  <div class="collapsible-body"><p>{{ trans('general.advertise_answer2') }}</p></div>
		</li>
		<li>
		  <div class="collapsible-header"><i>3</i>{{ trans('general.advertise_question3') }}</div>
		  <div class="collapsible-body"><p>{{ trans('general.advertise_answer3') }}</p></div>
		</li>
		<li>
		  <div class="collapsible-header"><i>4</i>{{ trans('general.advertise_question4') }}</div>
		  <div class="collapsible-body"><p>{{ trans('general.advertise_answer4') }}</p></div>
		</li>
	  </ul>
	</div>
		
		
	</div>
	</div>
</div>
@endsection