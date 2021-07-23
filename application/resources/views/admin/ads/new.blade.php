@extends('admin.layout')

@section('title', 'Manage ads')
@section('Amonetize', 'active')

@section('css')
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet"/>
    <style>
        label.nonStyle{
            font-weight: normal;
        }
    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            search ads
            <small>Internal ads</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.searchcompains.get') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
            <a class="btn ink-reaction btn-primary" href="{{ route('admin.searchads.get', $compain->id) }}"><i class="fa fa-caret-left"></i> All ads</a>
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

    @if($errors->all())
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Create an ad</h3>
        </div>
        <div class="box-body table-responsive">
            <form class="form-horizontal" role="form" action="{{ route('admin.searchads.new.get', $compain->id) }}" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>User:</label>
                        </div>
                        <div class="col-sm-6">
                            {{ $compain->user->username }} ({{ $compain->user->email }})
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Compain:</label>
                        </div>
                        <div class="col-sm-6">
                            {{ $compain->name }}
                            <input type="hidden" name="compain" value="{{ $compain->id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Charge per</label>
                        </div>
                        <div class="col-sm-6">
                            <select name="chargeType" id="chargeType" class="form-control">
                                <option value="0" @if(old('chargeType', 0) == 0) selected @endif>clicks</option>
                                <option value="1" @if(old('chargeType', 0) == 1) selected @endif>Impressions</option>
                                <option value="2" @if(old('chargeType', 0) == 2) selected @endif>Days</option>
                            </select>
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<div class="col-sm-3">--}}
                            {{--<label>Select a user</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--<select class="form-control select2" name="userId" id="selectUser" data-placeholder="Select a User" style="width: 100%;"></select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adUnitName" class="control-label">Ad Unit name:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="adUnitName" id="adUnitName" class="form-control" value="{{ old('adUnitName') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adTitle" class="control-label">Ad title:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="adTitle" value="{{ old('adTitle') }}" id="adTitle" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adURL" class="control-label">Ad URL:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="url" name="adURL" value="{{ old('adURL') }}" id="adURL" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adVurl" class="control-label">Ad visible URL:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="adVurl" value="{{ old('adVurl') }}" id="adVurl" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adDescription" class="control-label">Ad Description:</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="adDescription" id="adDescription" class="form-control" rows="3">{{ old('adDescription') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adKeywords" class="control-label">Ad Keywords:</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="adKeywords" id="adKeywords" class="form-control" rows="3">{{ old('adKeywords') }}</textarea>
                            <p class="help-block">keywords should be separated by comma.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Show ad in</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="show_in[]" multiple="multiple" data-placeholder="Select when show this ad" style="width: 100%;">
                                <option value="0"
                                    @if(old('show_in'))
                                        @if(in_array(0, old('show_in'))) selected @endif
                                    @endif
                                >All engines</option>
                                @foreach($engines as $Cengine)
                                    <option value="{{ $Cengine['name'] }}"
                                        @if(old('show_in'))
                                            @if(in_array($Cengine['name'], old('show_in'))) selected @endif
                                        @endif
                                    >{{ $Cengine['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Age</label>
                        </div>
                        <div class="col-sm-2">
                            from:
                            <select name="ageFrom" id="ageFrom" class="form-control">
                                <option value="" @if(!old('ageFrom')) selected @endif>Any</option>
                                @for($i = 13; $i < 65; $i++)
                                    <option value="{{ $i }}" @if(old('ageFrom') == $i) selected @endif>{{ $i }}</option>
                                @endfor
                                <option value="65" @if(old('ageFrom') == 65) selected @endif>65+</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            to:<select name="ageTo" id="ageTo" class="form-control">
                                <option value="" @if(!old('ageTo')) selected @endif>Any</option>
                                @for($i = 13; $i < 65; $i++)
                                    <option value="{{ $i }}" @if(old('ageTo') == $i) selected @endif>{{ $i }}</option>
                                @endfor
                                <option value="65" @if(old('ageTo') == 65) selected @endif>65+</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Gender</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" name="gender" style="width: 100%;">
                                <option value="" @if(old('gender') == '') selected @endif>Any</option>
                                <option value="1" @if(old('gender') == 1) selected @endif>Male</option>
                                <option value="2" @if(old('gender') == 2) selected @endif>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Languages</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="languages[]" multiple="multiple" style="width: 100%;">
                                @foreach($languages as $langaugeKey => $languageValue)
                                    <option value="{{ $langaugeKey }}" @if(old('languages') == $langaugeKey) selected @endif>{{ $languageValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Interests</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="interests" id="adInterests" class="form-control" rows="3">{{ old('interests') }}</textarea>
                            <p class="help-block">interests should be separated by comma.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Geo targeting</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle">
                                <input type="checkbox" class="minimal" name="geoTurn" id="geoTurn" value="1" @if(old('geoTurn', 1) == 1) checked @endif>
                                Use geo targeting to show your ads where you want.
                            </label>
                        </div>
                    </div>
                    <div id="geoTargeting" style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label>continents</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="nonStyle">
                                    <input type="checkbox" class="minimal" name="continentTurn" id="continentTurn" value="1" @if(old('continentTurn', 1) == 1) checked @endif>
                                    Only users from thes continents
                                </label>
                            </div>
                        </div>
                        <div id="continentsContainer">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label></label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control select2" multiple="multiple" name="continents[]" style="width: 100%;">
                                        @foreach($continents as $continentKey => $continentValue)
                                            <option value="{{ $continentKey }}"
                                                @if(old('continents'))
                                                    @if(in_array($continentKey, old('continents'))) selected @endif
                                                @endif
                                            >{{ $continentValue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label>Include just countries:</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="nonStyle">
                                    <input type="checkbox" class="minimal" name="countriesTurn1" id="countriesTurn1" value="1" @if(old('countriesTurn1', 1) == 1) checked @endif>
                                    Only users from thes countries
                                </label>
                            </div>
                        </div>
                        <div id="countriesContainer1">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label></label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control select2" multiple="multiple" name="inc_countries[]" style="width: 100%;">
                                        @foreach($countries as $countryKey => $countryValue)
                                            <option value="{{ $countryKey }}"
                                                    @if(old('inc_countries'))
                                                        @if(in_array($countryKey, old('inc_countries'))) selected @endif
                                                    @endif
                                            >{{ $countryValue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label>Exclude countries:</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="nonStyle">
                                    <input type="checkbox" class="minimal" name="countriesTurn2" id="countriesTurn2" value="1" @if(old('countriesTurn2', 1) == 1) checked @endif>
                                    Exclude these countries:
                                </label>
                            </div>
                        </div>
                        <div id="countriesContainer2">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label></label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control select2" multiple="multiple" name="exc_countries[]" style="width: 100%;">
                                        @foreach($countries as $countryKey => $countryValue)
                                            <option value="{{ $countryKey }}"
                                                    @if(old('exc_countries'))
                                                        @if(in_array($countryKey, old('exc_countries'))) selected @endif
                                                    @endif
                                            >{{ $countryValue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="CeditAdStatu" class="control-label">Schedule:</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle" for="scheduleTurnOff">
                                <input type="radio" name="scheduleTurn" class="minimal" value="" id="scheduleTurnOff" @if(old('scheduleTurn', 0) == 0) checked @endif>
                                Run my ad set continuously starting today.
                            </label>
                            <label class="nonStyle" for="scheduleTurnON">
                                <input type="radio" name="scheduleTurn" class="minimal" id="scheduleTurnON" value="1" @if(old('scheduleTurn', 0) == 1) checked @endif>
                                Set a start and end date.
                            </label>
                        </div>
                    </div>
                    <div id="scheduleContainer" style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="CeditAdStatu" class="control-label">Start:</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="startDate" id="startDate" class="form-control pull-right datepicker" value="{{ old('startDate') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" name="startTime" id="startTime" class="form-control pull-right timepicker" value="{{ old('startTime') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">End:</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="endDate" id="endDate" class="form-control pull-right datepicker" value="{{ old('endDate') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" name="endTime" id="endTime" class="form-control pull-right timepicker" value="{{ old('endTime') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label class="control-label">Budget source:</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle" for="budgetTurnOff">
                                <input type="radio" name="budgetTurn" class="minimal" value="0" id="budgetTurnOff" @if(old('budgetTurn', 0) == 0) checked @endif>
                                Run ad from my account credit.
                            </label>
                            <label class="nonStyle" for="budgetTurnON">
                                <input type="radio" name="budgetTurn" class="minimal" id="budgetTurnON" value="1" @if(old('budgetTurn', 0) == 1) checked @endif>
                                Set ad lifetime budget.
                            </label>
                        </div>
                    </div>
                    <div id="budgetContainer" style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="budget" class="control-label"></label>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </div>
                                    <input type="text" name="budget" placeholder="0.00" value="{{ old('budget') }}" id="budget" class="form-control pull-right">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adStatu" class="control-label">Ad statu:</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle">
                                <input type="checkbox" class="minimal" value="1" name="adStatu" id="adStatu" @if(old('adStatu', 0) == 1) checked @endif>
                                Active ad by default
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adApproved" class="control-label">Approve ad:</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle">
                                <input type="checkbox" class="minimal" value="1" name="adApproved" id="adApproved" @if(old('adApproved', 0) == 1) checked @endif>
                                Approved by admin
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="estimateContents" class="control-label">Ad summer:</label>
                        </div>
                        <div class="col-sm-6">
                            <div id="estimateContents">
                                <p class="bold">
                                    <span id="costEstimType">Estimated cost</span>: <span id="costEstimValue">0.00</span>$
                                </p>
                                <span class="second-text red-text" id="highKeywordCost"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submitNew" value="submit" class="btn btn-primary">Create new</button>
                </div>
            </form>
        </div><!--end .card-body -->
    </div><!--end .card -->

@endsection

@section('javascript')
    <script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script>
        // keywords cost ----------------
        var primeryKeywords = new Bloodhound({datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '{{ route("ajax.ads.data", ["name" => "primeryKeywords"]) }}',
                cache: false,
            }
        });
        primeryKeywords.initialize();

        $( "#chargeType" ).change(function() {
            showEstimateType();
            showEstimateValue();
            showDateChooser();
        });

        function toggleBlock($activator, $target){
            if($($activator).prop( "checked" )){
                $($target).show();
            }else{
                $($target).hide();
            }
        }

        $("#geoTurn").on('ifChecked ifUnchecked', function (){toggleBlock("#geoTurn", "#geoTargeting");});
        $("#continentTurn").on('ifChecked ifUnchecked', function (){toggleBlock("#continentTurn", "#continentsContainer");});
        $("#countriesTurn1").on('ifChecked ifUnchecked', function (){toggleBlock("#countriesTurn1", "#countriesContainer1");});
        $("#countriesTurn2").on('ifChecked ifUnchecked', function (){toggleBlock("#countriesTurn2", "#countriesContainer2");});


        toggleBlock("#geoTurn", "#geoTargeting");
        toggleBlock("#continentTurn", "#continentsContainer");
        toggleBlock("#countriesTurn1", "#countriesContainer1");
        toggleBlock("#countriesTurn2", "#countriesContainer2");
        toggleBlock("#scheduleTurnON", "#scheduleContainer");
        toggleBlock("#budgetTurnON", "#budgetContainer");
        showDateChooser();


        $('.timepicker').timepicker({
            showInputs: false,
            showMeridian: false,
            minuteStep: 1,
        });
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        $("#scheduleTurnON").on('ifChecked', function (){
            $("#scheduleContainer").show();
            return;
        });

        $("#scheduleTurnOff").on('ifChecked', function (){
            $("#scheduleContainer").hide();
            return;
        });

        $("#budgetTurnON").on('ifChecked', function (){
            $("#budgetContainer").show();
            return;
        });

        $("#budgetTurnOff").on('ifChecked', function (){
            $("#budgetContainer").hide();
            return;
        });

        @if(old('geoTurn', 1) == 1)
            $('#geoTargeting').show();
        @endif

        function showDateChooser(){
            if($("#chargeType").val() == 2){
                $("#scheduleTurnON").iCheck('check');
                $("#scheduleTurnOff").iCheck('uncheck');
                $("#scheduleTurnOff").iCheck('disable');
                $("#scheduleContainer").show();

                $("#budgetTurnON").iCheck('check');
                $("#budgetTurnOff").iCheck('uncheck');
                $("#budgetTurnOff").iCheck('disable');
                $("#budgetContainer").show();

            }else{
                $("#scheduleTurnON").iCheck('uncheck');
                $("#scheduleTurnOff").iCheck('check');
                $("#scheduleTurnOff").iCheck('enable');
                $("#scheduleContainer").hide();

                $("#budgetTurnON").iCheck('uncheck');
                $("#budgetTurnOff").iCheck('check');
                $("#budgetTurnOff").iCheck('enable');
                $("#budgetContainer").hide();

            }
            showEstimateValue();
        }

        function showEstimateType(){
            if($("#chargeType").val() == 0){
                $("#costEstimType").html('Estimated cost per click');
            }else if($("#chargeType").val() == 1){
                $("#costEstimType").html('Estimated cost per click');
            }else if($("#chargeType").val() == 2){
                $("#costEstimType").html('Cost per Day');
            }
        }

        function showEstimateValue(){
            // initial cost -----------------
            var cost = 0;
            if($("#chargeType").val() == 0){
                cost += {{ $settings['initialCost0'] }};
            }else if($("#chargeType").val() == 1){
                cost += {{ $settings['initialCost1'] }};
            }else if($("#chargeType").val() == 2){
                cost += {{ $settings['initialCost2'] }};
            }
            // ------------------------------

            // primery Keywords more --------
            var premKeywords = [];
            var InitialCost = cost;
            $.map(primeryKeywords.index.datums, function( id,primeryKeywordJson ) {
                var primeryKeyword = $.parseJSON(primeryKeywordJson);
                // primery Keywords more --------
                if (document.getElementById("adKeywords").value.toLowerCase().indexOf(primeryKeyword.keyword) >= 0
                    || document.getElementById("adTitle").value.toLowerCase().indexOf(primeryKeyword.keyword) >= 0
                    || document.getElementById("adVurl").value.toLowerCase().indexOf(primeryKeyword.keyword) >= 0
                    || document.getElementById("adURL").value.toLowerCase().indexOf(primeryKeyword.keyword) >= 0
                    || document.getElementById("adDescription").value.toLowerCase().indexOf(primeryKeyword.keyword) >= 0){
                    cost += InitialCost * (primeryKeyword.leverage / 100);
                    premKeywords.push(primeryKeyword.keyword);
                }
            });

            // Add premier keyword if available
            if(premKeywords.length !== 0 && premKeywords.length === 1){
                $("#highKeywordCost").html('<p>the keyword "' + premKeywords.join(", ") + '" is a premium keyword. <a target="_blank" href="{{ route('premium.keywords') }}">Read more</a></p>');
            }else if(premKeywords.length !== 0 && premKeywords.length !== 1){
                $("#highKeywordCost").html('<p>the keywords "' + premKeywords.join(", ") + '" are premium keywords. <a target="_blank" href="{{ route('premium.keywords') }}">Read more</a></p>');
            }else{
                $("#highKeywordCost").html('');
            }
            // ------------------------------

            // additinal factors--
            @if($costFactors)
                @foreach($costFactors as $costFactor)
                    @if($costFactor->operation)
                        elem = $("#{{ $costFactor->keyword }}");
                        @if($costFactor->operation)
                            if(elem.attr('type') == 'checkbox'){
                                if(elem.prop('checked')){
                                    cost += cost {{ $costFactor->operation }} ({{ $costFactor->leverage }} / 100);
                                }
                            }else{
                                if(elem.val() != ''){
                                    cost += cost {{ $costFactor->operation }} ({{ $costFactor->leverage }} / 100);
                                }
                            }
                        @elseif($costFactor->advancedOperation)
                            if(elem.attr('type') == 'checkbox') {
                                if (elem.prop('checked')) {
                                    cost += {{ str_replace(['cost', 'leverage'], ['cost', $costFactor->leverage], $costFactor->advancedOperation) }};
                                }
                            }else{
                                if(elem.val() != ''){
                                    cost += {{ str_replace(['cost', 'leverage'], ['cost', $costFactor->leverage], $costFactor->advancedOperation) }};
                                }
                            }
                        @endif
                    @endif
                @endforeach
            @endif
            // ------------------------------

            // days -------------------------
            $days = getDaysDiffShowCost();
            if($("#chargeType").val() == 2){
                if(!isNaN($days)){
                    $("#costEstimType").html('Cost per ad lifetime');
                    cost = $days * cost;
                    $("#budget").val(cost.toFixed({{ $settings['costPerDecimals'] }}));
                }else{
                    $("#costEstimType").html('Cost per day');
                }
                $("#budget").prop('disabled', true);
            }else{
                $("#budget").prop('disabled', false);
            }
            // console.log(cost);
            //-------------------------------

            $("#costEstimValue").html(cost.toFixed({{ $settings['costPerDecimals'] }}));
        }

        function getDaysDiffShowCost(){
            $start = $("#startDate").val() + '-' + $("#startTime").val();
            $end = $("#endDate").val() + '-' + $("#endTime").val();
            $days = daydiff($start, $end);
            return $days;
        }

        function daydiff($start, $end) {
            $fullStartDate = parseDate($start);
            $fullEndDate = parseDate($end);
            $millisecondsPerDay = 1000 * 60 * 60 * 24;
            $millisBetween  = $fullEndDate.getTime() - $fullStartDate.getTime();
            $days = $millisBetween / $millisecondsPerDay;
            return $days.toFixed({{ $settings['costPerDecimals'] }});
        }

        function parseDate(str) {
            var hi = [];
            var mdy = str.split('-');
            if(mdy[3] !== undefined){
                hi = mdy[3].split(':');
            }else{
                hi[0] = null;
                hi[1] = null;
            }
            return new Date(mdy[2], mdy[1]-1, mdy[0], hi[0], hi[1]);
        }

        // on change on of: -------------
        $("#adTitle, #adDescription, #adVur, #adURL").keyup(function(){
            showEstimateValue();
        });
        $("#startDate, #startTime, #endDate, #endTime").change(function(){
            showEstimateValue();
        });

    </script>
@endsection