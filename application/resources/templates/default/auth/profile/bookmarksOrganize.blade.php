@extends('pageLayout')

@section('title', trans('bookmarks.orginizer_title') . ' - ')

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/nestable/nestable.css') }}" />
    <style>

    </style>
@endsection

@section('content')
    <div class="row form_page">
        <div class="row">
            <div class="container">
                <div class="col m4 s12 left-side">
                    @include('inc.leftMenu', ['activeItem' => 'bookmarks_adv'])
                </div>
                <div class="col m8 s12">
                    <div class="btns-container">
                        <div class="row">
                            <div class="col s12">
                                <a href="{{ route('profile.bookmarks') }}?e={{ $engineID }}" class="btn">{{ trans('bookmarks.all_bookmarks') }}</a>
                                <a id="save" href="{{ route('profile.bookmarks') }}" data-type="{{ $type }}" class="btn">{{ trans('bookmarks.save_organization') }}</a>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="card-panel red lighten-2">{{ $error }}</div>
                        @endforeach
                    @endif
                    @if(Session::has('message'))
                        <div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
                    @endif

                    <div id="organize-block" class="block dd">
                        <div class="block-title">
                            @if($type == 1)
                                {{ trans('bookmarks.orginizer_all_bookmarks') }}
                            @else
                                {{ trans('bookmarks.orginizer_all_bookmarks_cat', ['cat' => $category->name]) }}
                            @endif
                        </div>
                        <ol class="dd-list @if($engineID == 2 || $engineID == 3) flex @endif">
                            @if($bookmarks->isEmpty())
                                <p class="center">{{ trans('bookmarks.no_bookmarks') }}</p>
                            @else
                                @foreach($bookmarks as $bookmark)
                                    <li class="card dd-item dd3-item @if($engineID == 2 || $engineID == 3) flex-item @endif" data-id="{{ $bookmark->id }}">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="card-content dd3-content">
                                            <div class="result-container">
                                                @if($engineID == 2 || $engineID == 3) <img src="{{ $bookmark->image }}"> @endif
                                                <div class="title"><a href="{{ $bookmark->url }}">{{ $bookmark->title }}</a></div>
                                                <div class="disurl">{{ $bookmark->url }}</div>
                                                <div class="desc" style="color:#666;">{{ $bookmark->description }}</div>
                                            </div>
                                            {{ trans('bookmarks.category') }}: <a href="#" class=""><i class="jaafar jaafar-18px">edit</i>@if($bookmark->category){{ $bookmark->category->name }}@else {{ trans('bookmarks.non') }} @endif</a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/admin/js/nestable/jquery.nestable.js') }}"></script>
    <script>
        (function(namespace, $) {
            "use strict";

            var DemoUILists = function() {
                var o = this;
                $(document).ready(function() {
                    o.initialize();
                });

            };
            var p = DemoUILists.prototype;

            p.initialize = function() {
                this._initNestableLists();
            };
            p._initNestableLists = function() {
                if (!$.isFunction($.fn.nestable)) {
                    return;
                }

                $('.dd').nestable({maxDepth:1});
            };

            namespace.DemoUILists = new DemoUILists;
        }(this, jQuery));

        function serializeDD(){
            var obj = $('.dd').nestable('serialize');
            $('#enginesOrder').val(JSON.stringify(obj));
        }
        $('body').on('change', 'dd', function() {
            serializeDD();
        });

        $('#save').click(function () {
            var obj = $('.dd').nestable('serialize');
            $json = JSON.stringify(obj);
            $category = 0;
            @if($type != 1) $category = {{ $category->id }}; @endif
                $type = $(this).data('type');
            $.ajax({
                url: '{{ route('bookmark.organize') }}',
                data: {json: $json, type: $type, category: $category},
                success: function (data) {
                    Materialize.toast(data, 2000);
                },
                error: function (e) {
                    Materialize.toast(e.responseText, 2000);
                },
            });
            return false;
        });
    </script>
@endsection
