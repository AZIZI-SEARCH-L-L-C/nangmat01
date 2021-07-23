@extends('admin.layout')

@section('title', 'User bookmarks')
@section('Ausers', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            User bookmarks
            <small>of results</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User bookmarks</li>
        </ol>
    </section>
@endsection


@section('content')

    <div class="row" id="statu">
        <div class="col-sm-12">
            <div class="alert alert-dismissible" role="alert"><span></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
        </div>
    </div>

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
            <h3 class="box-title">Results Bookmarks</h3>
        </div>
        <div class="box-body table-responsive">

            @if(!$bookmarks->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Url</th>
                        <th>Category</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookmarks as $bookmark)
                        <tr>
                            <td>{{ $bookmark->url }}</td>
                            <td>@if($bookmark->category) {{ $bookmark->category->name }} @endif</td>
                            <td class="text-right">
                                <button onclick="deleteBookmark({{ $bookmark->id }});" type="button" class="btn"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $bookmarks->render() }}</center>
            @else
                <p class="text-center">There is no bookmarks right now.</p>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

@endsection

@section('javascript')
    <script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
    <script>
        function deleteBookmark($id){
            c = confirm("Are you sure you want to delete this bookmark?");
            if(c){
                window.location.href = "{{ route('admin.sites.bookmarks.delete', '') }}/" + $id;
            }
        }

    </script>
@endsection