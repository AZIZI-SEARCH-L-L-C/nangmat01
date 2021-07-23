<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use AziziSearchEngineStarter\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input, Redirect, Cache, Request;

class ImagesController extends Controller
{
	
	// web api providers
	private $providers;
	
	private $type = 'images';
	
	private $query;
	
	private $commonData;
	
	private $page;
	
	private $cachedPage;
	
	private $cacheTime;
	
	private $defferCacheTime;
	
	private $cachedCurrentPageSlug;
	
	private $cachedPreviousPageSlug;
	
	private $perpage;
	
	private $ajaxPerpage;
	
	private $cacheSlug;
	
	private $pages;
	
	private $parametrs = '';
	
	private $promises = [];
	
	private $resultsInfo = [];
	
	private $cacheSlugForInfo;
	
	public function __construct(){
		$this->query = Input::get('q');
		$this->commonData = $this->CommonData(true, $this->query, $this->type);
		$this->settings = $this->commonData['settings'];
		$this->page = (Input::get('p', 1) < 1) ? 1 : Input::get('p', 1);
		$this->perpage = $this->settings['perPageImages'];
		$this->ajaxPerpage = 150;
		$this->cacheTime = $this->settings['cacheTime'];
		$this->defferCacheTime = $this->settings['defferCacheTime'];
		$this->cache = $this->settings['cache'];
		$this->cachedPage = $this->page - 1;
		foreach(Request::all() as $q => $v){
			$this->parametrs .= "$q=$v-";
		}
		$this->pages = 10;
		$this->cachedCurrentPageSlug = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-deferred';
		$this->cachedPreviousPageSlug = $this->query.'-'.$this->type.'-'.$this->cachedPage.'-'.$this->perpage.'-deferred';
		$this->cacheSlug = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parametrs.'-cacheRequest';
		$this->cacheSlugForInfo = $this->query.'-'.$this->type.'-'.$this->page.'-'.$this->perpage.'-'.$this->parametrs.'-cacheRequestForInfo';
		$this->providers = config('app.apiImagesProviders');
	}
	
	public function search (){
		
		// \Artisan::call('cache:clear');
		
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
					$results = $this->traitCache(false);
					$results = array_merge($results, $cachedPreviousPage);
				}else{
					// echo 'jbd 4i mn lcache: ' . count($cachedPreviousPage);
					$results = $cachedPreviousPage;
				}
			}else{
				$results = $this->traitCache(false);
			}
		}else{
			$results = $this->traitCache(false);
		}
		
		if(count($this->providers) > 1){
			$results = $this->removeDuplicateResults($results);
		}
		// dd($results);
		
		// set results Info
		$totalResults = 0;
		if($this->cache){
			if(Cache::has($this->cacheSlugForInfo)){
				$this->resultsInfo = Cache::get($this->cacheSlugForInfo);
			}
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

        $paginated = new \StdClass();
        if ($this->settings['imagesPagination'] == 2) {
            $total = intval(str_replace(',', '', $totalResults));
            if($this->settings['imagesPaginationFull']) {
                $paginated = new Paginator($results, $total, $this->settings['perPageImages'], Input::get('p', 1), ['path' => action('ImagesController@search'), 'pageName' => 'p']);
            }else{
                $totalAllowed = $this->settings['imagesPaginationLimit'] * $this->settings['perPageImages'];
                if($total > $totalAllowed)
                    $total = $totalAllowed;
                $paginated = new Paginator($results, $total, $this->settings['perPageImages'], Input::get('p', 1), ['path' => action('ImagesController@search'), 'pageName' => 'p']);
            }
        }

		$pageData = [
		    'results'        => $results,
			'page'           => $this->page,
			'pages'          => $this->pages,
			'totalResults'   => $totalResults,
			'lastPage'       => $lastPage,
			'paginated'      => $paginated,
		];
		
		$data = array_merge($this->commonData, $pageData, $preparedFilters);

        $data['renderTime'] = round((microtime(true) - LARAVEL_START) / 3, 2);
		
		// return the view with the data & the common data
		return view('engines.'.$this->type, $data);
	}
	
	public function imagesAjax(){
		
		if($this->page > 5) return false;
		
		if($this->cache){
			if($this->page > 1 && Cache::has($this->cachedPreviousPageSlug)){
				$cachedPreviousPage = Cache::get($this->cachedPreviousPageSlug);
				// boost score for results from the previous page
				foreach($cachedPreviousPage as $resultsKey => $cachedResult){
					$cachedPreviousPage[$resultsKey]['score'] += 10;
				}
				if(count($cachedPreviousPage) < $this->ajaxPerpage){
					$results = $this->traitCache(true);
					$results = array_merge($results, $cachedPreviousPage);
				}else{
					$results = $cachedPreviousPage;
				}
			}else{
				$results = $this->traitCache(true);
			}
		}else{
			$results = $this->traitCache(true);
		}
		
		$results = $this->removeDuplicateResults($results);
		
		
		// defer results for this query for next pages
		$deferred = array_slice($results, $this->perpage);
		if(count($deferred)){
			Cache::put($this->cachedCurrentPageSlug, $deferred, $this->defferCacheTime);
		}
		
		return $results;
	}
	
	protected function prepareFilters(){
		$config = config('google.images');
		
		// image colors filters
		$colors = $config['color'];
		$color = Input::get('c');
		
		// image types filters
 		$imgTypes = $config['type'];
		$imgTypesK = array_keys($config['type']);
		$imgType = Input::get('t');
		
		// image license filter
		$licenses = $config['license'];
		$licensesK = array_keys($config['license']);
		$license = Input::get('l');
		
		// image size filters
		$imgSizes = $config['size'];
		$imgSizesK = array_keys($config['size']);
		$imgSize = Input::get('s');
		
		$hasFilters = in_array($color, $colors) || in_array($imgType, $imgTypesK) || in_array($license, $licensesK) || in_array($imgSize, $imgSizes);
		
		$filters = [
			'colors'         => $colors,
			'color'          => $color,
			'imgTypes'       => $imgTypes,
			'imgTypesK'      => $imgTypesK,
			'imgType'        => $imgType,
			'licenses'       => $licenses,
			'licensesK'      => $licensesK,
			'license'        => $license,
			'imgSizes'       => $imgSizes,
			'imgSizesK'      => $imgSizesK,
			'imgSize'        => $imgSize,
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
			$titles_urls[$key]['src'] = $val['src'];
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
			    similar_text($val1['src'], $val2['src'], $titleSim);
				$titleSim = round($titleSim / 100, 2);
				$similarityMean = round(($urlSim + $titleSim) / 2, 2);
			    if($similarityMean > $similarityThreshold){
					$similarIDs[$key1] = $key2;
				}
			    // if($similarityMean >= $similarityThreshold) echo $key1.' '.$val1['url'] . ' => ' . $val1['src'] .' // '. $key2.' '. $val2['url'] . ' => '. $val2['src'] . ' ===> ' . $urlSim . ' --- ' . $titleSim . '<br>'.$similarityMean.'<br>--------------------------<br><br>';
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
		
		// dd($results);
		
		// sort results depending on it's new score
		uasort($results, function($a, $b){
            if ($a['score'] == $b['score']) {
                return 0;
            }
            return ($a['score'] < $b['score']) ? 1 : -1;
	    });
		
		return $results;
	}
	
	public function AsyncRequests($moreResults){
		$client = new Client();
		// Initiate each request but do not block
		foreach($this->providers as $provider){
			$class = new $provider();
			
			// ----
			// $ss = $class->getImagesParams($this->query, $this->page, $this->commonData, $moreResults);
			// $quersdd = http_build_query($ss['query']);
			// dd($class->imagesEndpoint.'?'.$quersdd);
			// ----
//            dd($class->imagesEndpoint .'?'. http_build_query(array_get($class->getImagesParams($this->query, $this->page, $this->commonData, $moreResults), 'query')));
			$this->promises[$provider] = $client->getAsync($class->imagesEndpoint, $class->getImagesParams($this->query, $this->page, $this->commonData, $moreResults));
		}
	}
	
	protected function getPureResults($moreResults){
		
		$this->AsyncRequests($moreResults);
		
		// $result = Promise\unwrap($this->promises);
		try{
			$result = Promise\settle($this->promises)->wait();
		}catch(\Exception $e){
			// do somthing with one provider no results return
			// echo $provider . ' return 0 results : ' . $e->getMessage() .'<br>';
			// $results = [];
		}
		
		foreach($result as $key => $prov){
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
				// $results = $class->getWeb($query, $page, $perpage, $common, $providerResults);
				$classes[$provider] = $class->getImages($providerResults);
				$results = array_merge($results, $classes[$provider]['results']);
				$this->resultsInfo[$provider] = $classes[$provider]['info'];
			}
		}
		Cache::put($this->cacheSlugForInfo, $this->resultsInfo, $this->cacheTime);
		return $results;
	}
	
	protected function traitCache($moreResults){
		if($this->cache){
			if(Cache::has($this->cacheSlug)){
				$results = Cache::get($this->cacheSlug);
				// echo 'jmd 4i mon lcache; ' . count($results);
			}else{
				$results = $this->getPureResults($moreResults);
				Cache::put($this->cacheSlug, $results, $this->cacheTime);
				// echo 'jmd 4i mon APIs;';
			}
		}else{
			$results = $this->getPureResults($moreResults);
		}
		return $results;
	}
	
}
