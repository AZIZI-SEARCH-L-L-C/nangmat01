<style type="text/css">
    .ctt * {
        margin: 0;
        padding: 0;
    }
    div.ctt {
        background-color: #ffffff;
        color: #393e46;
        font-family: arial, arial, sans-serif;
        font-size: 13px;
        line-height: 15px;
    }
    .ctt .clearfix:before,
    .ctt .clearfix:after {
        content: " ";
        display: table;
    }
    .ctt .clearfix:after {
        clear: both;
    }
    .ctt .clearfix {
        *zoom: 1;
    }
    .ctt a {
        color: #393e46;
        text-decoration: none;
    }
    .ctt a:hover {
        text-decoration: none;
    }
    .ctt a img {
        border: none;
    }
    .ctt h3 {
        color: #393e46;
        font-size: 14px;
        font-weight: normal;
        margin-bottom: 3px;
    }
    .ctt h3 a {
        color: #393e46;
    }
    .ctt h3 .q {
        font-weight: bold;
    }
    .ctt h3 .meta {
        color: #aaa;
        display: inline-block;
        float: right;
        font-size: 12px;
    }
    .ctt ul.items li {
        border: 1px solid transparent;
        display: block;
        float: left;
        list-style: none;
        margin: 0 0 5px 0;
        padding: 0;
        position: relative;
        width: 100px;
    }
    .ctt ul.items li:hover {
        border-color: #eee;
    }
    .ctt ul.items .inner > div {
        margin-left: 5px;
        margin-right: 5px;
    }
    .ctt ul.items .img {
        background-position: center center;
        background-repeat: no-repeat;
        background-size: contain;
        border: 0;
        height: 90px;
        margin: 5px 10px;
    }
    .ctt .items .meta {
        font-size: 11px;
        color: #aaa;
        height: 15px;
        line-height: 15px;
        overflow: hidden;
    }
    .ctt ol.items li {
        list-style: none;
    }
    .ctt ul.items a {
        color: #393e46;
    }
    .ctt ul.items .meta {
        text-align: right;
    }
    .ctt ul.items .price {
        font-size: 11px;
        font-weight: bold;
    }
    .ctt ul.items .title {
        overflow: hidden;
    }

    /** Images */
    .ctt .image .img {
        height: 90px;
        overflow: hidden;
    }

    .ctt .image .img .inner {
        text-align: center;
    }

    /** News */
    .ctt .news a {
        color: #393e46;
    }
    .ctt .news a:hover {
        text-decoration: underline;
    }
    .ctt .news .item {
        list-style: none;
        margin-bottom: 5px;
    }
    .ctt .news .thumb {
        font-size: 11px;
        float: left;
        height: 80px;
        margin-top: 2px;
        width: 80px;
    }
    .ctt .news .thumb a.src {
        color: #aaa;
        display: inline-block;
        height: 16px;
        line-height: 16px;
        overflow: hidden;
    }
    .ctt .news .thumb img {
        max-height: 80px;
        max-width: 80px;
    }
    .ctt .news .inner.has-thumb {
        margin-left: 90px;
        margin-bottom: 10px;
    }
    .ctt .news .item .title {
        max-height: 15px;
        margin-bottom: 1px;
        overflow: hidden;
    }
    .ctt .news .item p {
        margin: 3px 0 0;
        line-height: 15px;
        max-height: 75px;
        overflow: hidden;
    }
    .ctt .news .item ol {
        margin-top: 6px;
    }
    .ctt .news .item li {
        color: #aaa;
        display: list-item;
        list-style: disc inside none;
        max-height: 15px;
        overflow: hidden;
    }
    .ctt .news .item a {
        color: #2775bd;
    }
    .ctt .news .item li a:hover {
        text-decoration: underline;
    }
    .ctt .news .item ol li .src {
        font-size: 12px;
    }
    .ctt .news li.first {
        margin-bottom: 15px;
    }

    /** Shopping */
    .ctt .shopping .item:hover {
        cursor: pointer;
    }
    .ctt .shopping .item .merchant {
        font-size: 11px;
        color: #aaa;
        height: 15px;
        line-height: 15px;
        overflow: hidden;
    }
    .ctt .shopping .item .title {
        height: 45px;
        line-height: 15px;
        overflow: hidden;
    }
    .ctt .shopping .item .title span {
        display: block;
        font-weight: bold;
    }
    .ctt .shopping-fashion h3 {
        font-size: 13px;
    }
    .ctt .shopping-fashion ul.items .title {
        height: 30px;
        color: #29298f;
    }
    .ctt .shopping-fashion .item .price {
        color: #000;
        font-size: 13px;
        font-weight: bold;
    }
    .ctt .shopping-fashion .item .merchant {
        font-size: 13px;
        color: #0e7744;
    }
    .ctt .shopping-fashion ul.items li {
        width: 110px;
    }
    .ctt .shopping-fashion ul.items li.item-more {
        width: auto;
        margin: 0 0 0 7px;
        padding-top: 70px;
    }
    .ctt .shopping-fashion ul.items li.item-more:hover {
        border-color: #fff;
    }
    .ctt .shopping-fashion ul.items li.item-more a {
        display: block;
        width: 28px;
        height: 28px;
        font-size: 22px;
        line-height: 26px;
        color: #777;
        border: 1px solid #eee;
        border-radius: 14px;
        text-align: center;
        text-decoration: none;
    }
    .ctt .shopping-fashion ul.items li.item-more a:hover {
        color: #656565;
    }

    /** Video */
    .ctt .video a:hover {
        text-decoration: underline;
    }
    .ctt .video .item {
        margin-bottom: 10px;
    }
    .ctt .video .item .title {
        background: url('/content/static/image/video_play_icon.png') no-repeat left center;
        display: block;
        line-height: 21px;
        max-height: 21px;
        overflow: hidden;
        padding-left: 27px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .ctt .video .item .description {
        color: #aaa;
        font-size: 12px;
        max-height: 30px;
        overflow: hidden;
    }

    /* Wikipedia */
    .ctt .wikipedia a:hover {
        text-decoration: underline;
    }
    .ctt .wikipedia .thumb {
        font-size: 10px;
        float: left;
        height: 80px;
        margin-top: 2px;
        text-align: right;
        width: 80px;
    }
    .ctt .wikipedia .thumb img {
        max-height: 80px;
        max-width: 80px;
    }
    .ctt .wikipedia .thumb .src {
        color: #999;
    }
    .ctt .wikipedia .inner.has-thumb {
        margin-left: 90px;
        margin-bottom: 10px;
    }
    .ctt .wikipedia .title {
        font-size: 14px;
        margin-bottom: 1px;
    }
    .ctt .wikipedia .more a {
        color: #999;
    }
    .ctt .wikipedia ol {
        margin-top: 10px;
    }
    .ctt .wikipedia ol li {
        list-style-position: inside;
    }
    .ctt .wikipedia ol li a {
        color: #393e46;
    }

    .ctc ul.items li {
        width: 120px;
    }
    .ctn ul.items .item .price {
        font-size: 15px;
        line-height: 24px;
    }
    .ctn ul.items .item .title {
        height: 45px;
        max-height: 45px;
    }

    /** Condensed */
    .ctc h3 {
        line-height: 26px;
    }

    .ctc .title {
        font-size: 14px;
    }
    .ctc ul.items .title {
        font-size: 12px;
    }
    .ctc ul.items {
        padding-bottom: 1px;
    }
    .ctc ul.items li {
        margin-bottom: -1px;
        margin-right: -1px;
    }
    .ctc ul.items li {
        width: 100px;
    }
    .ctc ul.items .item .price {
        font-size: 13px;
        line-height: 15px;
    }
    .ctc ul.items .item .title {
        height: 30px;
        max-height: 30px;
    }
    .ctc ul.items .fashion .item .title strong {
        display: inline-block;
    }
    .ctc ul.items .item .img {
        background-size: contain;
        height: 70px;
        margin-bottom: 3px;
        margin-top: 3px;
    }

    /** Content light */
    .ctl {
        color: #777;
    }
    .ctl a {
        color: #777;
    }
    .ctl h3 {
        color: #777;
    }
    .ctl h3 a {
        color: #777;
    }
    .ctl ul.items a {
        color: #777;
    }
    .ctl .news a {
        color: #777;
    }
    .ctl .news h3 {
        margin-bottom: 10px;
    }
    .ctl .news .thumb {
        float: right;
    }
    .ctl .news .inner {
        margin-left: 0;
    }
    .ctl .news .item a {
        color: #777;
    }
    .ctl .shopping h3 {
        margin-bottom: 10px;
    }
    .ctl .video h3 {
        margin-bottom: 10px;
    }
    .ctl .wikipedia h3 {
        margin-bottom: 10px;
    }
    .ctl .wikipedia .thumb {
        float: right;
        height: 80px;
        margin-bottom: 10px;
        margin-left: 10px;
        width: 80px;
    }
    .ctl .wikipedia .inner {
        margin-left: 0;
    }
    .ctl .wikipedia ol li a {
        color: #777;
    }

    /** Content light */
    .ctt {
        color: #777;
    }
    .ctt a {
        color: #777;
    }
    .ctt h3 {
        font-size: 13px;
        color: #777;
    }
    .ctt h3 a {
        color: #777;
    }
    .ctt ul.items a {
        color: #777;
    }
    .ctt .news a {
        color: #777;
    }
    .ctt .news h3 {
        margin-bottom: 10px;
    }
    .ctt .news .thumb {
        float: right;
    }
    .ctt .news .inner {
        margin-left: 0;
    }
    .ctt .news .item a {
        color: #777;
    }
    .ctt .shopping a:hover {
        text-decoration: underline;
    }
    .ctt .shopping .item {
        margin-bottom: 10px;
    }
    .ctt .shopping .item:hover {
        cursor: default;
    }
    .ctt .shopping h3 {
        margin-bottom: 10px;
    }
    .ctt .shopping .item .title {
        display: block;
        line-height: 21px;
        max-height: 21px;
        overflow: hidden;
    }
    .ctt .shopping .item .description {
        color: #aaa;
        font-size: 12px;
        max-height: 30px;
        overflow: hidden;
    }
    .ctt .video h3 {
        margin-bottom: 10px;
    }
    .ctt .video .item .title {
        background: none;
        padding-left: 0;
    }
    .ctt .video .item .description {
        color: #8e8e8e;
    }
    .ctt .wikipedia h3 {
        margin-bottom: 10px;
    }
    .ctt .wikipedia .title {
        font-size: 16px;
        margin-bottom: 5px;
    }
    .ctt .wikipedia .thumb {
        float: right;
        height: 80px;
        margin-bottom: 10px;
        margin-left: 10px;
        width: 80px;
    }
    .ctt .wikipedia .inner {
        color: #8e8e8e;
        margin-left: 0;
    }
    .ctt .wikipedia .more a,
    .ctt .wikipedia ol li a {
        color: #8e8e8e;
    }

    /** Content right */
    .ctr .image {
        border: 1px solid #ebebeb;
        padding: 15px;
    }
    .ctr .image h3 {
        margin-bottom: 10px;
    }
    .ctr .news {
        border: 1px solid #ebebeb;
        padding: 15px;
    }
    .ctr .news h3 {
        margin-bottom: 10px;
    }
    .ctr .news .thumb {
        float: right;
    }
    .ctr .news .inner {
        margin-left: 0;
    }
    .ctr .shopping {
        border: 1px solid #ebebeb;
        padding: 15px;
    }
    .ctr .shopping h3 {
        margin-bottom: 10px;
    }
    .ctr .video {
        border: 1px solid #ebebeb;
        padding: 15px;
    }
    .ctr .video h3 {
        margin-bottom: 10px;
    }
    .ctr .wikipedia {
        border: 1px solid #ebebeb;
        padding: 15px;
    }
    .ctr .wikipedia h3 {
        margin-bottom: 10px;
    }
    .ctr .wikipedia .thumb {
        float: right;
        height: 80px;
        margin-bottom: 10px;
        margin-left: 10px;
        width: 80px;
    }
    .ctr .wikipedia .inner {
        margin-left: 0;
    }
</style>
<div class="card">
    <div class="card-content">
        <div class="ctt">
            <div class="content" id="contentblock">
                <div class="wikipedia">
                    <h3 class="title"><a href="{{ $wikiLink }}" target="_top">{!! trans('wikipedia-plugin.information-title', ['title' => '<strong>{{ $title }}</strong>']) !!}</a></h3>

                    <div class="inner ">
                        <p>{!! $text !!} <a href="{{ $wikiLink }}" target="_top">{{ trans('wikipedia-plugin.read-more') }}</a></p>

                        <ol>
                            @foreach($sections as $section)
                                <li><a href="{{ $wikiLink }}#{{ $section['anchor'] }}" target="_top">{{ $section['title'] }}</a></li>
                            @endforeach

                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

