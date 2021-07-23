@extends('admin.layout')

@section('title', 'Admin Activity log')
@section('AadminLog', 'active')

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
            Admin
            <small>Activity log</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Admin Activity log</li>
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
                    <h3 class="box-title">Admin activity</h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if($logs->isEmpty())
                        <p class="center">No admin activity right now.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Ip address</th>
                                <th class="text-right">Date/Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->activity }}</td>
                                    <td>{{ $log->ip }}</td>
                                    <td class="text-right">{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- /.box-body -->
                <div class="text-center">{{ $logs->links() }}</div>
            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection

@section('javascript')
    <script>

    </script>
@endsection