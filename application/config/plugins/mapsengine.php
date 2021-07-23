<?php

return [
    'id' => 'mapsengine',
	
	'version' => '1.0.0',
	
	'title' => 'Maps search engine',
	
	'description' => 'Maps search engine with routes finding.',
	
	'manageAction' => 'admin\plugins\mapsengine\MapsEngineController@get',
	
	'thumbnail' => 'mapsengine/thumbnail.png',
	
	'active' => true,
	
	'activeCallback' => 'admin\plugins\mapsengine\MapsEngineController@activeCallback',
	
	'hasAdmin' => true,

	'options' => [],

    'show_in' => 'web',

    'enable_query' => true,

    'enable_page' => true,

];
