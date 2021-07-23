<?php

return [
    'id' => 'whatismyip',
	
	'version' => '1.0.0',
	
	'title' => 'What is my IP',
	
	'description' => 'let your visitors see their IP when they look for it.',
	
	'manageAction' => '',
	
	'thumbnail' => 'whatismyip/thumbnail.png',
	
	'active' => true,
	
	'activeCallback' => 'admin\PluginsController@installed',
	
	'hasAdmin' => false,
	
	'options' => [],
	
];
