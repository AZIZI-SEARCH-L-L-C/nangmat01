@extends('admin.layout')

@section('title', 'Submitted sites')
@section('Asites', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Submitted sites
            <small>by users</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.simple') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Submitted sites</li>
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
            <h3 class="box-title">Submitted sites</h3>
        </div>
        <div class="box-body table-responsive">

            @if(!$sites->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Submitter email</th>
                        <th>url</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sites as $site)
                        <tr>
                            <td>{{ $site['email'] }}</td>
                            <td><a target="_blank" href="{{ $site['url'] }}">{{ $site['url'] }}</a></td>
                            <td class="text-right">
                                <a href="{{ $site['url'] }}" target="_blank"><button type="button" class="btn btn-icon-toggle"><i class="fa fa-external-link"></i></button></a>
                                <a href="{{ route('admin.sites.approve', ['url' => $site->url]) }}"><button type="button" class="btn btn-icon-toggle"><i class="fa fa-check"></i></button></a>
                                <button onclick="deleteSite({{ $site['id'] }});" type="button" class="btn"><i class="fa fa-ban"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <center>{{ $sites->render() }}</center>
            @else
                <p class="text-center">There is no sites ranked right now.</p>
            @endif
        </div><!--end .card-body -->
    </div><!--end .card -->

@endsection

@section('javascript')
    <script>
        function deleteSite($id) {
            c = confirm("Are you sure you want to reject and remove this site?");
            if(c){
                window.location.href = "{{ route('admin.sites.reject', '') }}/" + $id;
            }
        }
    </script>
@endsection