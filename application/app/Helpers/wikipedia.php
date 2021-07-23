<?php

if (! function_exists('prepSlugFromTitleWikipedia')) {
    function prepSlugFromTitleWikipedia($string) {
        $string = str_replace(' ', '_', $string);
        $string = htmlspecialchars($string);
        return $string;
    }
}

if (! function_exists('prepTitleFromSlugWikipedia')) {
    function prepTitleFromSlugWikipedia($slug) {
        $string = str_replace('_', ' ', $slug);
        return $string;
    }
}

if (! function_exists('prepWikipediaUrlFromTitle')) {
    function prepWikipediaUrlFromTitle($title) {
        $slug = prepSlugFromTitleWikipedia($title);
        if(config('plugins.wikipedia.enable_page')){
            return action('plugins\wikipedia\WikiController@page', $slug);
        }
        return 'https://en.wikipedia.org/wiki/'.$slug;
    }
}
if (! function_exists('prepVisibleWikipediaUrlFromTitle')) {
    function prepVisibleWikipediaUrlFromTitle($title) {
        $slug = prepSlugFromTitleWikipedia($title);
        if(config('plugins.wikipedia.enable_page')) {
            return str_replace(['http://', 'https://'], '', action('plugins\wikipedia\WikiController@page', prepSlugFromTitleWikipedia($title)));
        }
        return 'en.wikipedia.org/wiki/'.$slug;
    }
}