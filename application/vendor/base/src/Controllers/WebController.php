<?php

namespace AziziSearchBase\Controllers;

use AziziSearchEngineStarter\Http\Controllers\Controller;
use AziziSearchEngineStarter\Keywords;
use AziziSearchEngineStarter\Sites;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Auth;
use Performance\Performance;
use Performance\Config as PerformanceConfig;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input, Redirect, Cache, Request, Log;

class WebController extends Controller
{
	// web api providers
	private $providers;
	
	private $type = 'web';
	
	private $query;
	
	private $cacheTime;
	
	private $commonData;
	
	private $defferCacheTime;
	
	private $perpage;
	
	private $promises = [];
	
	private $cacheSlug;
	
	private $cacheBingWholeResponse;
	
	private $cacheGoogleWholeResponse;
	
	private $cacheSlugForInfo;
	
	private $parameters;
	
	private $pages;
	
	private $webPagination;
	
	private $cacheTimeZone = true;
	
	private $classes;
	
	private $oneOfAllShowed = false;
	
	private $bingWholeResponse;
	
	private $googleWholeResponse;
	
	private $resultsInfo = [];
	
	public function __construct(){
		// PerformanceConfig::setQueryLog(true);
		// PerformanceConfig::setQueryLog(true, 'full');
		// Performance::point();
		$this->query = Input::get('q');
		$this->commonData = $this->CommonData(true, $this->query, $this->type);
		$this->settings = $this->commonData['settings'];
		$this->page = (Input::get('p', 1) < 1) ? 1 : Input::get('p', 1);
		
		$this->perpage = $this->settings['perPageWeb'];
		$this->cacheTime = $this->settings['cacheTime'];
		$this->defferCacheTime = $this->settings['defferCacheTime'];
		$this->providers = config('app.apiWebProviders');
		$this->cache = $this->settings['cache'];
		
		$this->pages = 10;
		
		foreach(Request::all() as $q => $v){
			$this->parameters .= "$q=$v-";
		}
		
		$this->cachedPage = $this->page - 1;
		$this->cachedCurrentPageSlug = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-deferred';
		$this->cachedPreviousPageSlug = $this->query.'-'.$this->type.'-'.$this->cachedPage.'-'.$this->perpage.'-deferred';
		$this->cacheSlug = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parameters.'-'.$this->region.'-'.$this->regionMode.'-'.$this->settings['safeSearch'].'-cacheRequest';
		$this->cacheBingWholeResponse = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parameters.'-'.$this->region.'-'.$this->regionMode.'-'.$this->settings['safeSearch'].'-cacheBingWholeResponse';
		$this->cacheGoogleWholeResponse = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parameters.'-'.$this->region.'-'.$this->regionMode.'-'.$this->settings['safeSearch'].'-cacheGoogleWholeResponse';
		$this->cacheSlugForInfo = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parameters.'-'.$this->region.'-'.$this->regionMode.'-'.$this->settings['safeSearch'].'-cacheRequestForInfo';
		$this->webPagination = $this->settings['webPagination'];
	}
	
	public function search ()
    {

        // foreach(config('app.entities') as $df){
        // echo $df . ',';

        // }
        // exit();
        // Cache::tags('results')->flush();
        // Cache::flush();

        if (!Input::has('q')) {
            return Redirect::action('GeneralController@indexType', ['type' => $this->type]);
        }

        // filters options
        $preparedFilters = $this->prepareFilters();


        // Performance::point('get results.');
        if ($this->cache) {
            if ($this->page > 1 && Cache::has($this->cachedPreviousPageSlug)) {
                $cachedPreviousPage = Cache::get($this->cachedPreviousPageSlug);
                // boost score for results from the previous page
                foreach ($cachedPreviousPage as $resultsKey => $cachedResult) {
                    $cachedPreviousPage[$resultsKey]['score'] += 20;
                }
                if (!empty($cachedPreviousPage) < $this->perpage) {
                    // echo 'jbd cache: '. count($cachedPreviousPage);
                    $results = $this->traitCache();
                    $results = array_merge($results, $cachedPreviousPage);
                } else {
                    // echo 'jbd 4i mn lcache: ' . count($cachedPreviousPage);
                    $results = $cachedPreviousPage;
                }
            } else {
                $results = $this->traitCache();
            }
        } else {
            $results = $this->traitCache();
        }

        // set results Info
        $totalResults = 0;
        if ($this->cache) {
            if (Cache::has($this->cacheSlugForInfo)) {
                $this->resultsInfo = Cache::get($this->cacheSlugForInfo);
            }
        }

        foreach ($this->resultsInfo as $resultInfo) {
            $totalResults += (float) $resultInfo['total'];
        }

        $totalResults = number_format($totalResults, 0, '.', ',');

        if (count($this->providers) > 1) {
            $results = $this->removeDuplicateResults($results);
        }

        $lastOneEdit = false;
        $sitesToNow = -1;
        $keyword = Keywords::where('keyword', $this->query)->first();
        if($keyword) {
            $lastOneEdit = $keyword->user;
            $sites = $keyword->sites;
            if (!$sites->isEmpty()) {
                foreach ($sites as $site) {
                    $key = $this->getResultkeyByUrl($results, $site->url);
                    unset($results[$key]);
                    $sitesToNow -= 1;
                    if($site->rank != 0) {
                        if ($site->page == $this->page) {
                            $results[] = [
                                'title' => $site->title,
                                'titleHtml' => $site->title,
                                'description' => $site->description,
                                'descriptionHtml' => $site->description,
                                'displayLink' => $site->Vurl,
                                'url' => $site->url,
                                'urlHtml' => $site->url,
                                'deepLinks' => null,
                                'order' => $site->rank - 0.3,
                                'score' => (1 / ($site->rank - $sitesToNow)) + 0.001,
                                'source' => 'Database',
                            ];
                            $sitesToNow += 1;
                        }
                    }
                }
            }
        }

        $mathCalculation = $this->traitCalculations();
        $facts = $this->traitFacts();
        $spelling = $this->traitSpellSuggestions();
        $suggestions = $this->traitSuggestions();
        $translations = $this->traitTranslations();
        $entities = $this->traitEntities();
        $entities = array_slice($entities, 0, $this->settings['entitiesNum']);
        $entitiesAllowed = explode(',', $this->settings['entitesAllowed']);

        // dd($this->bingWholeResponse);
        // dd($entities);

        $timeZone = $this->traitTimeZone();
        if (isset($timeZone['primaryCityTime'])) {
            $timeZone = $timeZone['primaryCityTime'];
        }

        $news = [];
        if (!$this->oneOfAllShowed) {
            $news = $this->traitNewsForAll();
            $news = array_slice($news, 0, 3);
        }

        $images = [];
        if (!$this->oneOfAllShowed) {
            $images = $this->traitImagesForAll();
            $images = array_slice($images, 0, 4);
        }

        $videos = [];
        if (!$this->oneOfAllShowed) {
            $videos = $this->traitVideosForAll();
            $videos = array_slice($videos, 0, 3);
        }

        // defer results for this query for next pages
        $deferred = array_slice($results, $this->perpage);
        if (!empty($deferred)){
            Cache::put($this->cachedCurrentPageSlug, $deferred, $this->defferCacheTime);
        }
        $lastPage = false;
        // if(count($results) <= $this->perpage) $lastPage = true;

        uasort($results, function($a, $b){
            if ($a['order'] == $b['order']) {
                return 0;
            }
            return ($a['order'] > $b['order']) ? 1 : -1;
        });

        $results = array_slice($results, 0, $this->perpage);

        // number of page but need to be improved // for numbers pagination (2)
        if ($this->page >= $this->pages) $lastPage = true;
        $paginated = new \StdClass();
        if ($this->settings['webPagination'] == 2) {
            $total = intval(str_replace(',', '', $totalResults));
            if($this->settings['webPaginationFull']) {
                $paginated = new Paginator($results, $total, $this->settings['perPageWeb'], Input::get('p', 1), ['path' => action('WebController@search'), 'pageName' => 'p']);
            }else{
                $totalAllowed = $this->settings['webPaginationLimit'] * $this->settings['perPageWeb'];
                if($total > $totalAllowed)
                    $total = $totalAllowed;
                $paginated = new Paginator($results, $total, $this->settings['perPageWeb'], Input::get('p', 1), ['path' => action('WebController@search'), 'pageName' => 'p']);
            }
        }

//        dd($this->bingWholeResponse);
//        dd($paginated);
		// data that will be passed to the view template
		$pageData = [
		    'results'        => $results,
			'page'           => $this->page,
			'pages'          => $this->pages,
			'news'           => $news,
			'images'         => $images,
			'videos'         => $videos,
			'counter'        => 1,
			'mathCalc'		 => $mathCalculation,
			'totalResults'   => $totalResults,
			'timeZone'  	 => $timeZone,
			'facts'  	 	 => $facts,
			'spelling'   	 => $spelling,
			'suggestions'    => $suggestions,
			'translations'   => $translations,
			'entities'   	 => $entities,
			'entitiesAllowed'=> $entitiesAllowed,
			'lastPage'       => $lastPage,
			'paginated'      => $paginated,
			'lastOneEdit'    => $lastOneEdit,
		];
		
		$data = array_merge($this->commonData, $pageData, $preparedFilters);
		
		$data['renderTime'] = round((microtime(true) - LARAVEL_START) / 3, 2);
		
		// Performance::results();
		
		return view('engines.'.$this->type, $data);
		
	}
	
	protected function prepareFilters(){
		// files filter
		$fileTypes = explode(',', $this->settings['fileTypes']);
		$fileType = Input::get('f', '');
		// time filters
		$dates = [0 => 'past 24 hours', 1 => 'past week', 2 => 'past month'];
		$datesK = array_keys($dates);
		$date = Input::get('d', -1);
		// region filters
		$region = Input::get('c');
		$firstCountries = explode(',', $this->settings['firstCountries']);
		$countries = explode(',', $this->settings['countries']);
		// check if search has filter or not
		$hasFilters = in_array($fileType, $fileTypes) || in_array($region, $countries) || in_array($date, $datesK);
		
		$filters = [
			'fileTypes'      => $fileTypes,
			'fileType'       => $fileType,
			'date'           => $date,
			'dates'          => $dates,
			'datesK'         => $datesK,
			'region'         => $region,
			'firstCountries' => $firstCountries,
			'countries'      => $countries,
			'hasFilters'     => $hasFilters,
        ];		
		return $filters;
	}
	
	protected function removeDuplicateResults($results){
		// $o = new SmithWatermanGotoh();
		// threshold to remove duplicated results

        $queryWordsCount = count(explode(' ', Input::get('q')));
        if($queryWordsCount == 1){$similarityThreshold = 0.85;}else{$similarityThreshold = 0.80;}
		
		// fetch just IDs, urls & titles to use it to detect similar results
		$titles_urls = [];
		foreach($results as $key => $val){
			$titles_urls[$key]['title'] = $val['title'];
			$titles_urls[$key]['url'] = $val['url'];
			$titles_urls[$key]['source'] = $val['source'];
		}

		// get an array that contain just ID vs ID similar results
		$similarIDs = [];
		foreach($titles_urls as $key1 => $val1){ 
		// echo "[ \"" . $val1['title'] . "\", ],";
			foreach(array_except($titles_urls, $key1) as $key2 => $val2){ 
			    // $urlSim = $o->compare($val1['url'], $val2['url']);
			    // $titleSim = $o->compare($val1['title'], $val2['title']);
				similar_text($val1['url'], $val2['url'], $urlSim);
				$urlSim = round($urlSim / 100, 2);
			    similar_text($val1['title'], $val2['title'], $titleSim);
				$titleSim = round($titleSim / 100, 2);
				$similarityMean = round(($urlSim + $titleSim) / 2, 2);
			    if($similarityMean > $similarityThreshold && $val2['source'] != "Database"){
						$similarIDs[$key1][] = $key2;
				}
//			     if($similarityMean >= $similarityThreshold) echo $key1.' '.$val1['url'] . ' => ' . $val1['title'] .' // '. $key2.' '. $val2['url'] . ' => '. $val2['title'] . ' ===> ' . $urlSim . ' --- ' . $titleSim . '<br>'.$similarityMean.'<br>--------------------------<br><br>';
			}
		}
//		 exit();
		// foreach($similarIDs as $key => $val){
			
		// }
		
		// get just non-doubled similar ID vs ID results
		foreach($similarIDs as $key => $val){
			foreach($val as $key2 => $val2){
				if(isset($results[$key])){
					// $spread = abs($results[$key]['order'] - $results[$val2]['order']);
					// $mean = ($results[$key]['order'] + $results[$val2]['order']) / 2;
//                    if($results[$key]['source'] != 'Database')
                    $results[$key]['order'] -= 0.2;
                    unset($results[$val2]);
                    unset($similarIDs[$val2]);
                    unset($similarIDs[$val2][array_search($key, $similarIDs)]);
					$tobi[$key][] = $val2;
				}else{
					$gobi[$key][] = $val2;
					// unset($results[$val2]);
					// unset($similarIDs[$val2]);
				}
			}
		}
		
		// dd($removed);
		// dd($similarIDs);
		// foreach($gobi as $gobgobi){
			// unset($results[$gobgobi]);
		// }
//		 dd($results);
		
		// sort results depending on it's new score
//		uasort($results, function($a, $b){
//            if ($a['score'] == $b['score']) {
//                return 0;
//            }
//            return ($a['score'] < $b['score']) ? 1 : -1;
//	    });

		return $results;
	}
	
	public function AsyncRequests(){
		$client = new Client();
		// Initiate each request but do not block
		foreach($this->providers as $provider){
			$providerClass = new $provider();
			$this->promises[$provider] = $client->getAsync($providerClass->webEndpoint, $providerClass->getWebParams($this->query, $this->page, $this->commonData));
		}
	}

	public function updateRank(){
	    $user = Auth::user();
	    if(!$user->isAdmin()) return response('Permission denied!', 500);
	    if(!Input::has('keyword') || !Input::has('url')) return response('an error occured', 500);
	    $keyword = Keywords::where('keyword', Input::get('keyword'))->first();

        if(!$keyword) {
            $keyword = new Keywords();
            $keyword->keyword = Input::get('keyword');
        }

        $keyword->user_id = $user->id;
        $keyword->save();

	    $site = Sites::where('url', Input::get('url'))->where('keyword_id', $keyword->id)->first();
	    if(!$site) $site = new Sites();

	    // update site
        $site->url = Input::get('url');
        $site->Vurl = Input::get('Vurl');
        $site->title = Input::get('title');
        $site->description = Input::get('description');
        $site->page = Input::get('page');
        $site->rank = Input::get('rank');
        $site->enabled = 1;
        $site->keyword_id = $keyword->id;
        $site->user_id = $user->id;
        $site->save();

        return response('Rank updated. Please refresh the page.');
    }
	
	protected function getPureResults(){
		
		$this->AsyncRequests();
		
		// try{
			// $result = Promise\unwrap($this->promises);
		// }catch(\Exception $e){
			// echo ' chi wa7d fihom masd9ch: ' . $e->getMessage() .'<br>';
		// }
		try{
			$result = Promise\settle($this->promises)->wait();
		}catch(\Exception $e){
			// do somthing with one provider no results return
			// echo $provider . ' return 0 results : ' . $e->getMessage() .'<br>';
			// $results = [];
		}
//		 dd($result);
//		 dd(json_decode($result->getBody(), true));
		
		foreach($result as $Rprovider => $Rvalue){
//			 dd($Rvalue);
//			 dd(json_decode($Rvalue['value']->getBody(), true));
			// dd($prov);
			if($Rvalue['state'] != 'rejected'){
				if($Rprovider == 'AziziSearchEngineStarter\Http\Controllers\APIs\BingApi'){
					 $this->bingWholeResponse = json_decode($Rvalue['value']->getBody(), true);
//					 dd('df');
					if($this->cache){
						if(Cache::has($this->cacheBingWholeResponse)){
							$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
						}else{
							$this->bingWholeResponse = json_decode($Rvalue['value']->getBody(), true);
							 Cache::put($this->cacheBingWholeResponse, $this->bingWholeResponse, $this->cacheTime);
							if(empty($this->bingWholeResponse['timeZone']) || !$this->settings['timeZone']){
								Cache::put($this->cacheBingWholeResponse, $this->bingWholeResponse, $this->cacheTime);
							}else{
								if($this->settings['timeZone']) $this->cacheTimeZone = false;
							}
						}
					}else{
						$this->bingWholeResponse = json_decode($Rvalue['value']->getBody(), true);
					}
				}
				if($Rprovider == 'AziziSearchEngineStarter\Http\Controllers\APIs\GoogleApi'){
					 $this->googleWholeResponse = json_decode($Rvalue['value']->getBody(), true);
					if($this->cache){
//						if(Cache::has($this->cacheGoogleWholeResponse)){
//							$this->googleWholeResponse = Cache::get($this->cacheGoogleWholeResponse);
//						}else{
							$this->googleWholeResponse = json_decode($Rvalue['value']->getBody(), true);
                            Cache::put($this->cacheGoogleWholeResponse, $this->googleWholeResponse, $this->cacheTime);
//						}
					}else{
						$this->googleWholeResponse = json_decode($Rvalue['value']->getBody(), true);
					}
				}
			}else{
				$e = $Rvalue['reason'];
				// ila chi wa7d f APIs masd9ch
				$this->addToLog('api', 'error', 'One of the APIs: ' . $e->getMessage(), true, 'One of the APIs fail.');
				// Log::error('chi wa7d fihom masd9ch: ' . $e->getMessage());
				// echo ' chi wa7d fihom masd9ch: ' . $e->getMessage() .'<br>';
			}
		}

//		dd($this->bingWholeResponse);
		$this->classes = [];
		$results = [];
		foreach($this->providers as $provider){
			$class = new $provider();
			if(isset($result[$provider]['value'])){
				$providerResults = $result[$provider]['value'];
				$this->classes[$provider] = $class->getWeb($providerResults);
				$results = array_merge($results, $this->classes[$provider]['results']);
				$this->resultsInfo[$provider] = $this->classes[$provider]['info'];
			}
		}
		
		
		Cache::put($this->cacheSlugForInfo, $this->resultsInfo, $this->cacheTime);
		
		return $results;
	}
	
	protected function traitCache(){
		if($this->cache){
			if(Cache::has($this->cacheSlug)){
				$results = Cache::get($this->cacheSlug);
				// echo 'jmd 4i mon lcache;';
			}else{
				$results = $this->getPureResults();
				if($this->cacheTimeZone){
					
					Cache::put($this->cacheSlug, $results, $this->cacheTime);
				}
				// echo 'jmd 4i mon APIs;';
			}
		}else{
			$results = $this->getPureResults();
		}
		return $results;
	}
	
	protected function traitNewsForAll(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		$results = [];
		$config = config('bing.news');
		if(!empty($this->bingWholeResponse['news']['value'])){
			foreach($this->bingWholeResponse['news']['value'] as $key => $item){
				$results[] = [
					'title'             => array_get($item, $config['map']['Results']['title']),
					'description'       => array_get($item, $config['map']['Results']['description']),
					'url'               => $this->getUncryptedUrl(array_get($item, $config['map']['Results']['url'])),
					'provider'          => array_get($item, $config['map']['Results']['provider']),
					'datePublished'     => array_get($item, $config['map']['Results']['datePublished']),
					'thumbnail'         => array_get($item, $config['map']['Results']['thumbnail']),
				];
			}
			if(!$this->settings['showAllTypeOneTime']){ $this->oneOfAllShowed = true; }
		}else{
			return [];
		}
		
		return $results;
		// dd($this->bingWholeResponse['news']['value']);
	}
	
	protected function traitImagesForAll(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		$results = [];
		$config = config('bing.images');
		if(!empty($this->bingWholeResponse['images']['value'])){
			foreach($this->bingWholeResponse['images']['value'] as $key => $item){
				$results[] = [
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
				];
			}
			if(!$this->settings['showAllTypeOneTime']){ $this->oneOfAllShowed = true; }
		}else{
			return [];
		}
		return $results;
	}
	
	protected function traitVideosForAll(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		$results = [];
		$config = config('bing.videos');
//        dd($this->bingWholeResponse);
		if(!empty($this->bingWholeResponse['videos']['value'])){
			foreach($this->bingWholeResponse['videos']['value'] as $key => $item){
				$results[] = [
					'title'             => array_get($item, $config['map']['Results']['title']),
					'url'               => array_get($item, $config['map']['Results']['src']),
					'duration'          => $this->getDuration(array_get($item, $config['map']['Results']['duration'])),
					'publisher'         => array_get($item, $config['map']['Results']['publisher']),
					'thumbnailLink'     => array_get($item, $config['map']['Results']['thumbnailLink']),
					'views'     		=> array_get($item, $config['map']['Results']['views']),
					'date'              => $this->getTimeFormated(array_get($item, $config['map']['Results']['date'])),
					'preview'           => array_get($item, $config['map']['Results']['preview']),
				];
			}
			if(!$this->settings['showAllTypeOneTime']){ $this->oneOfAllShowed = true; }
		}else{
			return [];
		}
		
		return $results;
	}
	
	protected function traitCalculations(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		if(!empty($this->bingWholeResponse['computation'])){
			return $this->bingWholeResponse['computation'];
		}
		return [];	
	}
	
	protected function traitTimeZone(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		if(!empty($this->bingWholeResponse['timeZone'])){
			return $this->bingWholeResponse['timeZone'];
		}
		return [];	
	}
	
	protected function traitFacts(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		if(!empty($this->bingWholeResponse['facts'])){
			return $this->bingWholeResponse['facts'];
		}
		return [];	
	}
	
	protected function traitSpellSuggestions(){
		if($this->cache){
			if(Cache::has($this->cacheGoogleWholeResponse)){
				$this->googleWholeResponse = Cache::get($this->cacheGoogleWholeResponse);
			}
		}
		
		if(!empty($this->googleWholeResponse['spelling'])){
			return $this->googleWholeResponse['spelling'];
		}
		return [];	
	}
	
	protected function traitSuggestions(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}

		if(!empty($this->bingWholeResponse['relatedSearches']['value'])){
			return $this->bingWholeResponse['relatedSearches']['value'];
		}
		return [];	
	}
	
	protected function traitTranslations(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		if(!empty($this->bingWholeResponse['translations'])){
			return $this->bingWholeResponse['translations'];
		}
		return [];	
	}
	
	protected function traitEntities(){
		if($this->cache){
			if(Cache::has($this->cacheBingWholeResponse)){
				$this->bingWholeResponse = Cache::get($this->cacheBingWholeResponse);
			}
		}
		
		if(!empty($this->bingWholeResponse['entities']['value'])){
			return $this->bingWholeResponse['entities']['value'];
		}
		return [];	
	}

	protected function getResultkeyByUrl($results, $url){
        foreach($results as $key => $result){
            if($result['url'] == $url){
                return $key;
            }
        }
        return null;
    }
}
