<ul>
    @foreach(AziziSearchEngineStarter\CustomPages::get() as $page)
        <li><a href="{{ action('plugins\custompages\CustomPagesController@get' ,['slug' => $page->slug]) }}">{{ $page->title }}</a></li>
    @endforeach
</ul>