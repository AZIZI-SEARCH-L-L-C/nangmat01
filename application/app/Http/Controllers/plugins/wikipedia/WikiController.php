<?php

namespace AziziSearchEngineStarter\Http\Controllers\plugins\wikipedia;

use AziziSearchEngineStarter\Engines;
use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use \Illuminate\Pagination\LengthAwarePaginator;
use Cache, Input, Redirect;

class WikiController extends Controller
{

    protected $_apiURL = 'http://{lang}.wikipedia.org/w/api.php?format=json&';
    protected $_apiParams = array();
    protected $_query;
    protected $_userAgent;
    //XML vars
    protected $_XML;
    protected $_data = array();
    protected $_count = 0;
    protected $_deadSections = array('Notes', 'Further reading', 'See also', 'References', 'External links');
    //Shared vars
    protected $_string;
    protected $_json;
    protected $_cache = array();

    function __construct($userAgent = null, $language = 'en')
    {
        $this->_userAgent = $userAgent;
        $this->_apiURL = str_replace('{lang}', $language, $this->_apiURL);
        parent::__construct();
    }

    function __destruct()
    {
        $this->release();
        $this->_cache = NULL;
    }

    public function query(){
        $query = Input::get('q');
        $title = $query;
        $slug = prepSlugFromTitleWikipedia($title);
        $text = $this->getText($title, 0);
        $sections = $this->getSections($title);
        if(empty($text)) return "";
        if(empty($sections)) $sections = [];
        $data = array_merge([
            'title' => $title,
            'slug'  => $slug,
            'text' => $text,
            'wikiLink' => prepWikipediaUrlFromTitle($title),
            'sections' => $sections,
        ]);
        return view('plugins.wikipedia.'.config('app.template').'.info', $data);
    }

    public function page($slug){
        if(!config('plugins.wikipedia.enable_page')) abort(404);
        $title = prepTitleFromSlugWikipedia($slug);
        $result = $this->getHtml($title, 0);
        $engine = Engines::where('slug', 'wiki')->first();
        $data = [
            'title'    => $title,
            'query'    => $title,
            'slug'     => $slug,
            'action'   => $engine->controller.'@search',
            'name'     => $engine->slug,
            'engineDb' => $engine,
            'content'   => str_replace(['collapsible', '/wiki/'], ['', action('plugins\wikipedia\WikiController@page','').'/'], $result)
        ];
        return view('plugins.wikipedia.'.config('app.template').'.page', array_merge($this->CommonData(), $data));
    }

    public function search(){
        if(empty(Input::get('q'))){
            return Redirect::route('engine.home', ['type' => 'wiki']);
        }
        $engine = Engines::where('slug', 'wiki')->first();
        if(!$engine->turn) abort(404);
        $page = Input::get('p', 1);
        $perpage = $engine->per_page;
        $result = $this->_search(Input::get('q'), $page, $perpage);
        $total = 0;
        $realTotal = 0;
        if(!empty($result['query']['searchinfo']['totalhits'])){
            $realTotal = $result['query']['searchinfo']['totalhits'];
            if($result['query']['searchinfo']['totalhits'] > 10000) {
                $total = 10000;
            }else{
                $total = $result['query']['searchinfo']['totalhits'];
            }
        }

        $settings = $this->getSettings();
        $file = $this->getLogoInfo($engine->name, $settings);
        $logoType = $file['type'];
        $logo = $file['content'];


        $result = new \Illuminate\Pagination\LengthAwarePaginator($result['query']['search'], $total, $perpage, $page, ['pageName' => 'p', 'path' => action($engine->controller.'@search', ['q' => Input::get('q')])]);

        $data = [
            'results' => $result,
            'total' => $realTotal,
            'engine' => $engine->slug,
            'engineDb' => $engine,
            'logoType'  => $logoType,
            'logo'      => $logo,
        ];

        view()->share($data);
        return view('plugins.wikipedia.'.config('app.template').'.results', array_merge($this->CommonData(), $data));
    }

    /**
     *
     * Performs a wikipedia search for the supplied query, returns the results
     *
     * @param $query string
     * @param $numResult int
     * @return array|mixed
     */
    private function _search($query, $page, $numResult)
    {
        if($numResult == null){
            $numResult = 10;
        }

        $offset = $numResult * ($page-1);
        $this->_query = urlencode($query);
        $this->_apiParams['action'] = 'query';
        $this->_apiParams['params'] = array(
            "srlimit={$numResult}",
            "sroffset={$offset}",
            "list=search",
            "srsearch={$this->_query}",
        );
        $result = $this->callApi();
        $result = $this->parseSearch($result);
        $this->release();
        return $result;
    }

    /**
     *
     * Returns a multidimensional array containing the TOC of the supplied page
     *
     * @param $title string
     * @return array|mixed
     */
    private function getSections($title)
    {
        $this->_apiParams['action'] = 'parse';
        $this->_apiParams['params'] = array(
            "prop=sections",
            "page={$this->prepTitle($title)}",
            "redirects=true",
        );
        $result = $this->callApi();
        $result = $this->parseSections($result);
        $this->release();
        return $result;
    }

    /**
     *
     * Reruns parsed page text
     *
     * @param $title string
     * @param $section int
     * @return mixed|string
     */
    private function getText($title, $section)
    {
        $this->_apiParams['action'] = 'query';
        $this->_apiParams['params'] = array(
            "prop=revisions",
            "titles={$this->prepTitle($title)}",
            "redirects=true",
            "rvprop=content",
            "rvlimit=1",
            "rvsection={$section}",
        );
        $result = $this->callApi();
        $result = $this->parseText($result, $section);
        $this->release();
        return str_limit($result, 250, '. —');
    }

    /**
     *
     * Reruns parsed page text
     *
     * @param $title string
     * @param $section int
     * @return mixed|string
     */
    private function getHtml($title)
    {
        $this->_apiParams['action'] = 'parse';
        $this->_apiParams['params'] = array(
            "prop=text",
            "redirects=true",
            "page={$this->prepTitle($title)}",
        );
        $result = $this->callApi();
        $result = $this->parseHTML($result);
        $this->release();
        return $result;
    }

    /**
     *
     * Returns an array of related pages to the supplied page
     *
     * @param $title string
     * @return array|mixed|string
     */
    private function getRelated($title)
    {
        $title = $this->prepTitle($title);
        $this->_data = $this->getSections($title);
        $this->_string = count($this->_data) + 1;
        $result = $this->getText($title, $this->_string);
        $result = preg_replace('/==(.*?)\==/s', '', $result);
        $result = str_replace("\r\n", "\n", $result);
        $result = str_replace("*", '', $result);
        $result = explode("\n", $result);
        $result = array_filter(array_map('trim', $result));
        $this->release();
        return json_encode($result);

    }

    /**
     * Releases the class properties to prevent the "complex types" error
     */
    private function release()
    {
        $this->_apiParams = NULL;
        $this->_query = NULL;
        //XML vars
        $this->_XML = NULL;
        $this->_data = NULL;
        //Shared
        $this->_string = NULL;
    }

    /**
     * Releases the cache property on-demand
     *
     * @author Gonçalo Sá <goncalo05@gmail.com>
     */
    private function release_cache()
    {
        $this->_cache = NULL;
    }

    /**
     *
     * Preps titles for use
     *
     * @param $string string
     * @return mixed
     */
    private function prepTitle($string)
    {
        $string = str_replace(' ', '_', $string);
        $string = htmlspecialchars($string);
        return $string;
    }

    /**
     *
     * Calls the wikmedia API
     *
     * @return mixed
     */
    private function callApi()
    {
        $params = implode('&', $this->_apiParams['params']);
        $url = "{$this->_apiURL}action={$this->_apiParams['action']}&{$params}";
//        $url = "{$this->_apiURL}action=render&{$params}";
//        dd($url);
        $result = file_get_contents($url);
        return $result;
//        if(!Cache::has($url)) {
//            dd(file_get_contents($url));
//            $curl = curl_init();
//            curl_setopt($curl, CURLOPT_URL, $url);
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//            curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
//            $result = curl_exec($curl);
//            $this->_cache[$url] = $result;
//            dd($result);
//            $result = file_get_contents($url);
//            cache::put($url, $result, 60 * 60 * 24 * 30); // cache it for one month
//            return $result;
//        }
//        return cache::get($url);
    }

    //XML parsing methods

    /**
     *
     * Parses the Search results
     *
     * @param $json mixed
     * @return array
     */
    private function parseSearch($json)
    {
        $arr = json_decode($json, true);
        return $arr;
    }

    /**
     *
     * Parses the getSections results
     *
     * @param $json mixed
     * @return array
     */
    private function parseSections($json)
    {
        // TODO: Possibly return as multidimensional array, using index/position as markers...
        $this->_count = 0;
        $arr = json_decode($json, true);
        if(!empty($arr['parse']['sections'])) {
            foreach ($arr['parse']['sections'] as $section) {
                if (!in_array($section['line'], $this->_deadSections)) {
                    $this->_data[$this->_count] = array(
                        'title' => "{$section['line']}",
                        'index' => "{$section['index']}",
                        'position' => "{$section['number']}",
                        'anchor' => "{$section['anchor']}"
                    );
                    $this->_count++;
                }
            }
            return $this->_data;
        }
        return null;
    }

    /**
     *
     * Parses the getText results
     *
     * @param $json mixed
     * @param $section int
     * @return mixed|string
     */
    private function parseText($json, $section)
    {
        $arr = json_decode($json, true);
        $string = '';
        if(!empty($arr['query']['pages'])){
            $page = array_first($arr['query']['pages']);
            if(!empty($page['revisions'][0]['*'])){
                $string = $page['revisions'][0]['*'];
            }
        }

        if ($section == 0) {
            $string = strstr($string, '\'\'\''); //This removes the images/info box if the section is the summary
            $string = str_replace('\'\'\'', '"', $string); //Replaces the ''' around titles to be "
        }
        $string = preg_replace('/<ref[^>]*>[^<]+<\/ref[^>]*>|\{{(?>[^}]++|}(?!}))\}}|==*[^=]+=*\n|File:(.*?)\n|\[\[|\]]|\n/', '', $string); //Compliments of Jerry [http://unknownoo8.deviantart.com/]
        //|\s{2,}
        $string = str_replace('|', '/', $string); //Makes the wikilinks look better
        $string = strip_tags($string); //Just in case
        return $string;
    }

    /**
     *
     * Parses the getHTML results
     *
     * @param $json mixed
     * @param $section int
     * @return mixed|string
     */
    private function parseHTML($json)
    {
        $arr = json_decode($json, true);
        if(!empty($arr['parse']['text']['*'])) {
            return $arr['parse']['text']['*'];
        }
        return null;
    }

}
