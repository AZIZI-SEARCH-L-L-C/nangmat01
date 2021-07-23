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
            <form class="form-horizontal" role="form" action="{{ route('admin.searchads.edit', $ad->id) }}" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>User:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" id="chargeType" value="{{ $ad->type }}">
                            {{ $compain->user->username }} ({{ $compain->user->email }})
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Compain:</label>
                        </div>
                        <div class="col-sm-6">
                            {{ $compain->name }} (per @if($ad->type == 0) Click) @elseif($ad->type == 1) Impressions) @elseif($ad->type == 2) Period) @endif
                            <input type="hidden" name="compain" value="{{ $compain->id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adUnitName" class="control-label">Ad Unit name:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="adUnitName" id="adUnitName" class="form-control" value="{{ old('adUnitName', $ad->name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adTitle" class="control-label">Ad title:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="adTitle" value="{{ old('adTitle', $ad->title) }}" id="adTitle" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adURL" class="control-label">Ad URL:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="url" name="adURL" value="{{ old('adURL', $ad->url) }}" id="adURL" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adVurl" class="control-label">Ad visible URL:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="adVurl" value="{{ old('adVurl', $ad->Vurl) }}" id="adVurl" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adDescription" class="control-label">Ad Description:</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="adDescription" id="adDescription" class="form-control" rows="3">{{ old('adDescription', $ad->description) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="adKeywords" class="control-label">Ad Keywords:</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="adKeywords" id="adKeywords" class="form-control" rows="3">{{ old('adKeywords', $ad->keywords) }}</textarea>
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
                                        @if(in_array("0", old('show_in', explode(',', $target->show_in)), true)) selected @endif
                                >All engines</option>
                                @foreach($engines as $Cengine)
                                    <option value="{{ $Cengine['name'] }}"
                                            @if(old('show_in', $target->show_in))
                                            @if(in_array($Cengine['name'], old('show_in', explode(',', $target->show_in)))) selected @endif
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
                                <option value="" @if(!old('ageFrom', explode(',', $target->age)[0])) selected @endif>Any</option>
                                @for($i = 13; $i < 65; $i++)
                                    <option value="{{ $i }}" @if(old('ageFrom', explode(',', $target->age)[0]) == $i) selected @endif>{{ $i }}</option>
                                @endfor
                                <option value="65" @if(old('ageFrom', explode(',', $target->age)[0]) == 65) selected @endif>65+</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            to:<select name="ageTo" id="ageTo" class="form-control">
                                <option value="" @if(!old('ageTo', explode(',', $target->age)[1])) selected @endif>Any</option>
                                @for($i = 13; $i < 65; $i++)
                                    <option value="{{ $i }}" @if(old('ageTo', explode(',', $target->age)[1]) == $i) selected @endif>{{ $i }}</option>
                                @endfor
                                <option value="65" @if(old('ageTo', explode(',', $target->age)[1]) == 65) selected @endif>65+</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Gender</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" name="gender" style="width: 100%;">
                                <option value="" @if(old('gender', $target->gender) == '') selected @endif>Any</option>
                                <option value="1" @if(old('gender', $target->gender) == 1) selected @endif>Male</option>
                                <option value="2" @if(old('gender', $target->gender) == 2) selected @endif>Female</option>
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
                                    <option value="{{ $langaugeKey }}" @if(in_array($langaugeKey, old('languages', explode(',', $target->language)))) selected @endif>{{ $languageValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Interests</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="interests" id="adInterests" class="form-control" rows="3">{{ old('interests', $target->Interests) }}</textarea>
                            <p class="help-block">interests should be separated by comma.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Geo targeting</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle">
                                <input type="checkbox" class="minimal" name="geoTurn" id="geoTurn" value="1" @if(old('geoTurn', 0) == 1 || $target->continent || $target->inc_countries || $target->exc_countries) checked @endif>
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
                                    <input type="checkbox" class="minimal" name="continentTurn" id="continentTurn" value="1" @if(old('continentTurn', 0) == 1 || $target->continent) checked @endif>
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
                                                    @if(old('continents', explode(',', $target->continent)))
                                                    @if(in_array($continentKey, old('continents', explode(',', $target->continent)))) selected @endif
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
                                    <input type="checkbox" class="minimal" name="countriesTurn1" id="countriesTurn1" value="1" @if(old('countriesTurn1', 0) == 1 || $target->inc_countries) checked @endif>
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
                                                    @if(old('inc_countries', explode(',', $target->inc_countries)))
                                                    @if(in_array($countryKey, old('inc_countries', old('continents', explode(',', $target->inc_countries))))) selected @endif
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
                                    <input type="checkbox" class="minimal" name="countriesTurn2" id="countriesTurn2" value="1" @if(old('countriesTurn2', 0) == 1 || $target->exc_countries) checked @endif>
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
                                                    @if(old('exc_countries', explode(',', $target->exc_countries)))
                                                    @if(in_array($countryKey, old('exc_countries', explode(',', $target->exc_countries)))) selected @endif
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
                            <label for="adStatu" class="control-label">Ad statu:</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="nonStyle">
                                <input type="checkbox" class="minimal" value="1" name="adStatu" id="adStatu" @if(old('adStatu', $ad->turn) == 1) checked @endif>
                                Active
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
                    @if($ad->type == 2)
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="estimateContents" class="control-label">Starts:</label>
                            </div>
                            <div class="col-sm-6">
                                <div id="estimateContents">
                                    <p class="bold">
                                        {{ $target->start }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="estimateContents" class="control-label">Ends:</label>
                            </div>
                            <div class="col-sm-6">
                                <div id="estimateContents">
                                    <p class="bold">
                                        {{ $target->end }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submitUpdate" value="submit" class="btn btn-primary">Update</button>
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
            format: 'yyyy-mm-dd'
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
                $("#highKeywordCost").html('<p>the keyword "' + premKeywords.join(", ") + '" is a premier keyword. <a target="_blank" href="#">Read more</a></p>');
            }else if(premKeywords.length !== 0 && premKeywords.length !== 1){
                $("#highKeywordCost").html('<p>the keywords "' + premKeywords.join(", ") + '" are premier keywords. <a target="_blank" href="#">Read more</a></p>');
            }else{
                $("#highKeywordCost").html('');
            }
            // ------------------------------

            // additinal factors--
            @if($costFactors)
                    @foreach($costFactors as $costFactor)
                    @if($costFactor->operation)
            if($("#{{ $costFactor->keyword }}").val() != ''){
                cost += cost {{ $costFactor->operation }} ({{ $costFactor->leverage }} / 100);
            }
            @elseif($costFactor->advancedOperation)
            if($("#{{ $costFactor->keyword }}").val() != ''){
                cost += Math.{{ str_replace('leverage', $costFactor->leverage, $costFactor->advancedOperation) }};
            }
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