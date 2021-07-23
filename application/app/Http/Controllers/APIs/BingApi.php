<?php

namespace AziziSearchEngineStarter\Http\Controllers\APIs;

use GuzzleHttp\Client;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use Input, LaravelLocalization;
use GuzzleHttp\Exception\ClientException;

class BingApi extends Controller
{
	
	public $webEndpoint = 'https://api.bing.microsoft.com/v7.0/search';
	public $imagesEndpoint = 'https://api.bing.microsoft.com/v7.0/images/search';
	public $videosEndpoint = 'https://api.bing.microsoft.com/v7.0/videos/search';
	public $newsEndpoint = 'https://api.bing.microsoft.com/v7.0/news/search';
	
	private $perpage = 10;
	
    public function getWeb($result){

		$config = config('bing.web');
		$items = [];
		$array = [];
		try{
			$array = json_decode($result->getBody(), true);
			$items = array_get($array, $config['map']['scheme']['items']);
		}catch(ClientException $e){
//			 dd($e);
		}

//		dd($array);
		$results = [];
		$results['results'] = [];
		
		$results['info'] = [
		    'time'  => null,
	        'total' => array_get($array, $config['map']['ResultsInfo']['total']),
		];

		$key_odd = 2;
		if($items){
			foreach($items as $key => $item){
				$results['results'][] = [
					'title'             => array_get($item, $config['map']['Results']['title']),
					'titleHtml'         => null,
					'description'       => array_get($item, $config['map']['Results']['description']),
					'descriptionHtml'   => null,
					'displayLink'       => array_get($item, $config['map']['Results']['displayLink']),
					'url'               => $this->getUncryptedUrl(array_get($item, $config['map']['Results']['url'])),
					'urlHtml'           => array_get($item, $config['map']['Results']['url']),
					'deepLinks'         => array_get($item, $config['map']['Results']['deepLinks']),
					'order'             => $key_odd,
					'score'             => 1 / ($key + 1),
					'source'            => 'Bing',
				];
				$key_odd += 2;
			}
		}

		return $results;
		
	}
    
    public function getImages($result){
		
		$config = config('bing.images');
		$array = json_decode($result->getBody(), true);
		
		// dd($array);
		$results = [];
		
		$results['info'] = [
		    'time'  => null,
		    'total' => array_get($array, $config['map']['ResultsInfo']['total']),
		];
		
		$results['results'] = [];
		if(array_get($array, $config['map']['scheme']['items'])){
			foreach(array_get($array, $config['map']['scheme']['items']) as $key => $item){
				$results['results'][] = [
					'title'             => array_get($item, $config['map']['Results']['title']),
					'titleHtml'         => array_get($item, $config['map']['Results']['titleHtml']),
					'description'       => array_get($item, $config['map']['Results']['description']),
					'descriptionHtml'   => array_get($item, $config['map']['Results']['descriptionHtml']),
					'displayLink'       => array_get($item, $config['map']['Results']['displayLink']),
					'url'               => $this->getUncryptedUrl(array_get($item, $config['map']['Results']['url'])),
					'src'               => $this->getUncryptedUrl(array_get($item, $config['map']['Results']['src'])),
					'mime'              => last(explode('/', array_get($item, $config['map']['Results']['mime']))),
					'height'            => array_get($item, $config['map']['Results']['height']),
					'width'             => array_get($item, $config['map']['Results']['width']),
					'size'              => array_get($item, $config['map']['Results']['size']),
					'thumbnailLink'     => array_get($item, $config['map']['Results']['thumbnailLink']),
					'thumbnailHeight'   => array_get($item, $config['map']['Results']['thumbnailHeight']),
					'thumbnailWidth'    => array_get($item, $config['map']['Results']['thumbnailWidth']),
					'order'             => $key + 1,
					'score'             => 1 / ($key + 1),
					'source'            => 'Bing',
				];
			}
		}
		
		return $results;
		
	}
    
    public function getVideos($result){
		
		$config = config('bing.videos');
		$array = json_decode($result->getBody(), true);
		
		// dd($array);
		
		$results = [];
		$results['results'] = [];
		
		$results['info'] = [
		    'time'  => null,
		    'total' => array_get($array, $config['map']['ResultsInfo']['total']),
		];
		
		foreach(array_get($array, $config['map']['scheme']['items']) as $key => $item){
			$results['results'][] = [
			    'title'             => array_get($item, $config['map']['Results']['title']),
			    'description'       => array_get($item, $config['map']['Results']['description']),
			    'displayLink'       => array_get($item, $config['map']['Results']['displayLink']),
			    'url'               => array_get($item, $config['map']['Results']['url']),
			    'src'               => array_get($item, $config['map']['Results']['src']),
			    'date'              => $this->getTimeFormated(array_get($item, $config['map']['Results']['date'])),
			    'preview'           => array_get($item, $config['map']['Results']['preview']),
			    'duration'          => $this->getDuration(array_get($item, $config['map']['Results']['duration'])),
			    'publisher'         => array_get($item, $config['map']['Results']['publisher']),
			    'thumbnailLink'     => array_get($item, $config['map']['Results']['thumbnailLink']),
			    'thumbnailHeight'   => array_get($item, $config['map']['Results']['thumbnailHeight']),
			    'thumbnailWidth'    => array_get($item, $config['map']['Results']['thumbnailWidth']),
			    'views'    			=> array_get($item, $config['map']['Results']['views']),
				'order'             => $key + 1,
				'score'             => 1 / ($key + 1),
				'source'            => 'Bing',
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
			$items = array_get($array, $config['map']['scheme']['items']);
			// dd($array);
		}catch(ClientException $e){
			// dd($e);
		}
		
		$results = [];
		$results['results'] = [];
		
		$results['info'] = [
		    'time'  => null,
	        'total' => array_get($array, $config['map']['ResultsInfo']['total']),
	        'sort'  => array_get($array, $config['map']['ResultsInfo']['sort']),
		];
		
		if($items){
			foreach($items as $key => $item){
				$results['results'][] = [
					'title'             => array_get($item, $config['map']['Results']['title']),
					'titleHtml'         => null,
					'description'       => array_get($item, $config['map']['Results']['description']),
					'descriptionHtml'   => null,
					'category'          => array_get($item, $config['map']['Results']['category']),
					'url'               => $this->getUncryptedUrl(array_get($item, $config['map']['Results']['url'])),
					'datePublished'     => $this->getTimeFormated(array_get($item, $config['map']['Results']['datePublished'])),
					'provider'          => array_get($item, $config['map']['Results']['provider']),
					'thumbnail'         => array_get($item, $config['map']['Results']['thumbnail']),
					'order'             => $key + 1,
					'score'             => 1 / ($key + 1),
					'source'            => 'Bing',
				];
			}
		}
		
		return $results;
	}
	
	public function getWebParams($query, $page, $common){
		$settings = $common['settings'];
		$config = config('bing.web');
		$fileTypes = explode(',', $settings['fileTypes']);
		$filetype = Input::get('f');
		$countries = explode(',', $settings['countries']);
		$country = Input::get('c');
		$date = Input::get('d', -1);

		if(in_array($filetype, $fileTypes)){
			$query = $query . ' filetype:'.$filetype;
		}
		
		$params = [
			'q'                 => $query,
			'count'             => $this->perpage,
			'offset'            => ($page - 1) * $this->perpage,
			'safeSearch'        => $config['safe'][$settings['safeSearch']],
//            'promote'           => 'Webpages,Computation,Entities',
//            'customconfig'      => 'f67d1a16-2441-4edd-b7d3-aab8eff66470'
		];
		
		// add country if it's needed
		if(Input::has('c')){
			$countryCode = $country;
		}else{
			$countryCode = $common['region'];
		}
		if(in_array($countryCode, $countries)){
			if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
				$params = array_add($params, 'cc', $countryCode);
			}else{
                $params = array_add($params, 'mkt', 'en-us');
            }
		}else{
            $params = array_add($params, 'mkt', 'en-us');
        }
		
		// add date if it's in filters
		if(in_array($date, [0, 1, 2])){
			$params = array_add($params, 'freshness', $config['date'][$date]);
		}
		
//		 dd(['query' => $params, 'headers' => [ 'Ocp-Apim-Subscription-Key' => config('bing.key'), 'Accept-Language' => 'en']]);
//		dd($params);

		return ['query' => $params, 'headers' => [ 'Ocp-Apim-Subscription-Key' => config('bing.key'), 'Accept-Language' => 'en']];
		
	}	
	
	public function getImagesParams($query, $page, $common, $moreResults){
		
		$perpageMore = 150; // since bing images api not accept more than 150
		$perpageLess = 50; // the first request must save much time
				
		if($moreResults){ 
			$perpage = $perpageMore; 
			$offset = ($page - 1) * $perpage + $perpageLess;
		}else{
			$perpage = $perpageLess; 
			$offset = ($page - 1) * $perpage;
		}
		
		// dd($offset);
		
		$settings = $common['settings'];
		$config = config('bing.images');
		$colors = array_keys($config['color']);
		$color = Input::get('c');
		$imgTypes = array_keys($config['type']);
		$imgType = Input::get('t');
		$licensesK = array_keys($config['license']);
		$license = Input::get('l');
		$imgSizesK = array_keys($config['size']);
		$imgSize = Input::get('s');
		
		$params = [
			'q'                 => $query,
			'count'             => $perpage,
			'offset'            => $offset,
			'mkt'               => 'en-us',
			'safeSearch'        => $config['safe'][$settings['safeSearch']],
//            'customconfig'      => 'f67d1a16-2441-4edd-b7d3-aab8eff66470'
		];
		
		// add country if it's needed

		$countryCode = $common['region'];
		$countries = explode(',', $settings['countries']);
		if(in_array($countryCode, $countries)){
			if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
				$params = array_add($params, 'cc', $countryCode);
			}
		}

		// add color if it's in filters
		if(in_array($color, $colors)){
			$params = array_add($params, 'color', $config['color'][$color]);
		}

		// add color if it's in filters
		if(in_array($imgType, $imgTypes)){
			$params = array_add($params, 'imageType', $config['type'][$imgType]);
		}
		
		// add license if it's in filters
		if(in_array($license, $licensesK)){
			$params = array_add($params, 'license', $config['license'][$license]);
		}
		
		// add size if it's in filters
		if(in_array($imgSize, $imgSizesK)){
			$params = array_add($params, 'size', $config['size'][$imgSize]);
		}
		
		// dd($params);
		
		return ['query' => $params, 'headers' => [ 'Ocp-Apim-Subscription-Key' => config('bing.key')]];
	}	
	
	public function getVideosParams($query, $page, $common, $moreResults){
		
		$perpageMore = 150; // since bing videos api not accept more than 150
		$perpageLess = 50; // the first request must save much time
				
		if($moreResults){ 
			$perpage = $perpageMore; 
			$offset = ($page - 1) * $perpage + $perpageLess;
		}else{
			$perpage = $perpageLess; 
			$offset = ($page - 1) * $perpage;
		}
		
		$settings = $common['settings'];
		$config = config('bing.videos');
		$pricingsK = array_keys($config['pricing']);
		$pricing = Input::get('pr');
		$resolutions = $config['resolution'];
		$resolution = Input::get('r');
		$lengths = $config['length'];
		$lengthsK = array_keys($config['length']);
		$length = Input::get('l');
		
		$params = [
			'q'                 => $query,
			'count'             => $perpage,
			'offset'            => $offset,
			'mkt'               => 'en-us',
			'safeSearch'        => $config['safe'][$settings['safeSearch']],
//            'customconfig'      => 'f67d1a16-2441-4edd-b7d3-aab8eff66470'
		];
		
		// add country if it's needed
		$countryCode = $common['region'];
		$countries = explode(',', $settings['countries']);
		if(in_array($countryCode, $countries)){
			if($common['regionMode'] != 0){  // Restricts search results to documents originating in a particular country.
				$params = array_add($params, 'cc', $countryCode);
			}
		}

		// add pricing if it's in filters
		if(in_array($pricing, $pricingsK)){
			$params = array_add($params, 'pricing', $config['pricing'][$pricing]);
		}

		// add resolution if it's in filters
		if(in_array($resolution, $resolutions)){
			$params = array_add($params, 'resolution', $config['resolution'][$resolution]);
		}
		
		// add length if it's in filters
		if(in_array($length, $lengthsK)){
			$params = array_add($params, 'videoLength', $config['length'][$length]);
		}
		
		// dd($params);
		
		return ['query' => $params, 'headers' => [ 'Ocp-Apim-Subscription-Key' => config('bing.key')]];
	}
	
	public function getNewsParams($query, $page, $common){
		
		
		$settings = $common['settings'];
		$perpage = $settings['perPageNews']; // the first request must save much time
		$config = config('bing.news');
		
		$dates = [0 => 'past 24 hours', 1 => 'past week', 2 => 'past month'];
		$datesK = array_keys($dates);
		$date = Input::get('d', -1);
		
		$params = [
			'q'                 => $query,
			'count'             => $perpage,
			'offset'            => ($page - 1) * $perpage,
			'safeSearch'        => $config['safe'][$settings['safeSearch']],
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
				$params = array_add($params, 'cc', $countryCode);
			}else{
                $params = array_add($params, 'mkt', 'en-us');
            }
		}else{
            $params = array_add($params, 'mkt', 'en-us');
        }
		
		// add date if it's in filters
		if(in_array($date, $datesK)){
			$params = array_add($params, 'freshness', $config['date'][$date]);
		}
		
		if(Input::has('s')){
			$sort = Input::get('s', '');
			$params = array_add($params, 'sortby', $sort);
		}
		
		// $params = array_add($params, 'textDecorations', 'true');
//		 dd($params);
		
		return ['query' => $params, 'headers' => [ 'Ocp-Apim-Subscription-Key' => config('bing.key'), 'Accept-Language' => 'en']];
	}

}
