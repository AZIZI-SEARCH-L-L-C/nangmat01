@extends('admin.layout')

@section('title', 'Admin access')
@section('AapiSettings', 'active')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Api configurations
            <small>{{ $apiName }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">{{ $apiName }} config</li>
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

    <form class="form save" method="post" action="{{ URL::action('admin\ApiController@post', $apiName) }}" id="mainForm">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $apiName }} configurations</h3>
                <!-- /.box-tools -->
            </div>
            <div class="box-body">
                @if($apiName == 'BingApi')
{{--                    <div class="row">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="enableBing" class="col-sm-3 control-label">Enable Bing Api:</label>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <input type="checkbox" id="enableBing" name="enableBing" class="minimal" @if(in_array($apiPath.$apiName, config('app.apiWebProviders'))) checked @endif>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row">
                        <div class="form-group">
                            <label for="BingApi" class="col-sm-3 control-label">Bing Custom Search API key:</label>
                            <div class="col-sm-4">
                                <input type="text" name="BingApi" id="BingApi" class="form-control" value="{{ config('bing.key') }}">
                            </div>
                        </div>
                    </div>
                <br>
                    <div class="row">
                        <div class="form-group">
                            <label for="BingCustomSearchConfigsId" class="col-sm-3 control-label">Bing Custom Configuration ID:</label>
                            <div class="col-sm-4">
                                <input type="text" name="BingCustomSearchConfigsId" id="BingCustomSearchConfigsId" class="form-control" value="{{ config('bing.configKey') }}">
                            </div>
                        </div>
                    </div>
                @elseif($apiName == 'GoogleApi')
                    <div class="row">
                        <div class="form-group">
                            <label for="GoogleApi" class="col-sm-3 control-label">Google Custom Search Api key:</label>
                            <div class="col-sm-4">
                                <input type="text" name="GoogleApi" id="GoogleApi" class="form-control" value="{{ config('google.key') }}">
                            </div>
                        </div>
                    </div>
                @elseif($apiName == 'AziziSearchApi')
                    <div class="row">
                        <div class="form-group">
                            <label for="AziziSearchApi" class="col-sm-3 control-label">AziziSearch Api key:</label>
                            <div class="col-sm-4">
                                <input type="text" name="AziziSearchApi" id="AziziSearchApi" class="form-control" value="{{ config('azizisearch.key') }}">
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $( "#save" ).click(function() {
            $('#mainForm').submit();
        });
    </script>
@endsection