<nav>
<style>
.engine-item{
	padding: 0 10px;
	font-size: 17px;
}
#nav-mobile li:hover a.item, #nav-mobile li a.item.actv{
	color: #fff !important;
	font-weight: 700;
}

#engines-dropdown li a.actv{
	background: #eee !important;
}
</style>
  <div class="nav-wrapper"style="border:0;">
	<div class="container">
		@if($logoType == 1)
	    	<img src="{{ url($logo) }}" alt="{{ $settings['siteName'] }}" height="44" width="120" class="brand-logo"/>
		@else
			<a href="{{ URL::asset('/') }}" class="brand-logo">{{ $logo }}</a>
		@endif

	  <ul id="nav-mobile" class="right hide-on-med-and-down">
		
		@foreach(array_slice($engines, 0, 2) as $Cengine)
			 <li><a class="item @if($boldActMenu && $Cengine['slug'] == $engine) actv @endif" href="{{ URL::action($Cengine['controller'].'@search', ['q' => $query]) }}">{{ trans('engines.'.$Cengine['slug']) }}</a></li>
		@endforeach
		@if(array_slice($engines, 2))
			<li><a class="item dropdown-button engine-item @if($boldActMenu && in_array($engine, array_slice($enginesNames, 2))) actv @endif" data-activates='engines-dropdown' data-beloworigin="true" data-constrainwidth="false" href="#">@if(in_array($engine, array_slice($enginesNames, 2))) {{ $engine }} @else {{ trans('general.more') }} @endif<i class="jaafar right">arrow_drop_down</i></a></li>
		@endif
		<!--li style="border-right:1px #fff solid;"><a class="item dropdown-button engine-item" data-activates='settings-dropdown' data-beloworigin="true" data-constrainwidth="false" href="#"><i class="jaafar">settings</i><i class="jaafar right">arrow_drop_down</i></a></li-->
		
		<li><a class="item" href="{{ route('preferences') }}"><i class="jaafar">settings</i></a></li>
		
		@if($settings['chooseLanguage']  && count(LaravelLocalization::getSupportedLocales()) > 1) <li><a class="item dropdown-button" data-activates='languages-dropdown' data-beloworigin="true" data-constrainwidth="false" href="#"><i class="jaafar">g_translate</i></a></li> @endif
		@if($settings['usersLogin']) <li><a class="item dropdown-button" data-activates='users-dropdown' data-beloworigin="true" data-constrainwidth="false" href="#"><i class="jaafar">people</i></a></li> @endif
		
	  </ul>
    </div>
  </div>
 
<div class="button-collapse fixed-action-btn" >
<a id="show-menu" data-activates="slide-out" class="btn-floating white"><i class="jaafar blue-text">menu</i></a>
</div>
<div class="side-nav" id="slide-out">
    <ul>
		@if(Auth::check())
			<li><a href="{{ route('profile.edit.info') }}">{{ trans('general.profile') }}</a></li>
			<li><a href="{{ route('profile.bookmarks') }}">{{ trans('general.bookmarks') }}</a></li>
			@if(Auth::user()->isAdmin())<li><a href="{{ route('admin.home') }}">{{ trans('general.admin') }}</a></li>@endif
			<li class="divider"></li>
			<li><a href="{{ route('logout') }}">{{ trans('general.logout') }}</a></li>
		@else
			<li><a href="{{ route('login') }}">{{ trans('general.login') }}</a></li>
			<li><a href="{{ route('register') }}">{{ trans('general.register') }}</a></li>
		@endif
		<li class="divider"></li>
		@foreach($engines as $Cengine)
			<li><a href="{{ URL::action($Cengine['controller'].'@search', ['q' => $query]) }}">{{ trans('engines.'.$Cengine['name']) }}</a></li>
		@endforeach
    </ul>
</div>
@if(array_slice($engines, 2))
  <ul id='engines-dropdown' class='dropdown-content'>
    @foreach(array_slice($engines, 2) as $Cengine)
      <li><a @if($engine == $Cengine['name']) class="actv" @endif href="{{ URL::action($Cengine['controller'].'@search', ['q' => $query]) }}">{{ trans('engines.'.$Cengine['name']) }}</a></li>
    @endforeach
  </ul>
@endif
 
<?php /*
  <!-- Dropdown settings Structure -->
  <ul id='settings-dropdown' class='dropdown-content'>
    <li><a href="{{ action('GeneralController@Settings') }}">Preferences</a></li>
    <li><a href="{{ action('GeneralController@AdvancedSearch') }}">Advanced search</a></li>
  </ul> */
?>
  
  <ul id='users-dropdown' class='dropdown-content'>
    @if(Auth::check())
		<li><a href="{{ route('profile.edit.info') }}">{{ trans('general.profile') }}</a></li>
		<li><a href="{{ route('profile.bookmarks') }}">{{ trans('general.bookmarks') }}</a></li>
		@if(Auth::user()->isAdmin())<li><a href="{{ route('admin.home') }}">{{ trans('general.admin') }}</a></li>@endif
		<li class="divider"></li>
		<li><a href="{{ route('logout') }}">{{ trans('general.logout') }}</a></li>
	@else
		<li><a href="{{ route('login') }}">{{ trans('general.login') }}</a></li>
		<li><a href="{{ route('register') }}">{{ trans('general.register') }}</a></li>
	@endif
  </ul>
  
  @if($settings['chooseLanguage'] && count(LaravelLocalization::getSupportedLocales()) > 1)
  <ul id='languages-dropdown' class='dropdown-content'>
  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <li><a hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">{{ $properties['native'] }}</a></li>
  @endforeach
  </ul>
  @endif
  
</nav>


<!--style>
.form-search{
	position: relative;
}

.form-search .form-input{
	background: #fff;
    border: 1px solid #d9d9d9;
	height: 40px;
	border-right: 0;
	transition: unset;
}

.form-search input[type=text].form-input:focus + .voice{
	border: 1px solid #0088cc !important;
	border-left:0 !important;
	box-shadow: none !important;
}
.form-search input[type=text].form-input:focus + .form-button{
	border: 1px solid #0088cc !important;
	border-left:0 !important;
	box-shadow: none !important;
}
.form-search input[type=text].form-input:focus{
	border: 1px solid #0088cc !important;
	border-right:0 !important;
    box-shadow: none !important;
}

.form-search .form-button{
	height: 40px;
	border-left: 0;
}
.form-search .voice{
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAACrElEQVR42u2Xz2sTQRSAX8VSb1K8iNqKooJH2Ux6Ksn+iPQqxZMIehJB0do/IMhmQWsvHr2KSEGk0tSLIoWIYNUKij20F2/N7iaUZnYT0kYzzhMKs0HDJiTdLcwHDwKZSd63781LBiQSSW9JZdkhzfKm1Rz9mjZp/W9YdEU3vXv4HsQZ40FtNG36q5rls//Ej4tmbSS2T15Mvp3ExOPmEMQNbBtMMEyoljcFcQN7PqyAlqNfIG7gYQ0tYNIaxA1MrJPY3wImbUqBKAXSFv0tBSIVMOkvKRDtGKWN/T6FdqRAxFNoWwpEPIXqUqBT6ALU/UVgu8GW4GD3f6f9TRDYNJTDrk7YbtiqUumHwIYoUJuHERDAS0r4CvgFECgbY+cFAR7KT+g1POmCKFDNw6WggHc3fBtVb4CAoyauBgXIG+g1Xh5mRAGah6cggBd11fK/h7lOprIs0H6uRl6KAo5O7kOv4QmPiwJ4Jqqv4FiwCtXjvD2+tRmfK6kZ/ygI2HritK0rDVGgrClJ6DWMwYC/AGuCBMYcIC2V0CzvjmbRz3j3xUjn6CfeYreUJ2wQkGD75INPX1mFfsEFrrcIYCvdhC4paWQakxajpJMr0C9YFg54i7AsClRmh9/xnr0NHcInzZStk2aLwAcGMAD9pPIazvFKVDD5rdnhJeHLX5RTyRPQHpz5o66emMc9wdlPtvA8wF7Aq2BUHh1525qEo5JtR1WeOXpickO9cJIpyuD6xJmhYiZ5ytWSl3mlnuOaf+2zDaLDXmJrSgZ/MYVEugo+gSh+FkSBa4yd5Ul87DZ5XpFl/AyIEjzYjkau8WqshU2cr13HPbgX4gJOD97n465GZlyVvC9mSKloKI2iTnbwNT+gBX54H+IaXAtxJzE3ycSAFqSAFJACUkAikXD+AHj5/wx2o5osAAAAAElFTkSuQmCC) no-repeat center;
	background-color: #fff;
    background-size: 24px 24px;
	
	height: 40px;
	width: 40px;
	padding: 8px 5px;
    text-align: center;
	border-left: 0;
}
.form-search .voice:hover{
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAACrElEQVR42u2Xz2sTQRSAX8VSb1K8iNqKooJH2Ux6Ksn+iPQqxZMIehJB0do/IMhmQWsvHr2KSEGk0tSLIoWIYNUKij20F2/N7iaUZnYT0kYzzhMKs0HDJiTdLcwHDwKZSd63781LBiQSSW9JZdkhzfKm1Rz9mjZp/W9YdEU3vXv4HsQZ40FtNG36q5rls//Ej4tmbSS2T15Mvp3ExOPmEMQNbBtMMEyoljcFcQN7PqyAlqNfIG7gYQ0tYNIaxA1MrJPY3wImbUqBKAXSFv0tBSIVMOkvKRDtGKWN/T6FdqRAxFNoWwpEPIXqUqBT6ALU/UVgu8GW4GD3f6f9TRDYNJTDrk7YbtiqUumHwIYoUJuHERDAS0r4CvgFECgbY+cFAR7KT+g1POmCKFDNw6WggHc3fBtVb4CAoyauBgXIG+g1Xh5mRAGah6cggBd11fK/h7lOprIs0H6uRl6KAo5O7kOv4QmPiwJ4Jqqv4FiwCtXjvD2+tRmfK6kZ/ygI2HritK0rDVGgrClJ6DWMwYC/AGuCBMYcIC2V0CzvjmbRz3j3xUjn6CfeYreUJ2wQkGD75INPX1mFfsEFrrcIYCvdhC4paWQakxajpJMr0C9YFg54i7AsClRmh9/xnr0NHcInzZStk2aLwAcGMAD9pPIazvFKVDD5rdnhJeHLX5RTyRPQHpz5o66emMc9wdlPtvA8wF7Aq2BUHh1525qEo5JtR1WeOXpickO9cJIpyuD6xJmhYiZ5ytWSl3mlnuOaf+2zDaLDXmJrSgZ/MYVEugo+gSh+FkSBa4yd5Ul87DZ5XpFl/AyIEjzYjkau8WqshU2cr13HPbgX4gJOD97n465GZlyVvC9mSKloKI2iTnbwNT+gBX54H+IaXAtxJzE3ycSAFqSAFJACUkAikXD+AHj5/wx2o5osAAAAAElFTkSuQmCC) no-repeat center;
	background-size: 24px 24px;
}
.form-search .voice:hover{
	cursor:pointer;
}
.acp_ltr{
	margin-top: 40px !important;
}

.card{
	box-shadow:none;
	border: 1px solid #d9d9d9;
	margin-bottom: 2px;
}

/*   new design --------------------  */
nav{
	height: 60px;
    line-height: 60px;
	/* background-color: #f1f1f1; */
	background-color: #d1d1d1;
    border:0; 
	box-shadow: none;
}
nav .nav-wrapper i {
	height: 60px;
    line-height: 60px;
}
nav a{
	color: #777;
}
#nav-mobile li a.item.actv{
	color: #777 !important;
}
#nav-mobile li a.item:hover{
	color: #777 !important;
}
nav ul a{
	color: #777;
}
nav .nav-wrapper {
	color: #777;
	border:0;
}
nav .brand-logo{
	margin: 8px 10px;
}

</style>
<div class="row" style="margin: 20px 0 10px 0;">
	<div class="container">
		<div class="col l9 s12 form-container">
			<form method="get" action="{{ URL::action($action) }}" class="form-search" id="search-form">
				<input id="search" class="col m9 s7 form-input" type="text" name="q" value="{{ $query }}"/>
				@if($settings['speachInput']) <i id="speach-btn" class="col m1 s2 voice btn_form_page"></i> @endif
				<button class="col m2 s3 form-button btn_form_page">Search</button>
				@if($settings['keepFilters'])
					@foreach(array_except($urlParams, ['q', 'p']) as $Cname => $Cvalue)
						<input type="hidden" name="{{ $Cname }}" value="{{ $Cvalue }}">
					@endforeach
				@endif
			</form>
		</div>
	</div>
</div-->



