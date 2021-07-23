<?php
return array(

    'key' => env('AZIZI_SEACH_API_KEY', ''),

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
            0 => 'last_day',
            1 => 'last_week',
            2 => 'last_month',
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
            0 => 'last_day',
            1 => 'last_week',
            2 => 'last_month',
        ),

        // images type search choices
        'type' => array(
            'clipart'    => 'clipart',
            'line'       => 'line_drawing',
            'gif'        => 'gif',
        ),

        // images license search choices
        'license' => array(
            'public'      => 'reuse_with_modification',
            'share'       => 'reuse',
            'free'        => 'non_commercial_reuse_with_modification',
        ),

        // images size search choices
        'size' => array(
            'small'      => 'icon',
            'medium'     => 'medium',
            'large'      => 'large',
        ),

        // color images search choices
        'color' => array(
            'transparent'    => 'transparent',
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
            0 => 'last_day',
            1 => 'last_week',
            2 => 'last_month',
        ),
    ),

    // countries Codes
    'countries' => [],
);
