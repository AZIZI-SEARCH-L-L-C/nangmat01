@extends('admin.layout')

@section('title', 'API providers Settings')
@section('Asettings', 'active')

@section('css')
    <style>
        .ddicheckbox_minimal-blue{
            margin-left: 15px;
        }
        .form-group{
            clear: both;
        }
    </style>
@endsection

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            API providers Settings
            <small>configure API providers</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">API providers settings</li>
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
                <div class="alert alert-dismissible @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
    @endif

    <form class="form-horizontal save" method="post" id="mainForm" action="{{ URL::action('admin\SettingsController@postPaymentsGateways') }}">
        <div class="row flex">
            <div class="col-lg-12 flex">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">API providers</h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-12">
                                <input type="checkbox" id="enable_paypal" name="enable_paypal" class="minimal" @if(Config::get('paypal.enabled', false) == 'true') checked @endif>
                                Enable paypal payment method
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="paypal_id" class="col-sm-2 control-label">Paypal Client ID:</label>
                            <div class="col-sm-10">
                                <input type="text" name="paypal_id" id="paypal_id" class="form-control" value="{{ Config::get('paypal.client_id', '') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paypal_secret" class="col-sm-2 control-label">Paypal Client Secret:</label>
                            <div class="col-sm-10">
                                <input type="text" name="paypal_secret" id="paypal_secret" class="form-control" value="{{ Config::get('paypal.secret', '') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paypal_mode" class="col-sm-2 control-label">Mode:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="paypal_mode" style="margin: 0 auto;width:100%">
                                    <option value="sandbox" @if(config('paypal.settings.mode') == 'sandbox') selected @endif>Sandbox</option>
                                    <option value="live" @if(config('paypal.settings.mode') == 'live') selected @endif>Live</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
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