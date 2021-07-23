@extends('admin.layout')

@section('title', 'Block territories')
@section('AblockTerr', 'active')

@section('header')
    <style>
        .blocked-terr-pointer{
            cursor: pointer;
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Block territories
            <small>From accessing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Block territories</li>
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

    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Blocked territories</h3>
            <!-- /.box-tools -->
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    @foreach(explode(',', $settings['excTerr']) as $excluded)
                        <span class="label label-default blocked-terr-pointer">{{ $excluded }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <form class="form save" method="post" action="{{ URL::action('admin\DashboardController@postBlockTerr') }}" id="mainForm">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Block some territories</h3>
                <!-- /.box-tools -->
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        <label for="countryId" class="col-sm-3 control-label">Country:</label>
                        <select name="country" class="form-control countries order-alpha" id="countryId" style="width: 67%">
                            <option value="">Select Country</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="stateId" class="col-sm-3 control-label">State:</label>
                        <select name="state" class="form-control states order-alpha" id="stateId" style="width: 67%">
                            <option value="">Select State</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="cityId" class="col-sm-3 control-label">City:</label>
                        <select name="city" class="form-control cities order-alpha" id="cityId" style="width: 67%">
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//geodata.solutions/includes/countrystatecity.js"></script>
    <script>
        $( "#save" ).click(function() {
            $('#mainForm').submit();
        });
        $('.blocked-terr-pointer').click(function () {
           c = confirm('Are you sure you want to unBlock this Territories');
           if(!c){
               return false;
           }
           $val = $(this).html();
           window.location.href = '{{ route('admin.unblockTerr') }}?terr='+$val;
        });
    </script>
@endsection