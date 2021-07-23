<head>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/templates/' . Config::get('app.template') . '/css/style-'. LaravelLocalization::getCurrentLocaleDirection() .'.css') }}"  media="screen,projection"/>
	@yield('css')

    @if(Auth::check())
        @if(Auth::user()->getSearchReference('darkMode'))
            <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/templates/default/css/dark.css') }}"  media="screen,projection"/>
        @endif
    @else
        @if(Session::has('darkMode'))
            @if(Session::get('darkMode'))
                <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/templates/default/css/dark.css') }}"  media="screen,projection"/>
            @endif
        @else
            @if($settings['darkMode'])
                <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/templates/default/css/dark.css') }}"  media="screen,projection"/>
            @endif
        @endif
    @endif
	  
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="{{ $settings['siteDescription'] }}"/>
	  
	<title>@yield('title') {{ $settings['siteName'] }}</title>
</head>