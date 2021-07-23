@extends('admin.layout')

@section('title', 'Manage ads')
@section('Amonetize', 'active')

@section('css')
<link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="{{ asset('assets/templates/default/css/materialize-tags.css') }}" rel="stylesheet"/>
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
		<a class="btn ink-reaction btn-primary" href="{{ route('admin.searchads.new.get', $compain->id) }}"><i class="fa fa-plus"></i> New Ad</a>
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

<div class="box box-primary box-solid">
	<div class="box-header with-border">
	  <h3 class="box-title">Ads of comapin: {{ $compain->name }}, user: {{ $compain->user->username }}</h3>
	</div>
	<div class="box-body table-responsive">

		@if(!$ads->isEmpty())
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Ad Unit name</th>
						<th>Username</th>
						<th>Cost</th>
						<th>Per</th>
						<th>Budget</th>
						<th>Paid</th>
						<th>Statu</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($ads as $ad)
					<tr>
						<td>{{ $ad['name'] }}</td>
						<td>{{ $ad->user->username }}</td>
						<td>${{ $ad->costPer }}</td>
						<td>@if($ad->type == 0) Click @elseif($ad->type == 1) Impression @elseif($ad->type == 2) Period @endif</td>
						<td>@if($ad->useBudget) ${{ $ad->budget }} @else Unlimited* @endif</td>
						<td>${{ $ad->paid }}</td>
						<td>@if(!$ad->approved) <span class="label label-danger">Unapproved</span> @else @if($ad->turn) <span class="label label-success">Active</span> @else <span class="label label-danger">Unactive</span> @endif @endif</td>
						<td class="text-right">
							@if(!$ad->approved)
								<button type="button" data-toggle="modal" onclick="$('#approveAdId').val({{ $ad->id }});" id="approveButton-{{ $ad->id }}" data-target="#approveModal" class="btn btn-icon-toggle"><i class="fa fa-check-square"></i></button>
							@endif
							<button type="button" data-toggle="modal" data-target="#showModal-{{ $ad->id }}" class="btn btn-icon-toggle"><i class="fa fa-eye"></i></button>
							<a href="{{ route('admin.searchads.edit', $ad->id) }}"><button type="button" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button></a>
							<button onclick="deleteAd({{ $ad['id'] }});" type="button" class="btn"><i class="fa fa-trash-o"></i></button>
						</td>
					</tr>
			   @endforeach
				</tbody>
			</table>
			<center>{{ $ads->render() }}</center>
		@else
			<p class="text-center">There is no ads in this compain.</p>
		@endif
	</div><!--end .card-body -->
</div><!--end .card -->
<p>*Unlimited budget means the ad will continue until the funds in the account of user ends.</p>

<style>
.badge.style-warning {
  background-color: #FF9800;
  border-color: #FF9800;
  color: #fff;
}
.text-success {
    color: #4CAF50;
}
.modal-content {
    font-size: 13px !important;
}
</style>

@foreach($ads as $ad)
	<div class="modal fade" id="showModal-{{ $ad->id }}" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="formModalLabel">Preview ad: {{ $ad->title }}</h4>
				</div>
				<div class="modal-body">
					<div class="row">
					  <div class="col-sm-6">
						   <p>Basic information:</p>
						   <p><strong>Owner name:</strong> {{ $ad->user->username }}</p>
						   <p><strong>Owner Email:</strong> {{ $ad->user->email }}</p>
						   <p><strong>Ad URL:</strong> <a href="{{ $ad->url }}" target="_blank" id="showAdURL" class="text-info">{{ $ad->url }}</a></p>
						   <p><strong>Ad Visible URL:</strong> {{ $ad->Vurl }}</p>
						   <p><strong>Ad keywords:</strong> {{ $ad->keywords }}</p>
						   @if($ad->type == 0)
							<p><strong>Cost per click:</strong> {{ $ad->costPer }}</p>
						   @elseif($ad->type == 1)
							<p><strong>Cost per impressions:</strong> {{ $ad->costPer }}</p>
						   @elseif($ad->type == 2)
							<p><strong>Cost per days:</strong> {{ $ad->costPer }}</p>
						   @endif
						   <p><strong>Ad Statu:</strong> @if($ad->turn) <span class="label label-success">Active</span> @else <span class="label label-danger">Unactive</span> @endif</p>
					  </div>
					  <div class="col-sm-6">
						   <p>How users will see this ad:</p>
					  <div class="panel panel-default">
					   <div class="panel-body">
						<a class="text-info" target="_blank" href="{{ $ad->url }}">{{ $ad->title }}</a>
						<p class="text-success"><span class="badge style-warning">Ad</span> {{ $ad->Vurl }}</p> 
						<p id="showDemoAdDescription">{{ $ad->description }}</p>
					   </div>
					  </div>
					  </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
@endforeach

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="approveModalLabel">Approve ad</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to approve this ad for listing?</p>
				<p>Make sure you review the ad initial cost & all details.</p>
				<input type="hidden" id="approveAdId"/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" onclick="approveAd();" value="submit" class="btn btn-primary">Approve</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->	

@endsection

@section('javascript')
<script src="{{ asset('assets/templates/default/js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('assets/templates/default/js/materialize-tags.js') }}"></script>
<script>
function deleteAd($id){
    c = confirm("Are you sure you want to delete this ad?");
    if(c){
        window.location.href = "{{ route('admin.searchads.ad.delete', '') }}/" + $id;
	}
}
function clearNewAdvertisement() {
	$('#CeditOwnerEmail').val('');
	$('#CeditAdURL').val('');
	$('#CeditAdVURL').val('');
	$('#CeditAdKeywords').val('');
	$('#CeditAdStatu').prop('checked', 0);
	$('#CeditAdTitle').val('');
	$('#CeditAdDescription').val('');
}
function showModel($email, $url, $Vurl, $keywords, $statu, $title, $desc){
	// email
	$('#showOwnerEmail').html($email);
	// URL
	$('#showAdURL').html($url);
	$('#showAdURL').attr("href", $url)
	$('#showDemoAdURL').attr("href", $url)
	// VURL
	$('#showAdVURL').html($Vurl);
	$('#showDemoVURL').html($Vurl);
	// Keywords
	$('#showAdKeywords').html($keywords);
	// statu
	$('#showAdStatu').html($statu);
	// Title
	$('#showDemoAdURL').html($title);
	// dsecription
	$('#showDemoAdDescription').html($desc);
}

function editModel($id, $email, $url, $Vurl, $keywords, $statu, $title, $desc){
	// id
	$('#editAdId').val($id);
	// email
	$('#editOwnerEmail').val($email);
	// URL
	$('#editAdURL').val($url);
	// VURL
	$('#editAdVURL').val($Vurl);
	// Keywords
	$('#editAdKeywords').val($keywords);
	// statu
	$('#editAdStatu').prop('checked', $statu);
	// Title
	$('#editAdTitle').val($title);
	// dsecription
	$('#editAdDescription').val($desc);
}

function approveAd(e){
	var $ad = $("#approveAdId").val();
	var dataIn = {adId: $ad};
	var $url = '{{ route("admin.api.ajax.searchads.approve") }}';
	$.ajax({
	  type: "POST",
	  url: $url,
	  data: dataIn,
	  success: function(data){
		  sendMessage('alert-success', data);
		  $('#approveModal').modal('hide');
		  $('#approveButton-' + $ad).hide();
	  },
	  error: function(e){
		  sendMessage('alert-danger', e.responseText);
		  $('#approveButton-' + $ad).hide();
	  }
	});
	return false;
}

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


</script>
@endsection