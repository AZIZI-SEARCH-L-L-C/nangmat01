<?php

namespace AziziSearchEngineStarter\Http\Controllers\APIs;

use GuzzleHttp\Client;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use Input, LaravelLocalization;
use GuzzleHttp\Exception\ClientException;

class AziziSearchApi extends Controller
{

    public $webEndpoint = 'https://api.azizisearch.com';
    public $imagesEndpoint = 'https://api.azizisearch.com';
    public $videosEndpoint = 'https://api.azizisearch.com';
    public $newsEndpoint = 'https://api.azizisearch.com';

    private $perpage = 10;

    public function getWeb($result){

        $items = [];
        $array = [];
        try{
            $array = json_decode($result->getBody(), true);
            $items = array_get($array, 'organic_results');
        }catch(ClientException $e){
//			 dd($e);
        }

//		dd($array);
        $results = [];
        $results['results'] = [];

        $results['info'] = [
            'time'  => array_get($array, 'search_information.time_taken_displayed'),
            'total' => array_get($array, 'search_information.total_results'),
        ];

        $key_odd = 2;
        if($items){
            foreach($items as $key => $item){
                $results['results'][] = [
                    'title'             => array_get($item, 'title'),
                    'titleHtml'         => null,
                    'description'       => array_get($item, 'snippet'),
                    'descriptionHtml'   => null,
                    'displayLink'       => array_get($item, 'domain'),
                    'url'               => $this->getUncryptedUrl(array_get($item, 'link')),
                    'urlHtml'           => array_get($item, 'link'),
                    'deepLinks'         => null,
                    'order'             => $key_odd,
                    'score'             => 1 / ($key + 1),
                    'source'            => 'AziziSearch',
                ];
                $key_odd += 2;
            }
        }

        return $results;

    }

    public function getImages($result){

//        $config = config('bing.images');
        $array = json_decode($result->getBody(), true);

//         dd($array);
        $results = [];

        $results['info'] = [
            'time'  => null,
            'total' => null,
        ];

        $results['results'] = [];
        if(array_get($array, 'image_results')){
            foreach(array_get($array, 'image_results') as $key => $item){
                $results['results'][] = [
                    'title'             => array_get($item, 'title'),
                    'titleHtml'         => array_get($item, 'title'),
                    'description'       => array_get($item, 'description'),
                    'descriptionHtml'   => array_get($item, 'description'),
                    'displayLink'       => array_get($item, 'link'),
                    'url'               => $this->getUncryptedUrl(array_get($item, 'link')),
                    'src'               => $this->getUncryptedUrl(array_get($item, 'image')),
                    'mime'              => null,
                    'height'            => array_get($item, 'height'),
                    'width'             => array_get($item, 'width'),
                    'size'              => null,
                    'thumbnailLink'     => array_get($item, 'image'),
                    'thumbnailHeight'   => array_get($item, 'height'),
                    'thumbnailWidth'    => array_get($item, 'width'),
                    'order'             => $key + 1,
                    'score'             => 1 / ($key + 1),
                    'source'            => 'AziziSearch',
                ];
            }
        }

        return $results;

    }

    public function getVideos($result){

//        dd($result);
        $config = config('bing.videos');
        $array = json_decode($result->getBody(), true);

//         dd($array);

        $results = [];
        $results['results'] = [];

        $results['info'] = [
            'time'  => array_get($array, 'search_information.time_taken_displayed'),
            'total' => array_get($array, 'search_information.total_results'),
        ];

        foreach(array_get($array, 'video_results') as $key => $item){
            $results['results'][] = [
                'title'             => array_get($item, 'title'),
                'description'       => array_get($item, 'snippet'),
                'displayLink'       => array_get($item, 'domain'),
                'url'               => array_get($item, 'link'),
                'src'               => array_get($item, 'link'),
                'date'              => $this->getTimeFormated(array_get($item, 'date')),
                'preview'           => null,
                'duration'          => array_get($item, 'length'),
                'publisher'         => null,
                'thumbnailLink'     => array_get($item, 'image'),
                'thumbnailHeight'   => null,
                'thumbnailWidth'    => null,
                'views'    			=> null,
                'order'             => $key + 1,
                'score'             => 1 / ($key + 1),
                'source'            => 'AziziSearch',
            ];
        }

        return $results;

    }

    public function getNews($result){

        $config = config('bing.news');

        $client = new Client();
        $items = [];
        $array = [];
        try{
            $array = json_decode($result->getBody(), true);
            $items = array_get($array, 'news_results');
            // dd($array);
        }catch(ClientException $e){
            // dd($e);
        }

        $results = [];
        $results['results'] = [];

        $results['info'] = [
            'time'  => array_get($array, 'search_information.time_taken_displayed'),
            'total' => array_get($array, 'search_information.total_results'),
        ];

        if($items){
            foreach($items as $key => $item){
                $results['results'][] = [
                    'title'             => array_get($item, 'title'),
                    'titleHtml'         => null,
                    'description'       => array_get($item, 'snippet'),
                    'descriptionHtml'   => null,
                    'category'          => array_get($item, ''),
                    'url'               => $this->getUncryptedUrl(array_get($item, 'link')),
                    'datePublished'     => $this->getTimeFormated(array_get($item,'date_utc')),
                    'provider'          => array_get($item, 'source'),
                    'thumbnail'         => array_get($item, 'thumbnail'),
                    'order'             => $key + 1,
                    'score'             => 1 / ($key + 1),
                    'source'            => 'AziziSearch',
                ];
            }
        }

        return $results;
    }

    public function getWebParams($query, $page, $common){
        $settings = $common['settings'];
        $config = config('azizisearch.web');
//        $fileTypes = explode(',', $settings['fileTypes']);
//        $filetype = Input::get('f');
        $countries = explode(',', $settings['countries']);
        $country = Input::get('c');
        $date = Input::get('d', -1);
//
//        if(in_array($filetype, $fileTypes)){
//            $query = $query . ' filetype:'.$filetype;
//        }

        $params = [
            'api_key'           => config('azizisearch.key'),
            'q'                 => $query,
            'num'               => $this->perpage,
            'page'              => $page,
            'include_html' => 'false'
//            'safeSearch'        => $config['safe'][$settings['safeSearch']],
        ];

        // add country if it's needed
        if(Input::has('c')){
            $countryCode = $country;
        }else{
            $countryCode = $common['region'];
        }
        if(in_array($countryCode, $countries)){
            if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
                $params = array_add($params, 'gl', $countryCode);
            }
        }
//
//        // add date if it's in filters
        if(in_array($date, [0, 1, 2])){
            $params = array_add($params, 'time_period', $config['date'][$date]);
        }

//		 dd(['query' => $params, 'headers' => [ 'Ocp-Apim-Subscription-Key' => config('bing.key'), 'Accept-Language' => 'en']]);
//		dd($params);

        return ['query' => $params];

    }

    public function getImagesParams($query, $page, $common, $moreResults){
        $settings = $common['settings'];
        $config = config('azizisearch.images');
        $colors = array_keys($config['color']);
        $color = Input::get('c');
        $imgTypes = array_keys($config['type']);
        $imgType = Input::get('t');
        $licensesK = array_keys($config['license']);
        $license = Input::get('l');
        $imgSizesK = array_keys($config['size']);
        $imgSize = Input::get('s');

        $params = [
            'api_key'           => config('azizisearch.key'),
            'q'                 => $query,
            'images_page'       => $page,
            'search_type'       => 'images',
            'include_html' => 'false'
//            'count'             => $perpage,
//            'offset'            => $offset,
//            'mkt'               => 'en-us',
//            'safeSearch'        => $config['safe'][$settings['safeSearch']],
        ];

        // add country if it's needed

        $countryCode = $common['region'];
        $countries = explode(',', $settings['countries']);
        if(in_array($countryCode, $countries)){
            if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
                $params = array_add($params, 'gl', $countryCode);
            }
        }

        // add color if it's in filters
        if(in_array($color, $colors)){
            $params = array_add($params, 'images_color', $config['color'][$color]);
        }
//
        // add color if it's in filters
        if(in_array($imgType, $imgTypes)){
            $params = array_add($params, 'images_type', $config['type'][$imgType]);
        }

        // add license if it's in filters
        if(in_array($license, $licensesK)){
            $params = array_add($params, 'images_usage', $config['license'][$license]);
        }

        // add size if it's in filters
        if(in_array($imgSize, $imgSizesK)){
            $params = array_add($params, 'images_size', $config['size'][$imgSize]);
        }

//         dd($params);

        return ['query' => $params];
    }

    public function getVideosParams($query, $page, $common, $moreResults){

//        $perpageMore = 150; // since bing videos api not accept more than 150
//        $perpageLess = 50; // the first request must save much time
//
//        if($moreResults){
//            $perpage = $perpageMore;
//            $offset = ($page - 1) * $perpage + $perpageLess;
//        }else{
//            $perpage = $perpageLess;
//            $offset = ($page - 1) * $perpage;
//        }

        $settings = $common['settings'];
//        $config = config('bing.videos');
//        $pricingsK = array_keys($config['pricing']);
//        $pricing = Input::get('pr');
//        $resolutions = $config['resolution'];
//        $resolution = Input::get('r');
//        $lengths = $config['length'];
//        $lengthsK = array_keys($config['length']);
//        $length = Input::get('l');

        $params = [
            'api_key'           => config('azizisearch.key'),
            'q'                 => $query,
            'page'              => $page,
            'search_type'       => 'videos',
            'hl'                => 'en',
            'include_html'      => 'false'
        ];

        // add country if it's needed
        $countryCode = $common['region'];
        $countries = explode(',', $settings['countries']);
        if(in_array($countryCode, $countries)){
            if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
                $params = array_add($params, 'gl', $countryCode);
            }
        }

//        // add pricing if it's in filters
//        if(in_array($pricing, $pricingsK)){
//            $params = array_add($params, 'pricing', $config['pricing'][$pricing]);
//        }
//
//        // add resolution if it's in filters
//        if(in_array($resolution, $resolutions)){
//            $params = array_add($params, 'resolution', $config['resolution'][$resolution]);
//        }
//
//        // add length if it's in filters
//        if(in_array($length, $lengthsK)){
//            $params = array_add($params, 'videoLength', $config['length'][$length]);
//        }

//         dd($params);

        return ['query' => $params];
    }

    public function getNewsParams($query, $page, $common){


        $settings = $common['settings'];
//        $perpage = $settings['perPageNews']; // the first request must save much time
//        $config = config('bing.news');
//
//        $dates = [0 => 'past 24 hours', 1 => 'past week', 2 => 'past month'];
//        $datesK = array_keys($dates);
//        $date = Input::get('d', -1);

        $params = [
            'api_key'           => config('azizisearch.key'),
            'q'                 => $query,
            'images_page'       => $page,
            'search_type'       => 'news',
            'include_html'      => 'false'
        ];

        // add country if it's needed
        if(Input::has('c')){
            $countryCode = Input::get('c');
        }else{
            $countryCode = $common['region'];
        }
        $countries = explode(',', $settings['countries']);
        if(in_array($countryCode, $countries)){
            if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
                $params = array_add($params, 'gl', $countryCode);
            }
        }

//        // add date if it's in filters
//        if(in_array($date, $datesK)){
//            $params = array_add($params, 'freshness', $config['date'][$date]);
//        }
//
        if(Input::has('s')){
            $sort = Input::get('s', '');
            $params = array_add($params, 'sort_by', $sort);
        }

        // $params = array_add($params, 'textDecorations', 'true');
//		 dd($params);

        return ['query' => $params];
    }

}
