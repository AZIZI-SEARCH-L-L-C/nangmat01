@extends('admin.layout')

@section('title', 'Ads Settings')
@section('Amonetize', 'active')

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
            Ads Settings
            <small>control ads</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Ads Settings</li>
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
    <form class="form-horizontal save" method="post" id="mainForm" action="{{ URL::action('admin\AdvertisementsController@postAdsSettings') }}">
        <div class="row flex">
            <div class="col-sm-12 flex">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">ads settings</h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
						<div class="form-group">
							<label for="enableads" class="col-sm-12">
								<input type="checkbox" id="enableads" name="enableads" class="minimal" @if($settings['advertisements']) checked @endif>
								Allow users to advertise on your search engine
							</label>
						</div>
						<div class="form-group">
							<label for="approveAds" class="col-sm-12">
								<input type="checkbox" id="approveAds" name="approveAds" class="minimal" @if($settings['approveAds']) checked @endif>
								Approve ads by admin before going live
							</label>
						</div>
                        <div class="form-group">
                            <label for="takeFromAdvertisements" class="col-sm-2 control-label">Number of ads with results:</label>
                            <div class="col-sm-10">
                                <input type="number" name="takeFromAdvertisements" id="takeFromAdvertisements" class="form-control" value="{{ $settings['takeFromAdvertisements'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="initialCost0" class="col-sm-2 control-label">Initial cost per click:</label>
                            <div class="col-sm-10">
                                <input type="number" name="initialCost0" id="initialCost0" class="form-control" value="{{ $settings['initialCost0'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="initialCost1" class="col-sm-2 control-label">Initial cost per impression:</label>
                            <div class="col-sm-10">
                                <input type="number" name="initialCost1" id="initialCost1" class="form-control" value="{{ $settings['initialCost1'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="initialCost2" class="col-sm-2 control-label">Initial cost per day:</label>
                            <div class="col-sm-10">
                                <input type="number" name="initialCost2" id="initialCost2" class="form-control" value="{{ $settings['initialCost2'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="costPerDecimals" class="col-sm-2 control-label">The cost decimals:</label>
                            <div class="col-sm-10">
                                <input type="number" name="costPerDecimals" id="costPerDecimals" class="form-control" value="{{ $settings['costPerDecimals'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="budgetMin" class="col-sm-2 control-label">The minimum budget to run an Ad:</label>
                            <div class="col-sm-10">
                                <input type="number" name="budgetMin" id="budgetMin" class="form-control" value="{{ $settings['budgetMin'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min_payment" class="col-sm-2 control-label">The minimum payment total:</label>
                            <div class="col-sm-10">
                                <input type="number" name="min_payment" id="min_payment" class="form-control" value="{{ $settings['min_payment'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="max_payment" class="col-sm-2 control-label">The maximum payment total:</label>
                            <div class="col-sm-10">
                                <input type="number" name="max_payment" id="max_payment" class="form-control" value="{{ $settings['max_payment'] }}">
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