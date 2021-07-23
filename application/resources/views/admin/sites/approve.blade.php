@extends('admin.layout')

@section('title', 'Manage ads')
@section('Asites', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            search ads
            <small>Internal ads</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Search ads</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row" id="statu">
        <div class="col-sm-12">
            <div class="alert alert-dismissible" role="alert"><span></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            {{--<button class="btn ink-reaction btn-primary btn-icon-toggle" href="#" data-toggle="modal" data-target="#newModal"><i class="fa fa-plus"></i> New Site</button>--}}
        </div>
    </div><br/>

    @if(Session::has('message'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
    @endif

    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Approve site</h3>
        </div>
        <div class="box-body">
            <form class="form-horizontal" role="form" action="{{ URL::action('admin\SitesController@postApprove') }}" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="url" class="control-label">Site url</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="url" id="url" class="form-control" value="{{ $url }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="title" class="control-label">Title</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="title" id="title" class="form-control" value="{{ $title }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="description" class="control-label">Description</label>
                        </div>
                        <div class="col-sm-9">
                            <textarea col="3" name="description" id="description" class="form-control">{{ $description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="url" class="control-label">Keywords</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" data-role="materialtags" style="height: 36px;" name="keywords" id="keywords" class="form-control" value="">
                        </div>
                    </div>
                    <div id="rankOnkeywords"></div>

                    <div class="col-sm-12 text-right" style="clear:both;">
                        <button type="submit" name="submitApprove" value="true" class="btn btn-flat btn-primary ink-reaction">List site</button>
                    </div>
                </div>
            </form>
        </div><!--end .card-body -->
    </div><!--end .card -->

@endsection

@section('javascript')
    <script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>

    <script>
        $('#keywords').materialtags({
            // tagClass: 'big'
            allowDuplicates: false,
            cancelConfirmKeysOnEmpty: true,
            trimValue: true,

        });
        $('#keywords').on('itemAdded', function(event) {
            // $('#keywords').materialtags('items');
            addRankToKey(event.item);
            // event.item: contains the item
        });
        $('#keywords').on('itemRemoved', function(event) {
            // event.item: contains the item
            $('#block-' + event.item.replace(/ /g, '-')).remove();
        });
        function addRankToKey($word) {
            $('#rankOnkeywords').append('<div class="form-group" id="block-' + $word.replace(/ /g, '-') + '">\n' +
                '                        <div class="col-sm-2">\n' +
                '                            <label for="url" class="control-label">Rank site on keyword ' + $word + '</label>\n' +
                '                        </div>\n' +
                '                        <div class="col-sm-4">\n' +
                '                            <input type="number" placeholder="page" name="page[' + $word + ']" class="form-control">\n' +
                '                        </div>\n' +
                '                        <div class="col-sm-4">\n' +
                '                            <input type="number" placeholder="rank" name="rank[' + $word + ']" class="form-control">\n' +
                '                        </div>\n' +
                '                    </div>');
        }
    </script>
@endsection