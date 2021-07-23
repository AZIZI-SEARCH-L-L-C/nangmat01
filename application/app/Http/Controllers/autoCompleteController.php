<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use GuzzleHttp\Client;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use Input, LaravelLocalization;

class autoCompleteController extends Controller
{
    
    public function suggetions()
    {
        $keywords = $this->keywords();
		$keywords = json_encode($keywords);
        return $keywords;
    }

	public static function keywords (){
		
		$keywords = [];
		
		if(! Input::has('q')) return $keywords;
		
		$client = new Client();
        $result = $client->get('https://suggestqueries.google.com/complete/search', [
		    'query' => [
		        'q'      => Input::get('q'),
                'output' => 'firefox',
            ],
        ]);

		$json = json_decode(utf8_encode($result->getBody()));
		
		if(!is_array($json[1])){
			$json[1] = array();
		}
		$i = 0;
		foreach($json[1] as $keyword){
			$keyword = str_replace(Input::get('q'), '<b>'.Input::get('q').'</b>', $keyword);
			$keywords[$i] = $keyword;
			$i++;
		}

		unset($keywords[0]);
		
		return $keywords;
		
	}
	
	public static function auto (){
		
		$keywords = [];
		
		if(! Input::has('q')) return $keywords;
		
		$client = new Client();
        $result = $client->get('https://suggestqueries.google.com/complete/search', [
		    'query' => [
		        'q'      => Input::get('q'),
                'output' => 'firefox',
            ],
        ]);

        $json = json_decode(utf8_encode($result->getBody()));

		if(!isset($json[1]) || !is_array($json[1])){
			$json[1] = array();
		}
		$i = 0;
		foreach($json[1] as $keyword){
			$keyword = str_replace(Input::get('q'), '<b>'.Input::get('q').'</b>', $keyword);
			$keywords[$i] = $keyword;
			$i++;
		}

		unset($keywords[0]);
		
		$words = '';
		foreach($keywords as $word){
			$words .= '"' . $word . '",';
		}
		if(ends_with($words, ',')) $words = rtrim($words, ','); 
		
		$string = 'try{ase_ac_new({query:"'. Input::get('q') .'","items":[' . $words . ']});}catch(e){}';
		return $string;
		// return $keywords;
		
	}
}
