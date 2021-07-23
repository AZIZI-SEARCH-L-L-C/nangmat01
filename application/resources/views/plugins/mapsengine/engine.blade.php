<!doctype html>
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ url('assets/plugins/mapsengine/css/leaflet.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/plugins/mapsengine/css/searchbox.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/mapsengine/css/leaflet-routing-machine.css') }}" />
    <!--<link rel="stylesheet" href="{{ url('assets/plugins/mapsengine/css/Control.Geocoder.css') }}" />-->

    <style>
        .leaflet-popup{
            display: @if($settings['maps_show_popup']) block @else none @endif;
        }
    </style>
    <script>

        @if($settings['maps_show_alternatives']) var show_alternatives = 1; @else var show_alternatives = 0; @endif
        @if($settings['maps_fit_selected_routes']) var fit_selected_routes = 1; @else var fit_selected_routes = 0; @endif
        @if($settings['maps_auto_route']) var auto_route = 1; @else var auto_route = 0; @endif
        @if($settings['maps_unites_to_use']) var unites_to_use = 'metric'; @else var unites_to_use = 'imperial'; @endif
        @if($settings['maps_routes_search']) var route_search = 1; @else var route_search = 0; @endif
        @if($settings['maps_show_bar']) var showsearchbar = 1; @else var showsearchbar = 0; @endif
        @if($settings['maps_real_time']) var realtime = 1; @else var realtime = 0; @endif
        var route_path_color = '{{ $settings['maps_route_path_color'] }}';
        var point_color = '{{ $settings['maps_point_color'] }}';
        var $access_token = '{{ $settings['maps_access_token'] }}';
        var mapAttrubite = '{!! $settings['maps_footer'] !!}';
        var options1 = {
            timeout: 500,
            blurTimeout: 100,
            noResultsMessage: 'No results found.',
        };

        var options2 = {
            fitSelectedRoutes: fit_selected_routes,
            autoRoute: auto_route,
            routeWhileDragging: false,
            routeDragInterval: 500,
            waypointMode: 'connect',
            showAlternatives: show_alternatives,
            defaultErrorHandler: function(e) {
                console.error(e);
                console.error('Routing error:', e.error);
            }
        };

        var options3 = {
            header: 'Routing error',
            formatMessage: function(error) {
                if (error.status < 0) {
                    return 'Calculating the route caused an error. Technical description follows: <code><pre>' +
                        error.message + '</pre></code>';
                } else {
                    return 'The route could not be calculated. ' +
                        error.message;
                }
            },
            position: 'topleft',
        };

        var options4 = {
            units: unites_to_use,
            unitNames: null,
            language: 'en',
            roundingSensitivity: 1,
            distanceTemplate: '{value} {unit}'
        };

        var options5 = {
            s: 'S',
            n: 'N',
            w: 'W',
            e: 'E',
        };

        var options6 = {
            pointMarkerStyle: {
                radius: 5,
                color: point_color,
                fillColor: point_color,
                opacity: 1,
                fillOpacity: 0.7
            },
            summaryTemplate: '<h2>{name}</h2><h3>{distance}, {time}</h3>',
            timeTemplate: '{time}',
            containerClassName: '',
            alternativeClassName: '',
            minimizedClassName: '',
            itineraryClassName: '',
            totalDistanceRoundingSensitivity: -1,
            show: true,
            collapsible: undefined,
            collapseBtnClass: 'leaflet-routing-collapse-btn'
        };

        var options7 = {
            styles: [
                {color: 'black', opacity: 0.15, weight: 9},
                {color: 'white', opacity: 0.8, weight: 6},
                {color: route_path_color, opacity: 1, weight: 2}
            ],
            missingRouteStyles: [
                {color: 'black', opacity: 0.15, weight: 7},
                {color: 'white', opacity: 0.6, weight: 4},
                {color: 'gray', opacity: 0.8, weight: 2, dashArray: '7,12'}
            ],
            addWaypoints: true,
            extendToWaypoints: true,
            missingRouteTolerance: 10
        };

        var optionEnglish = function(_dereq_,module,exports){
            module.exports= {
                "meta": {
                    "capitalizeFirstLetter": false
                },
                "v5": {"arrive":{"default":{"default":"You have arrived at your {nth} destination","named":"You have arrived at {waypoint_name}","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination"},"left":{"default":"You have arrived at your {nth} destination, on the left","named":"You have arrived at {waypoint_name}, on the left","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, on the left"},"right":{"default":"You have arrived at your {nth} destination, on the right","named":"You have arrived at {waypoint_name}, on the right","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, on the right"},"sharp left":{"default":"You have arrived at your {nth} destination, on the left","named":"You have arrived at {waypoint_name}, on the left","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, on the left"},"sharp right":{"default":"You have arrived at your {nth} destination, on the right","named":"You have arrived at {waypoint_name}, on the right","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, on the right"},"slight left":{"default":"You have arrived at your {nth} destination, on the left","named":"You have arrived at {waypoint_name}, on the left","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, on the left"},"slight right":{"default":"You have arrived at your {nth} destination, on the right","named":"You have arrived at {waypoint_name}, on the right","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, on the right"},"straight":{"default":"You have arrived at your {nth} destination, straight ahead","named":"You have arrived at {waypoint_name}, straight ahead","short":"You have arrived","short-upcoming":"You will arrive","upcoming":"You will arrive at your {nth} destination, straight ahead"}},"constants":{"direction":{"east":"east","north":"north","northeast":"northeast","northwest":"northwest","south":"south","southeast":"southeast","southwest":"southwest","west":"west"},"lanes":{"ox":"Keep left","oxo":"Keep left or right","xo":"Keep right","xox":"Keep in the middle"},"modifier":{"left":"left","right":"right","sharp left":"sharp left","sharp right":"sharp right","slight left":"slight left","slight right":"slight right","straight":"straight","uturn":"U-turn"},"ordinalize":{"1":"1st","10":"10th","2":"2nd","3":"3rd","4":"4th","5":"5th","6":"6th","7":"7th","8":"8th","9":"9th"}},"continue":{"default":{"default":"Turn {modifier}","destination":"Turn {modifier} towards {destination}","exit":"Turn {modifier} onto {way_name}","name":"Turn {modifier} to stay on {way_name}"},"sharp left":{"default":"Make a sharp left","destination":"Make a sharp left towards {destination}","name":"Make a sharp left to stay on {way_name}"},"sharp right":{"default":"Make a sharp right","destination":"Make a sharp right towards {destination}","name":"Make a sharp right to stay on {way_name}"},"slight left":{"default":"Make a slight left","destination":"Make a slight left towards {destination}","name":"Make a slight left to stay on {way_name}"},"slight right":{"default":"Make a slight right","destination":"Make a slight right towards {destination}","name":"Make a slight right to stay on {way_name}"},"straight":{"default":"Continue straight","destination":"Continue towards {destination}","distance":"Continue straight for {distance}","name":"Continue straight to stay on {way_name}","namedistance":"Continue on {way_name} for {distance}"},"uturn":{"default":"Make a U-turn","destination":"Make a U-turn towards {destination}","name":"Make a U-turn and continue on {way_name}"}},"depart":{"default":{"default":"Head {direction}","name":"Head {direction} on {way_name}","namedistance":"Head {direction} on {way_name} for {distance}"}},"end of road":{"default":{"default":"Turn {modifier}","destination":"Turn {modifier} towards {destination}","name":"Turn {modifier} onto {way_name}"},"straight":{"default":"Continue straight","destination":"Continue straight towards {destination}","name":"Continue straight onto {way_name}"},"uturn":{"default":"Make a U-turn at the end of the road","destination":"Make a U-turn towards {destination} at the end of the road","name":"Make a U-turn onto {way_name} at the end of the road"}},"exit rotary":{"default":{"default":"Exit the traffic circle","destination":"Exit the traffic circle towards {destination}","name":"Exit the traffic circle onto {way_name}"}},"exit roundabout":{"default":{"default":"Exit the traffic circle","destination":"Exit the traffic circle towards {destination}","name":"Exit the traffic circle onto {way_name}"}},"fork":{"default":{"default":"Keep {modifier} at the fork","destination":"Keep {modifier} towards {destination}","name":"Keep {modifier} onto {way_name}"},"sharp left":{"default":"Take a sharp left at the fork","destination":"Take a sharp left towards {destination}","name":"Take a sharp left onto {way_name}"},"sharp right":{"default":"Take a sharp right at the fork","destination":"Take a sharp right towards {destination}","name":"Take a sharp right onto {way_name}"},"slight left":{"default":"Keep left at the fork","destination":"Keep left towards {destination}","name":"Keep left onto {way_name}"},"slight right":{"default":"Keep right at the fork","destination":"Keep right towards {destination}","name":"Keep right onto {way_name}"},"uturn":{"default":"Make a U-turn","destination":"Make a U-turn towards {destination}","name":"Make a U-turn onto {way_name}"}},"merge":{"default":{"default":"Merge {modifier}","destination":"Merge {modifier} towards {destination}","name":"Merge {modifier} onto {way_name}"},"sharp left":{"default":"Merge left","destination":"Merge left towards {destination}","name":"Merge left onto {way_name}"},"sharp right":{"default":"Merge right","destination":"Merge right towards {destination}","name":"Merge right onto {way_name}"},"slight left":{"default":"Merge left","destination":"Merge left towards {destination}","name":"Merge left onto {way_name}"},"slight right":{"default":"Merge right","destination":"Merge right towards {destination}","name":"Merge right onto {way_name}"},"straight":{"default":"Merge","destination":"Merge towards {destination}","name":"Merge onto {way_name}"},"uturn":{"default":"Make a U-turn","destination":"Make a U-turn towards {destination}","name":"Make a U-turn onto {way_name}"}},"modes":{"ferry":{"default":"Take the ferry","destination":"Take the ferry towards {destination}","name":"Take the ferry {way_name}"}},"new name":{"default":{"default":"Continue {modifier}","destination":"Continue {modifier} towards {destination}","name":"Continue {modifier} onto {way_name}"},"sharp left":{"default":"Take a sharp left","destination":"Take a sharp left towards {destination}","name":"Take a sharp left onto {way_name}"},"sharp right":{"default":"Take a sharp right","destination":"Take a sharp right towards {destination}","name":"Take a sharp right onto {way_name}"},"slight left":{"default":"Continue slightly left","destination":"Continue slightly left towards {destination}","name":"Continue slightly left onto {way_name}"},"slight right":{"default":"Continue slightly right","destination":"Continue slightly right towards {destination}","name":"Continue slightly right onto {way_name}"},"straight":{"default":"Continue straight","destination":"Continue towards {destination}","name":"Continue onto {way_name}"},"uturn":{"default":"Make a U-turn","destination":"Make a U-turn towards {destination}","name":"Make a U-turn onto {way_name}"}},"notification":{"default":{"default":"Continue {modifier}","destination":"Continue {modifier} towards {destination}","name":"Continue {modifier} onto {way_name}"},"uturn":{"default":"Make a U-turn","destination":"Make a U-turn towards {destination}","name":"Make a U-turn onto {way_name}"}},"off ramp":{"default":{"default":"Take the ramp","destination":"Take the ramp towards {destination}","exit":"Take exit {exit}","exit_destination":"Take exit {exit} towards {destination}","name":"Take the ramp onto {way_name}"},"left":{"default":"Take the ramp on the left","destination":"Take the ramp on the left towards {destination}","exit":"Take exit {exit} on the left","exit_destination":"Take exit {exit} on the left towards {destination}","name":"Take the ramp on the left onto {way_name}"},"right":{"default":"Take the ramp on the right","destination":"Take the ramp on the right towards {destination}","exit":"Take exit {exit} on the right","exit_destination":"Take exit {exit} on the right towards {destination}","name":"Take the ramp on the right onto {way_name}"},"sharp left":{"default":"Take the ramp on the left","destination":"Take the ramp on the left towards {destination}","exit":"Take exit {exit} on the left","exit_destination":"Take exit {exit} on the left towards {destination}","name":"Take the ramp on the left onto {way_name}"},"sharp right":{"default":"Take the ramp on the right","destination":"Take the ramp on the right towards {destination}","exit":"Take exit {exit} on the right","exit_destination":"Take exit {exit} on the right towards {destination}","name":"Take the ramp on the right onto {way_name}"},"slight left":{"default":"Take the ramp on the left","destination":"Take the ramp on the left towards {destination}","exit":"Take exit {exit} on the left","exit_destination":"Take exit {exit} on the left towards {destination}","name":"Take the ramp on the left onto {way_name}"},"slight right":{"default":"Take the ramp on the right","destination":"Take the ramp on the right towards {destination}","exit":"Take exit {exit} on the right","exit_destination":"Take exit {exit} on the right towards {destination}","name":"Take the ramp on the right onto {way_name}"}},"on ramp":{"default":{"default":"Take the ramp","destination":"Take the ramp towards {destination}","name":"Take the ramp onto {way_name}"},"left":{"default":"Take the ramp on the left","destination":"Take the ramp on the left towards {destination}","name":"Take the ramp on the left onto {way_name}"},"right":{"default":"Take the ramp on the right","destination":"Take the ramp on the right towards {destination}","name":"Take the ramp on the right onto {way_name}"},"sharp left":{"default":"Take the ramp on the left","destination":"Take the ramp on the left towards {destination}","name":"Take the ramp on the left onto {way_name}"},"sharp right":{"default":"Take the ramp on the right","destination":"Take the ramp on the right towards {destination}","name":"Take the ramp on the right onto {way_name}"},"slight left":{"default":"Take the ramp on the left","destination":"Take the ramp on the left towards {destination}","name":"Take the ramp on the left onto {way_name}"},"slight right":{"default":"Take the ramp on the right","destination":"Take the ramp on the right towards {destination}","name":"Take the ramp on the right onto {way_name}"}},"phrase":{"exit with number":"exit {exit}","name and ref":"{name} ({ref})","one in distance":"In {distance}, {instruction_one}","two linked":"{instruction_one}, then {instruction_two}","two linked by distance":"{instruction_one}, then, in {distance}, {instruction_two}"},"rotary":{"default":{"default":{"default":"Enter the traffic circle","destination":"Enter the traffic circle and exit towards {destination}","name":"Enter the traffic circle and exit onto {way_name}"},"exit":{"default":"Enter the traffic circle and take the {exit_number} exit","destination":"Enter the traffic circle and take the {exit_number} exit towards {destination}","name":"Enter the traffic circle and take the {exit_number} exit onto {way_name}"},"name_exit":{"default":"Enter {rotary_name} and take the {exit_number} exit","destination":"Enter {rotary_name} and take the {exit_number} exit towards {destination}","name":"Enter {rotary_name} and take the {exit_number} exit onto {way_name}"},"name":{"default":"Enter {rotary_name}","destination":"Enter {rotary_name} and exit towards {destination}","name":"Enter {rotary_name} and exit onto {way_name}"}}},"roundabout turn":{"default":{"default":"Make a {modifier}","destination":"Make a {modifier} towards {destination}","name":"Make a {modifier} onto {way_name}"},"left":{"default":"Turn left","destination":"Turn left towards {destination}","name":"Turn left onto {way_name}"},"right":{"default":"Turn right","destination":"Turn right towards {destination}","name":"Turn right onto {way_name}"},"straight":{"default":"Continue straight","destination":"Continue straight towards {destination}","name":"Continue straight onto {way_name}"}},"roundabout":{"default":{"default":{"default":"Enter the traffic circle","destination":"Enter the traffic circle and exit towards {destination}","name":"Enter the traffic circle and exit onto {way_name}"},"exit":{"default":"Enter the traffic circle and take the {exit_number} exit","destination":"Enter the traffic circle and take the {exit_number} exit towards {destination}","name":"Enter the traffic circle and take the {exit_number} exit onto {way_name}"}}},"turn":{"default":{"default":"Make a {modifier}","destination":"Make a {modifier} towards {destination}","name":"Make a {modifier} onto {way_name}"},"left":{"default":"Turn left","destination":"Turn left towards {destination}","name":"Turn left onto {way_name}"},"right":{"default":"Turn right","destination":"Turn right towards {destination}","name":"Turn right onto {way_name}"},"straight":{"default":"Go straight","destination":"Go straight towards {destination}","name":"Go straight onto {way_name}"}},"use lane":{"default":{"default":"{lane_instruction}"},"no_lanes":{"default":"Continue straight"}}},
            }
        };

    </script>
    <script src="{{ url('assets/plugins/mapsengine/js/leaflet.js') }}"></script>
    <script src="{{ url('assets/plugins/mapsengine/js/leaflet-routing-machine.js') }}"></script>
    <script src="{{ url('assets/plugins/mapsengine/js/Control.Geocoder.js') }}"></script>
    <script src="{{ url('assets/plugins/mapsengine/js/jquery-1.12.1.min.js') }}"></script>
    <script src="{{ url('assets/plugins/mapsengine/js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('assets/plugins/mapsengine/js/searchbox.js') }}"></script>
    <style>
        html, body, #mapid {
            height: 100%;
            width: 100%;
            margin: 0;
        }
        .leaflet-control-geocoder-form{
            display: inline-block;
        }
        #searchboxinput{
            height: 46px;
            margin-top: -11px;
            font-size: 20px;
        }
        .leaflet-control-geocoder {
            display: none;
        }
    </style>
    <title>{{ $query }} - {{ $settings['siteName'] }} </title>
</head>
<body>
<div id="mapid"></div>
<script type="text/javascript">
    var mymap = L.map('mapid').setView([51.505, -0.09], 13);
    var $currentResults = {};
    mymap.zoomControl.setPosition('topright');
    waypoints = [
        // L.latLng(48.8588,2.3469),
        // L.latLng(52.3546,4.9039)
    ];

    geocoder = L.Control.Geocoder['mapbox']($access_token);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: mapAttrubite,
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: $access_token
    }).addTo(mymap);

    if(showsearchbar == 1) {
        AddSearchControl();
    }

    var control = L.Control.geocoder({
        query: '',
        placeholder: 'Search here...',
        position: 'topright',
        geocoder: geocoder
    }).addTo(mymap);

    function AddSearchControl() {
        searchboxControl = createSearchboxControl();
        var Sidecontrol = new searchboxControl({
			@if($logoType)
				sidebarTitleText: '<a href="{{ url('/') }}"><img src="{{ url($logo) }}" style="max-width: 160px;max-height: 22px;"/></a>',
			@else
				sidebarTitleText: '<a href="{{ url('/') }}">{{ $logo }}</a>',
			@endif
            sidebarMenuItems: {
                Items: []
            }
        });
        Sidecontrol._searchfunctionCallBack = function (searchkeywords) {
            searchWithQuery(searchkeywords);
            // if (!searchkeywords) {
            //     searchkeywords = "The search call back is clicked !!"
            // }
            // alert(searchkeywords);
        }
        mymap.addControl(Sidecontrol);
    }

    function removeSearchControl() {
        mymap.removeControl(searchboxControl);
    }
    function button2_click()
    {
        alert('button 2 clicked !!!');
    }

    function addRouter(){
        routerControl = L.Routing.control({
            router: L.routing.mapbox($access_token),
            plan: L.Routing.plan(waypoints,
                {
                geocoder: geocoder,
                draggableWaypoints: auto_route,
                // addWaypoints: true,
                // reverseWaypoints: true,
                // language: 'en',
                // geocodersClassName: '',
                // routeWhileDragging: true,
                // routeDragTimeout: 250,
                // showAlternatives: false,
            }),
            show: true,
            addButtonClassName: '',
            position: 'topleft',
        }).addTo(mymap);

        L.Routing.errorControl(routerControl).addTo(mymap);
    }

    // addRouter();
    // function getSuggestions($query) {
    //     geocoder.suggest($query, function(results){
    //         console.log(results);
    //     })
    // }

    function searchWithQuery($query){
        setInputQuery($query);
        geocoder.suggest($query, function(results){
            if(Object.keys(results).length === 0 && results.constructor === Object){
                return false;
            }
            control._geocodeResultSelected(results[0]);
            control._clearResults();
        });
    }

    $('body').on('input', '#searchboxinput', function() {
        $query = $(this).val();
        geocoder.suggest($query, function(results){
            if(Object.keys(results).length === 0 && results.constructor === Object){
                return false;
            }
            setSuggestions(results);
        });
    });

    function setInputQuery($query) {
        $('#searchboxinput').val($query);
    }

    function setSuggestions(results){
        $currentResults = results;
        $('#searchbox-suggestions-list').empty();
        $.each(results, function (i, v) {
            $name = v.name;
            if(v.properties.text != null){
                $name = v.properties.text;
            }
            $('#searchbox-suggestions-list').append('<li onclick="setLocationFromSuggestions('+i+');return false;"><span class="panel-list-item-icon icon-local-gps"></span>'+$name+'</li>');
        });
    }

    function setLocationFromSuggestions(i){
        $name = $currentResults[i].name;
        if($currentResults[i].properties.text != null){
            $name = $currentResults[i].properties.text;
        }
        setInputQuery($name);
        searchWithQuery($name);
        $('#searchbox-suggestions-list').empty();
    }

    function findARoute() {
        $(".panel").toggle("slide", {
            direction: "left"
        }, 500);
        showRouteControl();
    }

    function hideRouteControl(){
        $('.router-expander').hide('fast');
        $('.leaflet-routing-geocoders, .leaflet-routing-alternatives-container').hide('fast');
        $('.router-expander-inverse').show('fast');
    }

    function showRouteControl(){
        $('.router-expander-inverse').hide('fast');
        $('.router-expander').show('fast');
        $('.leaflet-routing-geocoders, .leaflet-routing-alternatives-container ').show('fast');
    }

    function getControlHrmlContent() {
        return '<div id="controlbox" >\n' +
            '   <div id="boxcontainer" class="searchbox searchbox-shadow" >\n' +
            '      <div class="searchbox-menu-container"><button aria-label="Menu" id="searchbox-menubutton" class="searchbox-menubutton"></button> <span aria-hidden="true" style="display:none">Menu</span> </div>\n' +
            '      <div><input id="searchboxinput" type="text" autocomplete="off" style="position: relative;"/></div>\n' +
            '      <div class="searchbox-searchbutton-container"><button aria-label="search" id="searchbox-searchbutton" class="searchbox-searchbutton"></button> <span aria-hidden="true" style="display:none;">search</span> </div>\n' +
            '      <div class="searchbox-suggestions">' +
            '      <ul id="searchbox-suggestions-list"></ul>' +
            '      </div>\n' +
            '   </div>\n' +
            '</div>\n' +
            '<div class="panel">\n' +
            '   <div class="panel-header">\n' +
            '      <div class="panel-header-container"> <span class="panel-header-title"></span> <button aria-label="Menu" id="panelbutton" class="panel-close-button"></button> </div>\n' +
            '   </div>\n' +
            '   <div class="panel-content"> </div>\n' +
            '</div>'
    }

    function generateHtmlContent(a) {
        return '<ul class="panel-list">\n' +
            '   <li class="panel-list-item"><a href="#" onclick="findARoute();return false;"><span class="panel-list-item-icon icon-local-route"></span>Find a route</a></li>\n' +
            '   <li class="panel-list-item topline"><a href="{{ route('plugin.mapsengine.redirect', ['q' => $query]) }}"><span class="panel-list-item-icon icon-search"></span>Return to Web Search</a></li>\n' +
            '</ul>';
    }

    if(route_search == 1){
        addRouter();
    }
    var params = new URLSearchParams(location.search);
    var query = params.get('q');
    searchWithQuery(query);
</script>
</body>
</html>