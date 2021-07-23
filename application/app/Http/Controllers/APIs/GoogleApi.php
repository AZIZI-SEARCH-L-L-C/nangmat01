<?php

namespace AziziSearchEngineStarter\Http\Controllers\APIs;

use GuzzleHttp\Client;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use Input, LaravelLocalization;

class GoogleApi extends Controller
{
	
	public $webEndpoint = 'https://www.googleapis.com/customsearch/v1';
	public $imagesEndpoint = 'https://www.googleapis.com/customsearch/v1';
	
	public $getWebRequestBody;
	
	public $spelling = null;
	
	private $perpage = 10;
    
    public function getWeb($result){
		
		$perpage = 10; // since google doesn't allow more
		$config = config('google.web');
		
		$array = json_decode($result->getBody(), true);
		$results = [];
		
//		 dd($array);
		
		$results['info'] = [
		    'time'  => array_get($array, $config['map']['ResultsInfo']['time']),
//		    'total' => array_get($array, $config['map']['ResultsInfo']['total']),
		    'total' => 0,
		];
		
		$results['results'] = [];
        $key_odd = 1;
		if(array_get($array, $config['map']['scheme']['items'])){
			foreach(array_get($array, $config['map']['scheme']['items']) as $key => $item){
				$results['results'][] = [
					'title'             => array_get($item, $config['map']['Results']['title']),
					'titleHtml'         => array_get($item, $config['map']['Results']['titleHtml']),
					'description'       => array_get($item, $config['map']['Results']['description']),
					'descriptionHtml'   => array_get($item, $config['map']['Results']['descriptionHtml']),
					'displayLink'       => array_get($item, $config['map']['Results']['displayLink']),
					'displayLink'       => array_get($item, $config['map']['Results']['displayLink']),
					'url'               => array_get($item, $config['map']['Results']['url']),
					'urlHtml'           => array_get($item, $config['map']['Results']['urlHtml']),
					'deepLinks'         => array_get($item, $config['map']['Results']['deepLinks']),
					'order'             => $key_odd,
					'score'             => 1 / ($key + 1),
					'source'            => 'Google',
				];
                $key_odd += 2;
			}
		}

		return $results;
		
	}
	
	public function getImages($result){
		
		$config = config('google.images');
		$array = json_decode($result->getBody(), true);
		
		// dd($array);
		$results = [];
		
		$results['info'] = [
		    'time'  => array_get($array, $config['map']['ResultsInfo']['time']),
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
					'url'               => array_get($item, $config['map']['Results']['url']),
					'src'               => array_get($item, $config['map']['Results']['src']),
					'mime'              => last(explode('/', array_get($item, $config['map']['Results']['mime']))),
					'height'            => array_get($item, $config['map']['Results']['height']),
					'width'             => array_get($item, $config['map']['Results']['width']),
					'size'              => array_get($item, $config['map']['Results']['size']),
					'thumbnailLink'     => array_get($item, $config['map']['Results']['thumbnailLink']),
					'thumbnailHeight'   => array_get($item, $config['map']['Results']['thumbnailHeight']),
					'thumbnailWidth'    => array_get($item, $config['map']['Results']['thumbnailWidth']),
					'order'             => $key + 1,
					'score'             => 1 / ($key + 1),
					'source'            => 'Google',
				];
			}
		}
		
		return $results;
		
	}
	
	public function getWebParams($query, $page, $common){
		
		$settings = $common['settings'];
		$config = config('google.web');
		$fileTypes = explode(',', $settings['fileTypes']);
		$filetype = Input::get('f');
		$countries = explode(',', $settings['countries']);
		$country = Input::get('c');
		$date = Input::get('d', -1);
		
		// if(in_array($filetype, $fileTypes)){
			// $query = $query . ' filetype:'.$filetype;
		// }
		
		$params = [
			'key'      => config('google.key'),
			'cx'       => $settings['googleWebCsePublicKey'],
			'q'        => $query,
			'start'    => ($this->perpage * ($page - 1)) + 1,
			'num'      => $this->perpage,
			'safe'     => $config['safe'][$settings['safeSearch']],
			// 'siteSearch'    => 'sharemods.com',
		];
		
		if(in_array($filetype, $fileTypes)){
			$params = array_add($params, 'fileType', $filetype);
		}
		
		// add country if it's needed
		$countryCode = $common['region'];
		if(in_array($countryCode, $countries)){
			if($common['regionMode'] == 1){  // Restricts search results to documents originating in a particular country.
				$params = array_add($params, 'cr', $countryCode);
			}elseif($common['regionMode'] == 2){  // boosts search results whose country of origin matches the parameter value.
				$params = array_add($params, 'gl', $countryCode);
			}
		}
		
		// add date if it's in filters
		if(in_array($date, [0, 1, 2])){
			$params = array_add($params, 'dateRestrict', $config['date'][$date]);
		}
		
		// dd($params);
		
		return ['query' => $params];
	}
	
	public function getImagesParams($query, $page, $common, $moreResults){
		
		$perpage = 10;
		
		if($moreResults){ 
			$start = ($page - 1) * $perpage + $perpage + 1;
		}else{
			$start = ($page - 1) * $perpage + 1;
		}
		
		// dd($start);
		$settings = $common['settings'];
		$config = config('google.images');
		$colors = $config['color'];
		$color = Input::get('c');
		$imgTypes = array_keys($config['type']);
		$imgType = Input::get('t');
		$licensesK = array_keys($config['license']);
		$license = Input::get('l');
		$imgSizesK = array_keys($config['size']);
		$imgSize = Input::get('s');
		
		// dd($config);
		$params = [
			'key'          => config('google.key'),
			'cx'           => $settings['googleImagesCsePublicKey'],
			'q'            => $query,
			'start'        => $start,
			'num'          => $perpage,
			'safe'         => $config['safe'][$settings['safeSearch']],
			'searchType'   => 'image',
		];
		
		// add country if it's needed
		$countryCode = $common['region'];
		$countries = explode(',', $settings['countries']);
		if(in_array($countryCode, config('google.countries'))){
			if($common['regionMode'] == 1){  // Restricts search results to documents originating in a particular country.
				$params = array_add($params, 'cr', $countryCode);
			}elseif($common['regionMode'] == 2){  // boosts search results whose country of origin matches the parameter value.
				$params = array_add($params, 'gl', $countryCode);
			}
		}
		
		// add color if it's in filters
		if(in_array($color, $colors)){
			$params = array_add($params, 'imgDominantColor', $config['color'][$color]);
		}
		
		// add type if it's in filters
		if(in_array($imgType, $imgTypes)){
			$params = array_add($params, 'imgType', $config['type'][$imgType]);
		}
		
		// add license if it's in filters
		if(in_array($license, $licensesK)){
			$params = array_add($params, 'rights', $config['license'][$license]);
		}
		
		// add size if it's in filters
		if(in_array($imgSize, $imgSizesK)){
			$params = array_add($params, 'imgSize', $config['size'][$imgSize]);
		}
		
		// dd($params);
		
		return ['query' => $params];
	}
	
}
