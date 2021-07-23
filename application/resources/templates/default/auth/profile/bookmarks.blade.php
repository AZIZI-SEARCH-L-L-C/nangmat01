@extends('pageLayout')

@section('title', trans('bookmarks.bookmarks') . ' - ')

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
                                @if($thereIsACat)<a href="{{ route('profile.bookmarks') }}?e={{ $engineID }}" class="btn">{{ trans('bookmarks.all_bookmarks') }}</a>@endif
                                <a href="#" data-activates='dropdown-engines' data-belowOrigin="true" class="btn dropdown-button">{{ trans('bookmarks.engine') }}</a>
                                @if(!$categories->isEmpty())
                                    @if($thereIsACat)
                                        @if($category->main)
                                            <a href="#" data-activates='dropdown-categories' data-belowOrigin="true" class="btn dropdown-button">{{ trans('bookmarks.sub_cat') }}</a>
                                        @else
                                            <a href="#" data-activates='dropdown-categories' data-belowOrigin="true" class="btn dropdown-button">{{ trans('bookmarks.cat') }}</a>
                                        @endif
                                    @else
                                        <a href="#" data-activates='dropdown-categories' data-belowOrigin="true" class="btn dropdown-button">{{ trans('bookmarks.cat') }}</a>
                                    @endif
                                @endif
                                @if($thereIsACat)
                                    @if($category->main)
                                        <a href="{{ route('profile.bookmarks.organize') }}?t=2&c={{ $category->id }}&e={{ $engineID }}" class="btn" id="organize">{{ trans('bookmarks.organize') }}</a>
                                    @else
                                        <a href="{{ route('profile.bookmarks.organize') }}?t=3&c={{ $category->id }}&e={{ $engineID }}" class="btn" id="organize">{{ trans('bookmarks.organize') }}</a>
                                    @endif
                                @else
                                    <a href="{{ route('profile.bookmarks.organize') }}?e={{ $engineID }}" class="btn" id="organize">{{ trans('bookmarks.organize') }}</a>
                                @endif
                                <a href="#" class="btn hide" id="end-organize">{{ trans('bookmarks.save_organization') }}</a>

                                @if($thereIsACat)
                                    @if($category->main)
                                        <a href="#newCatModel" class="btn modal-trigger right">{{ trans('bookmarks.new_sub_cat') }}</a>
                                    @endif
                                @else
                                    <a href="#newCatModel" class="btn modal-trigger right">{{ trans('bookmarks.new_cat') }}</a>
                                @endif
                            </div>
                        </div>

                    @if(!$categories->isEmpty())
                        <!-- Dropdown Structure -->
                            <ul id='dropdown-categories' class='dropdown-content'>
                                @foreach($categories as $Ccategory)
                                    <li><a href="{{ route('profile.bookmarks.categories', $Ccategory->id) }}">{{ $Ccategory->name }}</a></li>
                                @endforeach
                            </ul>
                    @endif

                    @if(!empty($engines))
                        <!-- Dropdown Structure -->
                            <ul id='dropdown-engines' class='dropdown-content'>
                                @foreach($engines as $Cengine)
                                    <li><a href="{{ route('profile.bookmarks', ['e' => $Cengine['id']]) }}">{{ $Cengine['name'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="card-panel red lighten-2">{{ $error }}</div>
                        @endforeach
                    @endif
                    @if(Session::has('message'))
                        <div class="card-panel @if(Session::get('messageType') == 'success') green @else red @endif lighten-2">{{ Session::get('message') }}</div>
                    @endif

                    @if($engineID == 2 || $engineID == 3)
                        <div id="organize-block" class="block start-select">
                            <div class="block-title">{{ trans('bookmarks.bookmarks') }}: @if($thereIsACat) {{ $category->name }} @endif</div>
                            <div class="dd-list">
                                @if($bookmarks->isEmpty())
                                    <div class="card dd-item dd3-item">
                                        <p class="center">{{ trans('bookmarks.no_bookmarks') }}</p>
                                    </div>
                                @else
                                    <div class="flex">
                                        @foreach($bookmarks as $bookmark)
                                            <div class="card dd-item dd3-item flex-item" id="bookmark-{{ $bookmark->id }}" data-id="{{ $bookmark->id }}" data-url="{{ $bookmark->url }}">
                                                <input type="checkbox" value="{{ $bookmark->id }}" class="select-bookmark-input" data-id="{{ $bookmark->id }}">
                                                <div class="card-content dd3-content">
                                                    <div class="result-container">
                                                        <img src="{{ $bookmark->image }}">
                                                        <div class="title"><a href="{{ $bookmark->url }}">{{ $bookmark->title }}</a></div>
                                                        <div class="disurl">{{ $bookmark->url }}</div>
                                                        <div class="desc" style="color:#666;">{{ $bookmark->description }}</div>
                                                    </div>
                                                    {{ trans('bookmarks.category') }}: @if($bookmark->category)<a href="{{ route('profile.bookmarks.categories', $bookmark->category->id) }}">{{ $bookmark->category->name }}</a>@else {{ trans('bookmarks.non') }} @endif - <a href="#" onclick="moveOne({{ $bookmark->id }});"><i class="jaafar jaafar-18px">call_missed_outgoing</i>{{ trans('bookmarks.move') }}</a> - <a href="#" onclick="removeOne({{ $bookmark->id }});"><i class="jaafar jaafar-18px">delete</i>{{ trans('bookmarks.remove') }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div id="organize-block" class="block start-select">
                            <div class="block-title">{{ trans('bookmarks.bookmarks') }}: @if($thereIsACat) {{ $category->name }} @endif</div>
                            <ol class="dd-list">
                                @if($bookmarks->isEmpty())
                                    <li class="card dd-item dd3-item">
                                        <p class="center">{{ trans('bookmarks.no_bookmarks') }}</p>
                                    </li>
                                @else
                                    @foreach($bookmarks as $bookmark)
                                        <li class="card dd-item dd3-item" id="bookmark-{{ $bookmark->id }}" data-id="{{ $bookmark->id }}" data-url="{{ $bookmark->url }}">
                                            <input type="checkbox" value="{{ $bookmark->id }}" class="select-bookmark-input" data-id="{{ $bookmark->id }}">
                                            <div class="card-content dd3-content">
                                                <div class="result-container">
                                                    <div class="title"><a href="{{ $bookmark->url }}">{{ $bookmark->title }}</a></div>
                                                    <div class="disurl">{{ $bookmark->url }}</div>
                                                    <div class="desc" style="color:#666;">{{ $bookmark->description }}</div>
                                                </div>
                                                {{ trans('bookmarks.category') }}: @if($bookmark->category)<a href="{{ route('profile.bookmarks.categories', $bookmark->category->id) }}">{{ $bookmark->category->name }}</a>@else {{ trans('bookmarks.non') }} @endif - <a href="#" onclick="moveOne({{ $bookmark->id }});"><i class="jaafar jaafar-18px">call_missed_outgoing</i>{{ trans('bookmarks.move') }}</a> - <a href="#" onclick="removeOne({{ $bookmark->id }});"><i class="jaafar jaafar-18px">delete</i>{{ trans('bookmarks.remove') }}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </div>
                    @endif
                    <div class="row topmargin">
                        <div class="col s12">
                            <a href="#" onclick="moveMulti();" class="btn">{{ trans('bookmarks.move') }}</a>
                            <a href="#" onclick="removeMulti();" class="btn">{{ trans('bookmarks.remove') }}</a>
                            <a href="#" id="checkAll" class="btn">{{ trans('bookmarks.check_all') }}</a>
                            <a href="#" id="unCheckAll" class="btn">{{ trans('bookmarks.uncheck_all') }}</a>
                        </div>
                    </div>
                    <div class="center">
                        {!! $bookmarks->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Structure -->
    <div id="moveModel" class="modal">
        <div class="modal-content">
            <h4>{{ trans('bookmarks.move_bookmarks') }}</h4>

            <div class="row">
                <div class="row">
                    <div class="input-field col s12">
                        <input name="id" id="move_bookmark_id" type="hidden">
                        <select class="browser-default" id="move_cat">
                            <option value="0" selected>{{ trans('bookmarks.choose_cat') }}</option>
                            @foreach($categories as $Ccategory)
                                <option value="{{ $Ccategory->id }}">{{ $Ccategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="right waves-effect waves-light btn" id="moveBtn" type="submit">{{ trans('bookmarks.move') }}</button>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('general.close') }}</a>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="removeModel" class="modal">
        <div class="modal-content">
            <h4>{{ trans('bookmarks.remove_bookmark') }}</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12">
                        <input name="id" id="remove_bookmark_id" type="hidden">
                        <p>{{ trans('bookmarks.confirm_delete') }}</p>
                    </div>
                </div>
                <div class="row">
                    <button class="right waves-effect waves-light btn" id="removeBookmark">{{ trans('bookmarks.remove') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="newCatModel" class="modal">
        <div class="modal-content">
            <h4>{{ trans('bookmarks.new_cat') }}</h4>

            <div class="row">
                <form method="post" class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="cat_name" type="text">
                            <input name="engine_id" id="engine_id" value="{{ $engineID }}" type="hidden">
                            @if($thereIsACat)
                                <input name="name" value="0" id="main" type="text">
                                <input name="name" value="{{ $category->id }}" id="main_id" type="text">
                            @else
                                <input name="name" value="1" id="main" type="hidden">
                                <input name="name" value="0" id="main_id" type="hidden">
                            @endif
                            <label for="cat_name">{{ trans('bookmarks.cat_name') }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <button class="right waves-effect waves-light btn" id="newCat">{{ trans('bookmarks.new') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function removeMulti(){
            if($('.select-bookmark-input:checked').length <= 0){
                Materialize.toast('{{ trans('bookmarks.select_one_bookmark') }}', 2000);
                return false;
            }
            $('#removeModel').modal('open');
            var favorite = [];
            $.each($('.select-bookmark-input:checked'), function(){
                favorite.push($(this).val());
            });
            $('#remove_bookmark_id').val(favorite.join(", "));
        }

        function removeOne($id){
            $('#remove_bookmark_id').val($id);
            $('#removeModel').modal('open');
        }
        function moveMulti(){
            if($('.select-bookmark-input:checked').length <= 0){
                Materialize.toast('{{ trans('bookmarks.select_one_bookmark') }}', 2000);
                return false;
            }
            $('#moveModel').modal('open');
            var favorite = [];
            $.each($('.select-bookmark-input:checked'), function(){
                favorite.push($(this).val());
            });
            $('#move_bookmark_id').val(favorite.join(", "));
        }

        function moveOne($id){
            $('#move_bookmark_id').val($id);
            $('#moveModel').modal('open');
        }

        $('#checkAll').click(function () {
            $('.select-bookmark-input').prop('checked', true);
            Materialize.toast('{{ trans('bookmarks.all_bookmarks_checked') }}', 2000);
            return false;
        });
        $('#unCheckAll').click(function () {
            $('.select-bookmark-input').prop('checked', false);
            Materialize.toast('{{ trans('bookmarks.all_bookmarks_unchecked') }}', 2000);
            return false;
        });
        $('#newCat').click(function () {
            $category = $('#cat_name').val();
            $main = $('#main').val();
            $main_id = $('#main_id').val();
            $engine_id = $('#engine_id').val();
            $.ajax({
                url: '{{ route('bookmark.new.category') }}',
                data: {name: $category, main: $main, engine_id: $engine_id, main_id: $main_id},
                success: function (data) {
                    Materialize.toast(data, 2000);
                    $('#newCatModel').modal('close');
                    $('.modal-overlay').remove();
                },
                error: function (e) {
                    Materialize.toast(e.responseText, 2000);
                },
            });
            return false;
        });

        $('#removeBookmark').click(function () {
            var $ids = $('#remove_bookmark_id').val()+ '';
            var $idsObj = $ids.split(',');
            $.ajax({
                url: '{{ route('bookmark.remove') }}',
                data: {id: $ids},
                success: function (data) {
                    Materialize.toast(data, 2000);
                    $.each($idsObj, function (item, value) {
                        $('#bookmark-'+value.replace(' ','')).remove();
                    });
                    $('#removeModel').modal('close');
                    $('.modal-overlay').remove();
                },
                error: function (e) {
                    Materialize.toast(e.responseText, 2000);
                },
            });
            return false;
        });

        $('#moveBtn').click(function () {
            var $ids = $('#move_bookmark_id').val()+ '';
            var $cat = $('#move_cat').val()+ '';
            var $idsObj = $ids.split(',');
            if($cat == 0){
                Materialize.toast('{{ trans('bookmarks.select_cat') }}', 2000);
                return false;
            }
            $.ajax({
                url: '{{ route('bookmark.move') }}',
                data: {id: $ids, cat: $cat},
                success: function (data) {
                    Materialize.toast(data, 2000);
                    @if($thereIsACat)
                    $.each($idsObj, function (item, value) {
                        $('#bookmark-'+value.replace(' ','')).remove();
                    });
                    @endif
                    $('#moveModel').modal('close');
                    $('.modal-overlay').remove();
                },
                error: function (e) {
                    Materialize.toast(e.responseText, 2000);
                },
            });
            return false;
        });
    </script>
@endsection
