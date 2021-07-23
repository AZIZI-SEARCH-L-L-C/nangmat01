@extends('admin.layout')

@section('title', 'General Settings')
@section('Aengines', 'active')

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/css/select2.min.css') }}" />
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
	Edit {{ $engine->name }} engine
	<small>Edit engine settings</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="{{ route('admin.engines') }}"><i class="fa fa-dashboard"></i> Engines</a></li>
	<li class="active">Settings</li>
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
	<div class="row">
		<div class="col-lg-12">
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
				  <h3 class="box-title">{{ $engine->name }} settings</h3>
				  <!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form class="form-horizontal save" role="form" action="{{ URL::action('admin\EnginesController@postEdit', $engine->name) }}" method="post">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-3"></div>
							<div class="col-sm-9">
								<div class="checkbox">
									<input type="checkbox" name="active" id="active" class="minimal" @if($engine->turn) checked @endif>
									<label for="active">Active</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-3">
								<label for="EngineName" class="control-label">Name</label>
							</div>
							<div class="col-sm-9">
								<input type="hidden" name="name" id="name" value="{{ $engine->name }}">
								<input type="text" id="EngineName" class="form-control" value="{{ $engine->name }}" disabled>
							</div>
						</div>
						@if($engine->name == 'web' or $engine->name == 'images')
							<div class="form-group">
								<div class="col-sm-3">
									<label for="key" class="control-label">Google Cse Key:</label>
								</div>
								<div class="col-sm-9">
									@if($engine->name == 'web')
										<input type="text" name="googleWebCsePublicKey" id="googleWebCsePublicKey" class="form-control" placeholder="key" value="{{ $settings['googleWebCsePublicKey'] }}">
									@elseif($engine->name == 'images')
										<input type="text" name="googleImagesCsePublicKey" id="googleImagesCsePublicKey" class="form-control" placeholder="key" value="{{ $settings['googleImagesCsePublicKey'] }}">
									@endif
								</div>
							</div>
						@endif
						<div class="form-group">
							<div class="col-sm-3">
								<label for="max" class="control-label">Max results per page:</label>
							</div>
							<div class="col-sm-9">
								<input type="number" name="{{ 'perPage'.ucfirst($engine->name) }}" id="{{ 'perPage'.ucfirst($engine->name) }}" class="form-control" value="{{ $settings['perPage'.ucfirst($engine->name)] }}">
							</div>
						</div>
						@if($engine->name == 'web')
							<hr/>
							<div class="form-group">
								<div class="col-sm-3">
									<label>Web filters:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="dateFilter" id="dateFilter" class="minimal" @if($settings['dateFilter']) checked @endif>
										<label for="dateFilter">Enable date filter.</label>
									</div>
								</div>
							</div>
							<div class="form-group" id="countriesFilterCheckContainer">
								<div class="col-sm-3">
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="countryFilter" id="countriesFilter" class="minimal" @if($settings['countryFilter']) checked @endif>
										<label for="countriesFilter">Enable countries filter.</label>
									</div>
								</div>
							</div>
							<div class="form-group" style="display:none;" id="countriesFilterContainer">
								<div class="col-sm-3">
								</div>
								<div class="col-sm-9">
									<label for="countriesFilterCountries" class="control-label">Countries allowed: <i data-placement="top" title="The countries that can your vistiros filter results from it." data-toggle="tooltip" class="fa fa-question-circle"></i></label>
									<select class="form-control select2" name="countries[]" multiple="multiple" data-placeholder="Select file types used by filter."
										style="width: 100%;">
										@foreach(config('locales') as $localKey => $localValue)
											<option value="{{ $localKey }}" @if(in_array($localKey, explode(',', $settings['countries']))) selected @endif>{{ $localValue }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group" style="display:none;" id="firstCountriesFilterContainer">
								<div class="col-sm-3">
								</div>
								<div class="col-sm-9">
									<label for="countriesFilterFirstCountries" class="control-label">First four countries: <i data-placement="top" title="Countries that shown in filter first." data-toggle="tooltip" class="fa fa-question-circle"></i></label>
									<select class="form-control select2" name="firstCountries[]" id="countriesFilterFirstCountries" multiple="multiple" data-placeholder="Select file types used by filter."
										style="width: 100%;">
										@foreach(config('locales') as $localKey => $localValue)
											<option value="{{ $localKey }}" @if(in_array($localKey, explode(',', $settings['firstCountries']))) selected @endif>{{ $localValue }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group" id="documentsFilterCheckContainer">
								<div class="col-sm-3">
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="documentsFilter" id="documentsFilter" class="minimal" @if($settings['documentsFilter']) checked @endif>
										<label for="documentsFilter">Enable documents filter.</label>
									</div>
								</div>
							</div>
							<div class="form-group" style="display:none;" id="documentsFilterContainer">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<label for="key" class="control-label">Choose documents allowed:</label>
									<select class="form-control select2" name="fileTypes[]" multiple="multiple" data-placeholder="Select file types used by filter."
										style="width: 100%;">
										@foreach(config('app.fileTypes') as $fileType)
											<option value="{{ $fileType }}" @if(in_array($fileType, explode(',', $settings['fileTypes']))) selected @endif>{{ ucfirst($fileType) }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<hr/>
							<div class="form-group">
								<div class="col-sm-3">
									<label>Pagination type:</label>
								</div>
								<div class="col-sm-9">
									<select name="webPagination" id="webPagination" class="form-control">
										<option value="1" @if($settings['webPagination'] == 1) selected @endif>Next & previews pagination</option>
										<option value="2" @if($settings['webPagination'] == 2) selected @endif>pagination with pages numbers</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="webPaginationFullContainer">
								<div class="col-sm-3">
									<label>Pages number from APIs:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="webPaginationFull" id="webPaginationFull" class="minimal" @if($settings['webPaginationFull']) checked @endif>
										<label for="webPaginationFull">Show all pages proided by APIs.</label>
									</div>
								</div>
							</div>
							<div class="form-group" id="webPaginationLimitContainer">
								<div class="col-sm-3">
									<label>Limit pages:</label>
								</div>
								<div class="col-sm-9">
									<input type="number" name="webPaginationLimit" id="webPaginationLimit" class="form-control" value="{{ $settings['webPaginationLimit'] }}">
								</div>
							</div>
							<hr/>
							<div class="form-group">
								<div class="col-sm-3">
									<label>Show top:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="imagesAllturn" id="imagesAllturn" class="minimal" @if($settings['imagesAllturn']) checked @endif>
										<label for="imagesAllturn">Images</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="videosAllturn" id="videosAllturn" class="minimal" @if($settings['videosAllturn']) checked @endif>
										<label for="videosAllturn">Videos</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="newsAllturn" id="newsAllturn" class="minimal" @if($settings['newsAllturn']) checked @endif>
										<label for="newsAllturn">News</label>
									</div>
								</div>
							</div>
							<div class="form-group" id="imagesPositionContainer">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<label for="imagesPosition">images position:</label>
									<input type="number" name="imagesPosition" id="imagesPosition" class="form-control" value="{{ $settings['imagesPosition'] }}">
								</div>
							</div>
							<div class="form-group" id="videosPositionContainer">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<label for="videosPosition">videos position:</label>
									<input type="number" name="videosPosition" id="videosPosition" class="form-control" value="{{ $settings['videosPosition'] }}">
								</div>
							</div>
							<div class="form-group" id="newsPositionContainer">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<label for="newsPosition">news position:</label>
									<input type="number" name="newsPosition" id="newsPosition" class="form-control" value="{{ $settings['newsPosition'] }}">
								</div>
							</div>
							<hr/>
							<div class="form-group">
								<div class="col-sm-3">
									<label>Widgets:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="mathCalc" id="mathCalc" class="minimal" @if($settings['mathCalc']) checked @endif>
										<label for="mathCalc">Math calculation when the query has a math operation.</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="timeZone" id="timeZone" class="minimal" @if($settings['timeZone']) checked @endif>
										<label for="timeZone">Time if the user look for time.</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="facts" id="facts" class="minimal" @if($settings['facts']) checked @endif>
										<label for="facts">Description of a fact if there is one related to the search.</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="translations" id="translations" class="minimal" @if($settings['translations']) checked @endif>
										<label for="translations">Translate words if there the user look for translation.</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="entities" id="entities" class="minimal" @if($settings['entities']) checked @endif>
										<label for="entities">Entities.</label>
									</div>
								</div>
							</div>
							<div id="entitiesContainer">
								<div class="form-group">
									<div class="col-sm-3"></div>
									<div class="col-sm-9">
										<label for="entitiesNum">max number of entities.</label>
										<input type="number" name="entitiesNum" id="entitiesNum" class="form-control" value="{{ $settings['entitiesNum'] }}">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3"></div>
									<div class="col-sm-9">
										<label for="entityTruncate">entity description truncate:</label>
										<input type="number" name="entityTruncate" id="entityTruncate" class="form-control" value="{{ $settings['entityTruncate'] }}">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3"></div>
									<div class="col-sm-9">
										<label for="countriesFilterCountries" class="control-label">Entities allowed: <i data-placement="top" title="Helping for this." data-toggle="tooltip" class="fa fa-question-circle"></i></label>
										<select class="form-control select2" name="entitesAllowed[]" multiple="multiple"style="width: 100%;">
											@foreach(config('app.entities') as $entity)
												<option value="{{ $entity }}" @if(in_array($entity, explode(',', $settings['entitesAllowed']))) selected @endif>{{ $entity }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						@elseif($engine->name == 'images')
							<div class="form-group">
								<div class="col-sm-3">
									<label>Images filters:</label>
								</div>
								<div class="col-sm-9">
									<p>Users can filter images with:</p>
									<div class="checkbox">
										<input type="checkbox" name="imgColorFilter" id="imgColorFilter" class="minimal" @if($settings['imgColorFilter']) checked @endif>
										<label for="imgColorFilter">Image Color</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="imgTypeFilter" id="imgTypeFilter" class="minimal" @if($settings['imgTypeFilter']) checked @endif>
										<label for="imgTypeFilter">Image type</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="imgLicenseFilter" id="imgLicenseFilter" class="minimal" @if($settings['imgLicenseFilter']) checked @endif>
										<label for="imgLicenseFilter">Image license</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="imgSizeFilter" id="imgSizeFilter" class="minimal" @if($settings['imgSizeFilter']) checked @endif>
										<label for="imgSizeFilter">Image size</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<label>Pagination type:</label>
								</div>
								<div class="col-sm-9">
									<select name="imagesPagination" id="imagesPagination" class="form-control">
										<option value="1" @if($settings['imagesPagination'] == 1) selected @endif>Next & previews pagination</option>
										<option value="2" @if($settings['imagesPagination'] == 2) selected @endif>pagination with pages numbers</option>
										<option value="3" @if($settings['imagesPagination'] == 3) selected @endif>Load more</option>
									</select>
								</div>
							</div>
                            <div class="form-group" id="imagesPaginationFullContainer">
                                <div class="col-sm-3">
                                    <label>Pages number from APIs:</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="checkbox">
                                        <input type="checkbox" name="imagesPaginationFull" id="imagesPaginationFull" class="minimal" @if($settings['imagesPaginationFull']) checked @endif>
                                        <label for="imagesPaginationFull">Show all pages proided by APIs.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="imagesPaginationLimitContainer">
                                <div class="col-sm-3">
                                    <label>Limit pages:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" name="imagesPaginationLimit" id="imagesPaginationLimit" class="form-control" value="{{ $settings['imagesPaginationLimit'] }}">
                                </div>
                            </div>
						@elseif($engine->name == 'videos')
							<div class="form-group">
								<div class="col-sm-3">
									<label>Videos filters:</label>
								</div>
								<div class="col-sm-9">
									<p>Users can filter videos with:</p>
									<div class="checkbox">
										<input type="checkbox" name="videosPricingFilter" id="videosPricingFilter" class="minimal" @if($settings['videosPricingFilter']) checked @endif>
										<label for="videosPricingFilter">Video pricing</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="videosLengthFilter" id="videosLengthFilter" class="minimal" @if($settings['videosLengthFilter']) checked @endif>
										<label for="videosLengthFilter">Video length</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="videosResolutionFilter" id="videosResolutionFilter" class="minimal" @if($settings['videosResolutionFilter']) checked @endif>
										<label for="videosResolutionFilter">Video resolution</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<label>Pagination type:</label>
								</div>
								<div class="col-sm-9">
									<select name="videosPagination" id="videosPagination" class="form-control">
										<option value="1" @if($settings['videosPagination'] == 1) selected @endif>Next & previews pagination</option>
										<option value="2" @if($settings['videosPagination'] == 2) selected @endif>pagination with pages numbers</option>
										<option value="3" @if($settings['videosPagination'] == 3) selected @endif>Load more</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="videosPaginationFullContainer">
								<div class="col-sm-3">
									<label>Pages number from APIs:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="videosPaginationFull" id="videosPaginationFull" class="minimal" @if($settings['videosPaginationFull']) checked @endif>
										<label for="videosPaginationFull">Show all pages proided by APIs.</label>
									</div>
								</div>
							</div>
							<div class="form-group" id="videosPaginationLimitContainer">
								<div class="col-sm-3">
									<label>Limit pages:</label>
								</div>
								<div class="col-sm-9">
									<input type="number" name="videosPaginationLimit" id="videosPaginationLimit" class="form-control" value="{{ $settings['videosPaginationLimit'] }}">
								</div>
							</div>
						@elseif($engine->name == 'news')
							<div class="form-group">
								<div class="col-sm-3">
									<label for="newsPagination">Pagination type:</label>
								</div>
								<div class="col-sm-9">
									<select class="form-control" name="newsPagination" id="newsPagination">
										<option value="1" @if($settings['newsPagination'] == 1) selected @endif>Next & previews pagination</option>
										<option value="2" @if($settings['newsPagination'] == 2) selected @endif>pagination with pages numbers</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="newsPaginationFullContainer">
								<div class="col-sm-3">
									<label>Pages number from APIs:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="newsPaginationFull" id="newsPaginationFull" class="minimal" @if($settings['newsPaginationFull']) checked @endif>
										<label for="newsPaginationFull">Show all pages proided by APIs.</label>
									</div>
								</div>
							</div>
							<div class="form-group" id="newsPaginationLimitContainer">
								<div class="col-sm-3">
									<label>Limit pages:</label>
								</div>
								<div class="col-sm-9">
									<input type="number" name="newsPaginationLimit" id="newsPaginationLimit" class="form-control" value="{{ $settings['newsPaginationLimit'] }}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<label for="newsDateFormat">how to show date:</label>
								</div>
								<div class="col-sm-9">
									<select class="form-control" name="newsDateFormat" id="newsDateFormat">
										<option value="1" @if($settings['newsDateFormat'] == 1) selected @endif>with specific format</option>
										<option value="2" @if($settings['newsDateFormat'] == 2) selected @endif>with time ago</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="newsDateFormatformContainer">
								<div class="col-sm-3">
									<label for="newsDateFormatform" class="control-label">News date format:</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="newsDateFormatform" id="newsDateFormatform" class="form-control" value="{{ $settings['newsDateFormatform'] }}">
								</div>
							</div>
							<div class="form-group" id="newsDateFullContainer">
								<div class="col-sm-3">
									<label for="newsDateFull" class="control-label">News date full:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="newsDateFull" id="newsDateFull" class="minimal" @if($settings['newsDateFull']) checked @endif>
										<label for="newsDateFull">Show full date (e.g: )</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<label for="newsThumbnail">Show thumbnail:</label>
								</div>
								<div class="col-sm-9">
									<div class="checkbox">
										<input type="checkbox" name="newsThumbnail" id="newsThumbnail" class="minimal" @if($settings['newsThumbnail']) checked @endif>
										<label for="newsThumbnail">Enable results thumbnails</label>
									</div>
								</div>
							</div>
						@endif


						<div class="form-group">
							<div class="col-sm-3"></div>
							<div class="col-sm-9">
								<label for="apiProviders" class="control-label">APIs Providers: </label>
								<select class="form-control select2" name="apiProviders[]" id="apiProviders" multiple="multiple" style="width: 100%;">
									@foreach(config('app.apiProviders') as $provider => $apisengines)
										@if(in_array($engine->name, $apisengines))
											<option value="{{ $provider }}" @if(in_array($provider, config('app.api'.ucfirst($engine->name).'Providers'))) selected @endif>{{ last(explode('\\', $provider)) }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

					</div>
					
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection

@section('javascript')
<script src="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>
// filters JS
// documents
$('#documentsFilter').on('ifChecked', function() {
	$('#documentsFilterContainer').show();
});
$('#documentsFilter').on('ifUnchecked', function() {
	$('#documentsFilterContainer').hide();
});
// countries
$('#countriesFilter').on('ifChecked', function() {
	$('#countriesFilterContainer').show();
	$('#firstCountriesFilterContainer').show();
});
$('#countriesFilter').on('ifUnchecked', function() {
	$('#countriesFilterContainer').hide();
	$('#firstCountriesFilterContainer').hide();
});
// images position
$('#imagesAllturn').on('ifChecked', function() {
	$('#imagesPositionContainer').show();
});
$('#imagesAllturn').on('ifUnchecked', function() {
	$('#imagesPositionContainer').hide();
});
// news position
$('#newsAllturn').on('ifChecked', function() {
	$('#newsPositionContainer').show();
});
$('#newsAllturn').on('ifUnchecked', function() {
	$('#newsPositionContainer').hide();
});
// videos position
$('#videosAllturn').on('ifChecked', function() {
	$('#videosPositionContainer').show();
});
$('#videosAllturn').on('ifUnchecked', function() {
	$('#videosPositionContainer').hide();
});

// entities
$('#entities').on('ifChecked', function() {
	$('#entitiesContainer').show();
});
$('#entities').on('ifUnchecked', function() {
	$('#entitiesContainer').hide();
});

// news format
$('#newsDateFormat').on('change', function() {
	if($(this).val() == 1){
		$('#newsDateFormatformContainer').show();
		$('#newsDateFullContainer').hide();
	}else if($(this).val() == 2){
		$('#newsDateFormatformContainer').hide();
		$('#newsDateFullContainer').show();
	}
	// $('#videosPositionContainer').show();
});

// pagination
$('#{{ $engine->name. 'PaginationFull' }}').on('ifChecked', function() {
    $('#{{ $engine->name }}PaginationLimitContainer').hide();
});
$('#{{ $engine->name. 'PaginationFull' }}').on('ifUnchecked', function() {
    $('#{{ $engine->name }}PaginationLimitContainer').show();
});

$('#{{ $engine->name. 'Pagination' }}').on('change', function() {
	if($(this).val() == 2){
		$('#{{ $engine->name }}PaginationFullContainer').show();
		@if($settings[$engine->name. 'PaginationFull'])
        	$('#{{ $engine->name }}PaginationLimitContainer').hide();
        @else
        	$('#{{ $engine->name }}PaginationLimitContainer').show();
    	@endif
	}else{
        $('#{{ $engine->name }}PaginationFullContainer').hide();
        $('#{{ $engine->name }}PaginationLimitContainer').hide();
	}
});

$(document).ready(function() {
	@if($settings['countryFilter'])
		$('#{{ $engine->name }}PaginationFullContainer').show();
		$('#firstCountriesFilterContainer').show();
	@else
		$('#countriesFilterContainer').hide();
		$('#firstCountriesFilterContainer').hide();
	@endif
	@if($settings['documentsFilter'])
		$('#documentsFilterContainer').show();
	@else
		$('#documentsFilterContainer').hide();
	@endif
	@if($settings['imagesAllturn'])
		$('#imagesPositionContainer').show();
	@else
		$('#imagesPositionContainer').hide();
	@endif
	@if($settings['videosAllturn'])
		$('#videosPositionContainer').show();
	@else
		$('#videosPositionContainer').hide();
	@endif
	@if($settings['newsAllturn'])
		$('#newsPositionContainer').show();
	@else
		$('#newsPositionContainer').hide();
	@endif
	
	@if($settings['newsDateFormat'] == 1)
		$('#newsDateFormatformContainer').show();
		$('#newsDateFullContainer').hide();
	@else
		$('#newsDateFormatformContainer').hide();
		$('#newsDateFullContainer').show();
	@endif

	@if($settings[$engine->name. 'Pagination'] == 2)
		$('#{{ $engine->name }}PaginationFullContainer').show();
		@if($settings[$engine->name. 'PaginationFull'])
			$('#{{ $engine->name }}PaginationLimitContainer').hide();
			$('#{{ $engine->name }}PaginationFull').prop('checked');
		@endif
	@else
		$('#{{ $engine->name }}PaginationFullContainer').hide();
		$('#{{ $engine->name }}PaginationLimitContainer').hide();
	@endif
});
</script>
@endsection