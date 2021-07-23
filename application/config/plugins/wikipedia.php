<?php

return [
    'id' => 'wikipedia',
	
	'version' => '1.0.0',
	
	'title' => 'Wikipedia search',
	
	'description' => 'Wikipedia search engine with query information.',
	
	'manageAction' => 'admin\plugins\wikipedia\WikiController@get',
	
	'thumbnail' => 'wikipedia/thumbnail.png',
	
	'active' => true,
	
	'activeCallback' => 'admin\plugins\wikipedia\WikiController@activeCallback',
	
	'hasAdmin' => true,

	'options' => [],

    'show_in' => 'web',

    'enable_query' => true,

    'enable_page' => true,

];
