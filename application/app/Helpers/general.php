<?php

use AziziSearchEngineStarter\Settings;

if (! function_exists('settings')) {  
	function settings($key = null) {
		if(config('cache.enabled')){
			if(cache()->has('settings')){
				$settings = cache()->get('settings');
			}else{
				$settings = Settings::pluck('value', 'name')->all();
				cache()->forever('settings', $settings);
			}
		}else{
			$settings = Settings::pluck('value', 'name')->all();
		}
		
		if(!$key) return $settings;
		return $settings[$key];
	}
}

if (! function_exists('in_array_array')) {  
	function in_array_array($needle, $haystack, $and = false)
    {
        if (!is_array($haystack)) {
            if (in_array($haystack, $needle)){
                return true;
            }else{
                return false;
            }
    }
		foreach ($needle as $Cneedle) {
			if(!$and){
				if(in_array($Cneedle, $haystack)) return true;
			}else{
				if(!in_array($Cneedle, $haystack)) return false;
			}
		}
		if(!$and){
			return false;
		}else{
			return true;
		}
	}
}

if (! function_exists('getUncryptedUrl')) {  
	function getUncryptedUrl($url){
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $parsed_str);
		if(!empty($parsed_str['r'])){
			return $parsed_str['r'];
		}
		return $url;
    }
}

if (! function_exists('boldQueryWords')) {  
	function boldQueryWords($query, $string){
		$words = explode(' ', $query);
		foreach($words as $word){
			if(strlen($word) > 2){ $string = str_ireplace($word, '<b>'.$word.'</b>', $string); }
		}
		return $string;
    }
}

if (! function_exists('get_readable_time')) {  
    function get_readable_time($created_at, $format) {
        return date($format, strtotime($created_at));
    }
}

if (! function_exists('get_time_ago')) {  
    function get_time_ago($created_at, $full = false) {
        // return date($format, strtotime($created_at));
		
		$now = new DateTime;
		$ago = new DateTime($created_at);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

if (! function_exists('getUserThumbnail')) {  
    function getUserThumbnail($user = false) {
        if($user){
            if (empty($user->img))
                return url('assets/templates/default/imgs/no_user.png');
            return $user->img;
        }else {
            if (!auth()->check()) return '';
            if (empty(auth()->user()->img))
                return url('assets/templates/default/imgs/no_user.png');
            return auth()->user()->img;
        }
    }
}

if (! function_exists('siteDirection')) {
    function siteDirection() {
        switch ('latin'){
//        switch (config('locdet.supportedLocales.'.config('app.locale').'.script')){
            case 'Arab':
            case 'Hebr':
            case 'Mong':
            case 'Tfng':
            case 'Thaa':
                return 'rtl';
            default:
                return 'ltr';
        }
    }
}