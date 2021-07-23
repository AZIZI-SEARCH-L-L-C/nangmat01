@extends('pageLayout')

@section('title', 'Advertise with us - ')

@section('content')
<style>
#packages{
	flex-wrap: wrap;
    display: flex;
}
#packages .package{
	flex: 1;
	display: flex;
	margin-right: 10px;
}
#packages .package .card .material-icons{
	font-size: 10px;
}
</style>
<div class="row">	
   <div class="row">
    <div class="container">
	@if(Session::has('message'))
	    <div class="col l12"><div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div></div>
	@endif
	
	    <div class="col l12"><div class="card"><div class="card-content">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">filter_center_focus</i></h2>
            <h5 class="center">{{ trans('general.advertise_promote') }}</h5>

            <p class="light">
			    <ol>
				    <li>{{ trans('general.advertise_promote_li1') }}</li>
				    <li>{{ trans('general.advertise_promote_li2') }}</li>
				    <li>{{ trans('general.advertise_promote_li3') }}</li>
				</ol>
			</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">supervisor_account</i></h2>
            <h5 class="center">{{ trans('general.advertise_engage') }}</h5>

            <p class="light">
			     <ol>
				    <li>{{ trans('general.advertise_engage_li1') }}</li>
				    <li>{{ trans('general.advertise_engage_li2') }}</li>
				    <li>{{ trans('general.advertise_engage_li3') }}</li>
				</ol>
			</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="large jaafar">money_off</i></h2>
            <h5 class="center">{{ trans('general.advertise_manage') }}</h5>

            <p class="light">
			     <ol>
				    <li>{{ trans('general.advertise_manage_li1') }}.</li>
				    <li>{{ trans('general.advertise_manage_li2') }}.</li>
				    <li>{{ trans('general.advertise_manage_li3') }}.</li>
				</ol>
			</p>
          </div>
        </div>
      </div>

    </div>
    </div>
		
		</div>
		
		<div class="col l12">
		
		     <ul class="collapsible popout-" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><i class="material-icons">help</i>{{ trans('general.advertise_question1') }}</div>
      <div class="collapsible-body"><p>{{ trans('general.advertise_answer1') }}</p></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">help</i>{{ trans('general.advertise_question2') }}</div>
      <div class="collapsible-body"><p>{{ trans('general.advertise_answer2') }}</p></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">help</i>{{ trans('general.advertise_question3') }}</div>
      <div class="collapsible-body"><p>{{ trans('general.advertise_answer3') }}</p></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">help</i>{{ trans('general.advertise_question4') }}</div>
      <div class="collapsible-body"><p>{{ trans('general.advertise_answer4') }}</p></div>
    </li>
  </ul>
  
		</div>
		
		
		<div class="col s12"><div class="card"><div class="card-content">

			  <!--   Icon Section   -->
			  <div class="row">
				<div class="col s12 m4">
				  <div class="icon-block">
					<h2 class="center light-blue-text"><i class="large">1</i></h2>
					<h5 class="center">{{ trans('general.advertise_step1') }}</h5>

					<p class="light">
						{{ trans('general.advertise_step1_block') }}
					</p>
				  </div>
				</div>

				<div class="col s12 m4">
				  <div class="icon-block">
					<h2 class="center light-blue-text"><i class="large">2</i></h2>
					<h5 class="center">{{ trans('general.advertise_step2') }}</h5>

					<p class="light">
						 {{ trans('general.advertise_step2_block') }}
					</p>
				  </div>
				</div>

				<div class="col s12 m4">
				  <div class="icon-block">
					<h2 class="center light-blue-text"><i class="large">3</i></h2>
					<h5 class="center">{{ trans('general.advertise_step3') }}</h5>

					<p class="light">
						 {{ trans('general.advertise_step3_block') }}
					</p>
				  </div>
				</div>
			  </div>

                    <div class="row center"><a href="{{ route('ads.compains') }}" class="waves-effect btn modal-trigger">{{ trans('general.start_ad_now') }}</a></div>
		</div></div></div>
		
	</div>
	</div>
</div>

<!-- Modal Structure -->
  <div id="advertiseModel" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>{{ trans('general.adver_with_us') }}</h4>
      
	<div class="row">
    <form action="{{ URL::action('GeneralController@postAdvertise') }}" method="post" class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input name="name" id="reported_link" type="text">
          <label for="reported_link">{{ trans('general.full_name') }}</label>
        </div>
       </div>
	   <div class="row">
        <div class="input-field col s12">
          <input name="email" id="reported_link" type="email">
          <label for="reported_link">{{ trans('general.email_address') }}</label>
        </div>
	   </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea id="textarea" name="message" class="materialize-textarea" length="500"></textarea>
          <label for="textarea">{{ trans('general.extra_details') }}</label>
        </div>
      </div>
	  <div class="row">
	    <p class="left">{{ trans('general.form_message') }}</p>
        <button class="right waves-effect waves-light btn" type="submit">{{ trans('general.submit') }}</button>
      </div>
    </form>
   </div>
  </div>
    
	<div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('general.close') }}</a>
    </div>
 </div>
@endsection