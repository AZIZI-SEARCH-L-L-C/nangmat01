<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use AziziSearchEngineStarter\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input, Redirect, Cache, Request;

class NewsController extends Controller
{
	// news api providers
	private $providers;
	
	private $type = 'news';
	
	private $query;
	
	private $cacheTime;
	
	private $commonData;
	
	private $defferCacheTime;
	
	private $perpage;
	
	private $promises = [];
	
	private $parametrs;
	
	private $pages;
	
	private $cacheSlug;
	
	private $webPagination;
	
	private $cacheSlugForInfo;
	
	private $resultsInfo = [];
	
	public function __construct(){
		$this->query = Input::get('q');
		$this->commonData = $this->CommonData(true, $this->query, $this->type);
		$this->settings = $this->commonData['settings'];
		$this->page = (Input::get('p', 1) < 1) ? 1 : Input::get('p', 1);
		$this->pages = 10;
		
		$this->perpage = $this->settings['perPageNews'];
		$this->cacheTime = $this->settings['cacheTime'];
		$this->defferCacheTime = $this->settings['defferCacheTime'];
		$this->providers = config('app.apiNewsProviders');
		$this->cache = $this->settings['cache'];
		
		foreach(Request::all() as $q => $v){
			$this->parametrs .= "$q=$v-";
		}
		
		$this->cachedPage = $this->page - 1;
		$this->cachedCurrentPageSlug = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-deferred';
		$this->cachedPreviousPageSlug = $this->query.'-'.$this->type.'-'.$this->cachedPage.'-'.$this->perpage.'-deferred';
		$this->cacheSlug = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parametrs.'-cacheRequest';
		$this->cacheSlugForInfo = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parametrs.'-cacheRequestForInfo';
		
		$this->webPagination = $this->settings['newsPagination'];
	}
	
	public function search (){
		
		// Cache::tags('results')->flush();
		// Cache::flush();
		
		if(!Input::has('q')){
			return Redirect::action('GeneralController@indexType', ['type' => $this->type]);
		}
		
		// filters options
		$preparedFilters = $this->prepareFilters();
		
	
		if($this->cache){
			if($this->page > 1 && Cache::has($this->cachedPreviousPageSlug)){
				$cachedPreviousPage = Cache::get($this->cachedPreviousPageSlug);
				// boost score for results from the previous page
				foreach($cachedPreviousPage as $resultsKey => $cachedResult){
					$cachedPreviousPage[$resultsKey]['score'] += 20;
				}
				if(count($cachedPreviousPage) < $this->perpage){
					// echo 'jbd cache: '. count($cachedPreviousPage);
					$results = $this->traitCache();
					$results = array_merge($results, $cachedPreviousPage);
				}else{
					// echo 'jbd 4i mn lcache: ' . count($cachedPreviousPage);
					$results = $cachedPreviousPage;
				}
			}else{
				$results = $this->traitCache();
			}
		}else{
			$results = $this->traitCache();
		}
	
	    // dd($results);
		if(count($this->providers) > 1){
			$results = $this->removeDuplicateResults($results);
		}
		
		// set results Info
		$totalResults = 0;
		if($this->cache){
			if(Cache::has($this->cacheSlugForInfo)){
				$this->resultsInfo = Cache::get($this->cacheSlugForInfo);
			}
		}
		
		if(!empty($this->resultsInfo['AziziSearchEngineStarter\Http\Controllers\BingApi'])){
			$sorts = $this->resultsInfo['AziziSearchEngineStarter\Http\Controllers\BingApi']['sort'];
		}else{
			$sorts = [];
		}
		
		foreach($this->resultsInfo as $resultInfo){
			$totalResults += (float) $resultInfo['total'];
		}
		
		$totalResults = number_format($totalResults, 0, '.', ',');
		
		// defer results for this query for next pages
		$deferred = array_slice($results, $this->perpage);
		if(count($deferred)){
			Cache::put($this->cachedCurrentPageSlug, $deferred, $this->defferCacheTime);
		}
		
		$lastPage = false;
		// if(count($results) <= $this->perpage) $lastPage = true;
		$results = array_slice($results, 0, $this->perpage);
		
		// number of page but need to be improved // for numbers pagination (2)
		if($this->page >= $this->pages) $lastPage = true;
		
		// dd($lastPage);

        $paginated = new \StdClass();
        if ($this->settings['newsPagination'] == 2) {
            $total = intval(str_replace(',', '', $totalResults));
            if($this->settings['newsPaginationFull']) {
                $paginated = new Paginator($results, $total, $this->settings['perPageNews'], Input::get('p', 1), ['path' => action('NewsController@search'), 'pageName' => 'p']);
            }else{
                $totalAllowed = $this->settings['newsPaginationLimit'] * $this->settings['perPageNews'];
                if($total > $totalAllowed)
                    $total = $totalAllowed;
                $paginated = new Paginator($results, $total, $this->settings['perPageNews'], Input::get('p', 1), ['path' => action('NewsController@search'), 'pageName' => 'p']);
            }
        }
		
		// data that will be passed to the view template
		$pageData = [
		    'results'        => $results,
			'page'           => $this->page,
			'pages'          => $this->pages,
			'sorts'          => $sorts,
			'sort'           => Input::get('s', ''),
			'totalResults'   => $totalResults,
			'lastPage'       => $lastPage,
			'paginated'      => $paginated,
		];
		
		$data = array_merge($this->commonData, $pageData, $preparedFilters);

        $data['renderTime'] = round((microtime(true) - LARAVEL_START) / 3, 2);
		
		return view('engines.'.$this->type, $data);
		
	}
	
	protected function prepareFilters(){
		// time filters
		$dates = [0 => 'past 24 hours', 1 => 'past week', 2 => 'past month'];
		$datesK = array_keys($dates);
		$date = Input::get('d', -1);

        // region filters
        $region = Input::get('c');
        $firstCountries = explode(',', $this->settings['firstCountries']);
        $countries = explode(',', $this->settings['countries']);

		// check if search has filter or not
		$hasFilters = in_array($date, $datesK) || in_array($region, $countries);
		
		$filters = [
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
		if($queryWordsCount == 1){$similarityThreshold = 0.90;}else{$similarityThreshold = 0.85;}
		
		// fetch just IDs, urls & titles to use it to detect similar results
		$titles_urls = [];
		foreach($results as $key => $val){
			$titles_urls[$key]['title'] = $val['title'];
			$titles_urls[$key]['url'] = $val['url'];
		}
		
		// get an array that contain just ID vs ID similar results
		$similarIDs = [];
		foreach($titles_urls as $key1 => $val1){ 
			foreach(array_except($titles_urls, $key1) as $key2 => $val2){ 
			    // $urlSim = $o->compare($val1['url'], $val2['url']);
			    // $titleSim = $o->compare($val1['title'], $val2['title']);
				similar_text($val1['url'], $val2['url'], $urlSim);
				$urlSim = round($urlSim / 100, 2);
			    similar_text($val1['title'], $val2['title'], $titleSim);
				$titleSim = round($titleSim / 100, 2);
				$similarityMean = round(($urlSim + $titleSim) / 2, 2);
			    if($similarityMean > $similarityThreshold){
					$similarIDs[$key1] = $key2;
				}
			    // if($similarityMean >= $similarityThreshold) echo $key1.' '.$val1['url'] . ' => ' . $val1['title'] .' // '. $key2.' '. $val2['url'] . ' => '. $val2['title'] . ' ===> ' . $urlSim . ' --- ' . $titleSim . '<br>'.$similarityMean.'<br>--------------------------<br><br>';
			}
		}
		
		// get just non-doubled similar ID vs ID results
		$nonDoubledIDs = [];
		$tempDoubledIDs = [];
		foreach($similarIDs as $key => $val){
			if(!in_array($key, $tempDoubledIDs)){
			    $tempDoubledIDs[] = $val;
				if(!in_array($val, array_values($nonDoubledIDs))){
					$nonDoubledIDs[$key] = $val;
				}
			}
		}
		
		arsort($nonDoubledIDs);
		
		// remove duplicated results & boost score of doubled
		foreach($nonDoubledIDs as $leftID => $removeID){
			$spread = abs($results[$removeID]['order'] - $results[$leftID]['order']);
			$mean = ($results[$leftID]['order'] + $results[$removeID]['order']) / 2;
			$results[$leftID]['score'] += 10 / ($mean + $spread);
			
			unset($results[$removeID]);
		}
		
		// sort results depending on it's new score
		uasort($results, function($a, $b){
            if ($a['score'] == $b['score']) {
                return 0;
            }
            return ($a['score'] < $b['score']) ? 1 : -1;
	    });
		
		return $results;
	}
	
	public function AsyncRequests(){
		$client = new Client();
		// Initiate each request but do not block
		foreach($this->providers as $provider){
			$providerClass = new $provider();
			$this->promises[$provider] = $client->getAsync($providerClass->newsEndpoint, $providerClass->getNewsParams($this->query, $this->page, $this->commonData));
		}
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
		
		// dd(json_decode($result->getBody(), true));
		// dd($result);
		
		foreach($result as $prov){
			// dd(json_decode($prov['value']->getBody(), true));
			// dd($prov);
			if($prov['state'] == 'rejected'){
				$e = $prov['reason'];
				// ila chi wa7d f APIs masd9ch
                $this->addToLog('api', 'error', 'One of the APIs: ' . $e->getMessage(), true, 'One of the APIs fail.');
			}
		}
		
		$classes = [];
		$results = [];
		foreach($this->providers as $provider){
			$class = new $provider();
			if(isset($result[$provider]['value'])){
				$providerResults = $result[$provider]['value'];
				$classes[$provider] = $class->getNews($providerResults);
				$results = array_merge($results, $classes[$provider]['results']);
				$this->resultsInfo[$provider] = $classes[$provider]['info'];
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
				Cache::put($this->cacheSlug, $results, $this->cacheTime);
				// echo 'jmd 4i mon APIs;';
			}
		}else{
			$results = $this->getPureResults();
		}
		return $results;
	}
}
