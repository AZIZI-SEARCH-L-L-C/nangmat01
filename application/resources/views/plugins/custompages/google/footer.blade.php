@foreach(AziziSearchEngineStarter\CustomPages::get() as $page)
    <a href="{{ action('plugins\custompages\CustomPagesController@get' ,['slug' => $page->slug]) }}">{{ $page->title }}</a>
@endforeach