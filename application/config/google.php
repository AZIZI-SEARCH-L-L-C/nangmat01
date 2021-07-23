<?php
return array(

    'key' => env('GOOGLE_CSE_KEY', ''),
	
    // google web config
    'web' => array(
		// how the data structered on bing response
		'map' => array(
			'scheme' => [
				'items' => 'items',
			],
			'ResultsInfo' => [
				'time' => 'searchInformation.searchTime',
				'total' => 'searchInformation.totalResults',
			],
			'Results' => [
				'title' => 'title',
				'titleHtml' => 'htmlTitle',
				'description' => 'snippet',
				'descriptionHtml' => 'htmlSnippet',
				'displayLink' => 'displayLink',
				'url' => 'link',
				'urlHtml'   => 'htmlFormattedUrl',
				'deepLinks' => 'deepLinks',
			],
		),
		
		// safe search choices
		'safe' => array(
			0 => 'off',
			1 => 'medium',
			2 => 'high',
		),
		
		// date search choices
		'date' => array(
			0 => 'd[1]',
			1 => 'w[1]',
			2 => 'm[1]',
		),
	),
	
	// google images config
	'images' => array(
		// how the data structered on bing response
		'map' => array(
			'scheme' => [
				'items' => 'items',
			],
			'ResultsInfo' => [
				'time' => 'searchInformation.searchTime',
				'total' => 'searchInformation.totalResults',
			],
			'Results' => [
				'title' => 'title',
				'titleHtml' => 'htmlTitle',
				'description' => 'snippet',
				'descriptionHtml' => 'htmlSnippet',
				'displayLink' => 'displayLink',
				'url' => 'image.contextLink',
				'src' => 'link',
				'mime' => 'mime',
				'height' => 'image.height',
				'width' => 'image.width',
				'size' => 'image.byteSize',
				'thumbnailLink' => 'image.thumbnailLink',
				'thumbnailHeight' => 'image.thumbnailHeight',
				'thumbnailWidth' => 'image.thumbnailWidth',
			],
		),
		
		// safe search choices
		'safe' => array(
			0 => 'off',
			1 => 'medium',
			2 => 'high',
		),
		
		// date search choices
		'date' => array(
			0 => 'd[1]',
			1 => 'w[1]',
			2 => 'm[1]',
		),
		
		// images type search choices
		'type' => array(
			'clipart'    => 'clipart',
			'line'       => 'lineart',
			'photo'      => 'photo',
		),
		
		// images license search choices
		'license' => array(
			'public'      => 'cc_publicdomain',
			'share'       => 'cc_sharealike',
			'free'        => 'cc_noncommercial',
		),
		
		// images size search choices
		'size' => array(
			'small'      => 'small',
			'medium'     => 'medium',
			'large'      => 'large',
		),
		
		// color images search choices
		'color' => array(
			'black'    => 'black',
			'blue'     => 'blue',
			'brown'    => 'brown',
			'gray'     => 'gray',
			'green'    => 'green',
			'pink'     => 'pink',
			'purple'   => 'purple',
			'teal'     => 'teal',
			'white'    => 'white',
			'yellow'   => 'yellow',
		),
	),
	
	
	// countries Codes
	'countries' => [],
);
