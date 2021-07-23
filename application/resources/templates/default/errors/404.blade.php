<!DOCTYPE html>
  <html>

@include('inc.head')
	
<body>

@yield('content')

<div class="page grey lighten-3">

@include('inc.nav')


<div class="row">	

<div class="front-paper">
<div class="raw">
<!--<img class="responsive-img home-logo" width="544" height="184" src="images/logo.png">-->
<form action="{{ URL::action($action) }}" method="get" class="search-form" id="search-form">
	      <div class="search-wrapper card">
            <input id="search" class="search" autocomplete="off" name="q" autofocus onfocus="this.value = this.value;" value="{{ $query }}" required>
			<ul id="suggetions" class="suggetions collection"></ul>
			<i id="speach-btn" class="voice jaafar jaafar-24px">mic_none</i>
			<button type="submit"><i class="jaafar jaafar-24px">search</i></button>
          </div>
</form>
</div>
</div>	

<div class="row hide-on-med-and-down">
      <ul id="links" class="tabs">
	  @foreach(array_slice($engines, 0, 10) as $Cengine)
		  <li class="tab"><a @if($Cengine['name'] == $engine) class="active" @endif href="{{ URL::action($Cengine['controller'].'@search', ['q' => $query]) }}">{{ $Cengine['name'] }}</a></li>
      @endforeach
      </ul>
</div>
</div>

<div class="row">	
   <div class="row">
    <div class="container">
	    <div class="col l12 text-center"><div class="card"><div class="card-content">

      <!--   Icon Section   -->
      <div class="row">
          <div class="icon-block">
            <h1 class="center light-blue-text"><i style="font-size: 15rem;">404</i></h1>
            <h5 class="center">{{ trans('general.error_404_text') }}</h5>
          </div>
      </div>

    </div>
    </div>
		
		</div>

	</div>
	</div>
   </div>
		
		 @include('inc.footer')
</div>

	
<script>
var keywordsSuggestion = {{ $settings['keywordsSuggestion'] }};
var resultsPage = false;
</script>

    </body>
  </html>