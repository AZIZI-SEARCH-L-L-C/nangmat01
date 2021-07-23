@extends('admin.layout')

@section('title', 'Queries stats')
@section('Aqueries', 'active')

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/css/select2.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/nestable/nestable.css') }}" />
    <style>
        .ddicheckbox_minimal-blue{
            margin-left: 15px;
        }
        .form-horizontal .control-label{
            text-align: left !important;
        }
        #statu{
            display: none;
        }
    </style>
@endsection

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Queries
            <small>Stats</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">queries stats</li>
        </ol>
    </section>
@endsection

@section('content')
    @if(Session::has('message'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-dismissible @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Queries stats</h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>query</th>
                            <th>country</th>
                            <th>browser</th>
                            <th>device</th>
                            <th>Os</th>
                            <th class="text-right">Date/Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($queries as $query)
                            <tr>
                                <td>{{ $query->query }}</td>
                                <td>{{ array_get(config('locales'), $query->country) }}</td>
                                <td>{{ $query->browser }}</td>
                                <td>{{ $query->device }}</td>
                                <td>{{ $query->os }}</td>
                                <td class="text-right">{{ $query->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="text-center">{{ $queries->links() }}</div>
            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection

@section('javascript')
    <script>

    </script>
@endsection