<?php

return [
    'id' => 'custompages',
	
	'version' => '1.0.0',
	
	'title' => 'Custom pages',
	
	'description' => 'Let creat unlimited custom pages.',
	
	'manageAction' => 'admin\plugins\custompages\CustomPagesController@get',
	
	'thumbnail' => 'custompages/thumbnail.png',
	
	'active' => true,
	
	'activeCallback' => 'admin\PluginsController@installed',
	
	'hasAdmin' => true,
	
	'options' => [],
	
];
