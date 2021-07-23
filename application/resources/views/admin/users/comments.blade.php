@extends('admin.layout')

@section('title', 'User results comments')
@section('Ausers', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            User comments
            <small>of results</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User comments</li>
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
            <h3 class="box-title">User Comments</h3>
        </div>
        <div class="box-body table-responsive">

            @if(!$comments->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Comment</th>
                        <th>Result</th>
                        <th>Engine</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ $comment->url }}</td>
                            <td>{{ $comment->engine->name }}</td>
                            <td class="text-right">
                                <button onclick="deleteComment({{ $comment->id }});" type="button" class="btn"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $comments->render() }}</center>
            @else
                <p class="text-center">There is no comments right now.</p>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

@endsection

@section('javascript')
    <script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
    <script>
        function deleteComment($id){
            c = confirm("Are you sure you want to delete this comment?");
            if(c){
                window.location.href = "{{ route('admin.sites.comments.delete', '') }}/" + $id;
            }
        }

    </script>
@endsection