<?php
return array(
    
    'key'       => env('BING_COGNITIVE_KEY', ''),
    'configKey' => env('BING_CUSTOM_CONFIG_KEY', ''),

    'web' => array(
		// how the data structered on bing response
		'map' => array(
			'scheme' => [
				'items' => 'webPages.value',
			],
			'ResultsInfo' => [
				'time' => '',
				'total' => 'webPages.totalEstimatedMatches',
			],
			'Results' => [
				'title' => 'name',
				'titleHtml' => '',
				'description' => 'snippet',
				'descriptionHtml' => '',
				'displayLink' => 'displayUrl',
				'url' => 'url',
				'urlHtml' => '',
				'deepLinks' => 'deepLinks',
			],
		),
		
		// safe search choices
		'safe' => array(
			0 => 'Off',
			1 => 'Moderate',
			2 => 'Strict',
		),
		
		// date search choices
		'date' => array(
			0 => 'Day',
			1 => 'Week',
			2 => 'Month',
		),
	),
	
    'images' => array(
		// how the data structered on bing response
		'map' => array(
			'scheme' => [
				'items' => 'value',
			],
			'ResultsInfo' => [
				'time' => '',
				'total' => 'totalEstimatedMatches',
			],
			'Results' => [
				'title' => 'name',
				'titleHtml' => '',
				'description' => 'name',
				'descriptionHtml' => '',
				'displayLink' => 'hostPageDisplayUrl',
				'url' => 'hostPageUrl',
				'src' => 'contentUrl',
				'mime' => 'encodingFormat',
				'height' => 'height',
				'width' => 'width',
				'size' => 'contentSize',
				'thumbnailLink' => 'thumbnailUrl',
				'thumbnailHeight' => 'thumbnail.height',
				'thumbnailWidth' => 'thumbnail.width',
			],
		),
		
		// safe search choices
		'safe' => array(
			0 => 'Off',
			1 => 'Moderate',
			2 => 'Strict',
		),
		
		// date search choices
		'date' => array(
			0 => 'Day',
			1 => 'Week',
			2 => 'Month',
		),
		
		// images type search choices
		'type' => array(
			'clipart'    => 'Clipart',
			'line'       => 'Line',
			'photo'      => 'Photo',
		),
		
		// images license search choices
		'license' => array(
			'public'      => 'Public',
			'share'       => 'Share',
			'free'        => 'ShareCommercially',
		),
		
		// images size search choices
		'size' => array(
			'small'      => 'Small',
			'medium'     => 'Medium',
			'large'      => 'Large',
		),
		
		// color images search choices
		'color' => array(
			'black'    => 'Black',
			'blue'     => 'Blue',
			'brown'    => 'Brown',
			'gray'     => 'Gray',
			'green'    => 'Green',
			'pink'     => 'Pink',
			'purple'   => 'Purple',
			'teal'     => 'Teal',
			'white'    => 'White',
			'yellow'   => 'Yellow',
		),
	),
	
    'videos' => array(
		// how the data structered on bing response
		'map' => array(
			'scheme' => [
				'items' => 'value',
			],
			'ResultsInfo' => [
				'time' => '',
				'total' => 'totalEstimatedMatches',
			],
			'Results' => [
				'title' => 'name',
				'description' => 'name',
				'displayLink' => '',
				'url' => 'hostPageUrl',
				'src' => 'contentUrl',
				'date' => 'datePublished',
				'publisher' => 'publisher.0.name',
				'duration' => 'duration',
				'preview' => 'motionThumbnailUrl',
				'thumbnailLink' => 'thumbnailUrl',
				'thumbnailHeight' => 'thumbnail.height',
				'thumbnailWidth' => 'thumbnail.width',
				'views' => 'viewCount',
			],
		),
		
		// safe search choices
		'safe' => array(
			0 => 'Off',
			1 => 'Moderate',
			2 => 'Strict',
		),
		
		// date search choices
		'date' => array(
			0 => 'Day',
			1 => 'Week',
			2 => 'Month',
		),
		
		// videos price search choices
		'pricing' => array(
			'free'      => 'Free',
			'paid'      => 'Paid',
		),
		
		// videos resolution search choices
		'resolution' => array(
			'480p'       => '480p',
			'720p'       => '720p',
			'1080p'      => '1080p',
		),
		
		// videos length search choices
		'length' => array(
			'short'      => 'Short',
			'medium'     => 'Medium',
			'long'       => 'Long',
		),
	),
	
	
    'news' => array(
		// how the data structered on bing response
		'map' => array(
			'scheme' => [
				'items' => 'value',
			],
			'ResultsInfo' => [
				'time'   => '',
				'total'  => 'totalEstimatedMatches',
				'sort'   => 'sort',
			],
			'Results' => [
				'title' => 'name',
				'titleHtml' => '',
				'description' => 'description',
				'descriptionHtml' => '',
				'category' => 'category',
				'datePublished' => 'datePublished',
				'provider' => 'provider.0.name',
				'thumbnail' => 'image.thumbnail.contentUrl',
				'url' => 'url',
				'urlHtml' => '',
			],
		),
		
		// safe search choices
		'safe' => array(
			0 => 'Off',
			1 => 'Moderate',
			2 => 'Strict',
		),
		
		// date search choices
		'date' => array(
			0 => 'Day',
			1 => 'Week',
			2 => 'Month',
		),
	),
	
	// countries Codes
	'countries' => array(
		'AR' => 'AR',
		'AU' => 'AU',
		'AT' => 'AT',
		'BE' => 'BE',
		'BR' => 'BR',
		'CA' => 'CA',
		'CL' => 'CL',
		'DK' => 'DK',
		'FI' => 'FI',
		'FR' => 'FR',
		'DE' => 'DE',
		'HK' => 'HK',
		'IN' => 'IN',
		'ID' => 'ID',
		'IE' => 'IE',
		'IT' => 'IT',
		'JP' => 'JP',
		'KR' => 'KR',
		'MY' => 'MY',
		'MX' => 'MX',
		'NL' => 'NL',
		'NZ' => 'NZ',
		'NO' => 'NO',
		'CN' => 'CN',
		'PL' => 'PL',
		'PT' => 'PT',
		'PH' => 'PH',
		'RU' => 'RU',
		'SA' => 'SA',
		'ZA' => 'ZA',
		'ES' => 'ES',
		'SE' => 'SE',
		'SH' => 'SH',
		'TW' => 'TW',
		'TR' => 'TR',
		'UK' => 'GB',
		'US' => 'US',
	),
);
