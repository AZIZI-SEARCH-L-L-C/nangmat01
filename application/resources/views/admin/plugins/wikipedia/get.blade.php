@extends('admin.layout')

@section('title', 'Amazon affiliate settings')
@section('Aplugins', 'active')

@section('content')
    <form class="form" method="post" action="{{ route('wikipedia.admin.get') }}">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h5 class="box-title">Wikipedia plugin settings</h5>
            </div>
            <div class="box-body">
                @if(Session::has('message'))
                    <div class="">
                        <div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Enable Wiki search engine:</label>
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
                        <label for="per_page" class="col-sm-3 control-label">Number of results per page in Wiki Engine:</label>
                        <div class="col-sm-4">
                            <div class="checkbox">
                                <input type="number" name="per_page" id="per_page" class="form-control" value="{{ $engine->per_page }}">
                            </div>
                        </div>
                    </div>
                    <hr style="border: 1px solid #eee;clear:both;"/>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Enable search card:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="enable_query" id="enable_queryY" value="1" @if(config('plugins.wikipedia.enable_query')) checked @endif>
                                <label for="enable_queryY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="enable_query" id="enable_queryN" value="0" @if(!config('plugins.wikipedia.enable_query')) checked @endif>
                                <label for="enable_queryN">Disable</label>
                            </div>
                        </div>
                    </div>
                    <div id="show_card_onlyin_container" class="form-group @if(!config('plugins.wikipedia.enable_query')) hidden @endif">
                        <label for="show_in" class="col-sm-3 control-label">Show Search Info only in:</label>
                        <div class="col-sm-4">
                            <div class="checkbox">
                                <select class="select2" name="show_in[]" multiple id="show_in" style="width: 100%;">
                                    @foreach($engines as $engine)
                                        <option value="{{ $engine->slug }}" @if(in_array($engine->slug, explode(',', config('plugins.wikipedia.show_in')))) selected @endif>{{ $engine->name }} engine</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr style="clear:both;border: 1px solid #eee;"/>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Enable page info:</label>
                        <div class="col-sm-9">
                            <div class="radio radio-inline">
                                <input type="radio" name="enable_page" id="enable_pageY" value="1" @if(config('plugins.wikipedia.enable_page')) checked @endif>
                                <label for="enable_pageY">Enable</label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="enable_page" id="enable_pageN" value="0" @if(!config('plugins.wikipedia.enable_page')) checked @endif>
                                <label for="enable_pageN">Disable</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right" style="clear:both;">
                    <button type="submit" class="btn btn-flat btn-primary ink-reaction">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
<script>
    $('#enable_queryY').change(function () {
        $('#show_card_onlyin_container').removeClass('hidden');
    });
    $('#enable_queryN').change(function () {
        $('#show_card_onlyin_container').addClass('hidden');
    });
</script>

@endsection