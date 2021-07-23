@extends('admin.layout')

@section('title', 'Maps engine settings')
@section('Aplugins', 'active')

@section('content')
    <style>
        .form-group{
            display: block;
            clear: both;
        }
        label.control-label{
            margin-top: 20px;
        }
    </style>
    <form class="form" method="post" action="{{ route('mapsengine.admin.get') }}">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">Maps engine plugin settings</h3>
            </div>
            <div class="box-body">
                @if(Session::has('message'))
                    <div class="row">
                        <div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Enable Maps search engine:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="active" id="activeY" value="1" @if($engine->turn) checked @endif>
                                <label for="activeY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="active" id="activeN" value="0" @if(!$engine->turn) checked @endif>
                                <label for="activeN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">MapBox Access token:</label>
                        <div class="col-sm-4">
                            <input type="text" name="access_token" class="form-control" value="{{ $settings['maps_access_token'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Show search bar:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="showbar" id="activeBarY" value="1" @if($settings['maps_show_bar']) checked @endif>
                                <label for="activeBarY">Show</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="showbar" id="activeBarN" value="0" @if(!$settings['maps_show_bar']) checked @endif>
                                <label for="activeBarN">Hide</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Show the popup in top result location:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="showpopup" id="showpopupY" value="1" @if($settings['maps_show_popup']) checked @endif>
                                <label for="showpopupY">Show</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="showpopup" id="showpopupN" value="0" @if(!$settings['maps_show_popup']) checked @endif>
                                <label for="showpopupN">Hide</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Real time location search:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="realtime" id="activeRealTimeY" value="1" @if($settings['maps_real_time']) checked @endif>
                                <label for="activeRealTimeY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="realtime" id="activeRealTimeN" value="0" @if(!$settings['maps_real_time']) checked @endif>
                                <label for="activeRealTimeN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Map buttom text:</label>
                        <div class="col-sm-4">
                            <input type="text" name="maps_footer" class="form-control" value='{!! $settings['maps_footer'] !!}'>
                        </div>
                    </div>
                    <hr style="border: 1px solid #eee;clear:both;"/>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Enable routes search:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="enable_routes" id="enable_routesY" value="1" @if($settings['maps_routes_search']) checked @endif>
                                <label for="enable_routesY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="enable_routes" id="enable_routesN" value="0" @if(!$settings['maps_routes_search']) checked @endif>
                                <label for="enable_routesN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Show Alternatives routes on map when available:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="show_alternatives" id="show_alternativesY" value="1" @if($settings['maps_show_alternatives']) checked @endif>
                                <label for="show_alternativesY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="show_alternatives" id="show_alternativesN" value="0" @if(!$settings['maps_show_alternatives']) checked @endif>
                                <label for="show_alternativesN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Map will fit Selected Routes:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="fit_selected_routes" id="fit_selected_routesY" value="1" @if($settings['maps_fit_selected_routes']) checked @endif>
                                <label for="fit_selected_routesY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="fit_selected_routes" id="fit_selected_routesN" value="0" @if(!$settings['maps_fit_selected_routes']) checked @endif>
                                <label for="fit_selected_routesN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Change route by dragging one location point on the map:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="auto_route" id="auto_routeY" value="1" @if($settings['maps_auto_route']) checked @endif>
                                <label for="auto_routeY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="auto_route" id="auto_routeN" value="0" @if(!$settings['maps_auto_route']) checked @endif>
                                <label for="auto_routeN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Units to show:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="unites_to_use" id="unites_to_useY" value="1" @if($settings['maps_unites_to_use']) checked @endif>
                                <label for="unites_to_useY">Meters/kilometers</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="unites_to_use" id="unites_to_useN" value="0" @if(!$settings['maps_unites_to_use']) checked @endif>
                                <label for="unites_to_useN">Yards/miles</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Route line color:</label>
                        <div class="col-sm-4">
                            <input type="text" name="route_path_color" class="form-control" value="{{ $settings['maps_route_path_color'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Color of the CircleMarkers used when hovering an itinerary instruction:</label>
                        <div class="col-sm-4">
                            <input type="text" name="point_color" class="form-control" value="{{ $settings['maps_point_color'] }}">
                        </div>
                    </div>
                </div>

                <div class="text-right" style="clear:both;margin-top:5px;">
                    <button type="submit" class="btn btn-flat btn-primary ink-reaction">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')

@endsection