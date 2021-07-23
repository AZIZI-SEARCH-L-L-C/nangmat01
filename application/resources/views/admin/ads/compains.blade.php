@extends('admin.layout')

@section('title', 'Manage compains')
@section('Amonetize', 'active')

@section('css')

@endsection

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	ads compains
	<small>Internal ads</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.searchcompains.get') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Ads compains</li>
  </ol>
</section>
@endsection


@section('content')
					
<div class="row">
	<div class="col-sm-12">
	 <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#settingsModal"><i class="fa fa-cog"></i> Settings</button>
	 <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#newCompainModal"><i class="fa fa-plus"></i> New Compain</button>
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
	  <h3 class="box-title">Users ads compains</h3>
	</div>
	<div class="box-body table-responsive">
		@if($compains->isEmpty())
			<center>You have no compains right now.</center>
		@else
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Compain name</th>
						<th>Username</th>
						<th>#ads</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($compains as $compain)
					<tr>
						<td>{{ $compain['name'] }}</td>
						<td>{{ $compain->user->username }}</td>
						<td>{{ $compain->ads->count() }}</td>
						<td class="text-right">
							<a href="{{ route('admin.searchads.get', $compain->id) }}"><button type="button" class="btn btn-icon-toggle">Manage ads</button></a>
							<button onclick="editModal({{ $compain['id'] }}, '{{ $compain['name'] }}');" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
							<button onclick="deleteCompain({{ $compain['id'] }});" type="button" class="btn"><i class="fa fa-trash-o"></i></button>
						</td>
					</tr>
			   @endforeach
				</tbody>
			</table>
			<center>{{ $compains->render() }}</center>
		@endif
	</div><!--end .card-body -->
</div><!--end .card -->
			
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Update advertisement settings</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ action('admin\AdvertisementsController@postCompains') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="CeditOwnerEmail" class="control-label">Enable advertisments on your site:</label>
						</div>
						<div class="col-sm-6">
						    <div class="checkbox">
								<input type="checkbox" id="adsStatuU" name="adsStatu" @if($settings['advertisements']) checked @endif class="minimal">
								<label for="adsStatuU">Active</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<label for="CeditOwnerEmail" class="control-label">Max number of ads per request:</label>
						</div>
						<div class="col-sm-6">
						    <input type="number" name="numberAds" class="form-control" id="spinner" value="{{ $settings['takeFromAdvertisements'] }}"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitSettings" value="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->	

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Create new advertisement</h4>
			</div>
			<form class="form-horizontal" role="form" action="" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="CeditOwnerEmail" class="control-label">Owner email:</label>
						</div>
						<div class="col-sm-9">
							<input type="email" name="ownerEmail" id="CeditOwnerEmail" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="CeditAdTitle" class="control-label">Ad Title:</label>
						</div>
						<div class="col-sm-9">
							<input type="text" name="adTitle" id="CeditAdTitle" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="CeditAdURL" class="control-label">Ad URL:</label>
						</div>
						<div class="col-sm-9">
							<input type="url" name="adURL" id="CeditAdURL" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="CeditAdVURL" class="control-label">Ad visible URL:</label>
						</div>
						<div class="col-sm-9">
							<input type="text" name="adVURL" id="CeditAdVURL" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="CeditAdDescription" class="control-label">Ad Description:</label>
						</div>
						<div class="col-sm-9">
							<textarea name="adDescription" id="CeditAdDescription" class="form-control" rows="3"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="CeditAdKeywords" class="control-label">Ad Keywords:</label>
						</div>
						<div class="col-sm-9">
						    <textarea name="adKeywords" id="CeditAdKeywords" class="form-control" rows="3"></textarea>
							<p class="help-block">keywords should be separated by comma.</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
						     <label for="CeditAdStatu" class="control-label">Ad statu:</label>
						</div>
						<div class="col-sm-9">
							<div class="checkbox">
								<input type="checkbox" name="adStatu" id="CeditAdStatu">
								<label for="CeditAdStatu">Active</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitNew" value="submit" class="btn btn-primary">Create new</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Edit compain</h4>
			</div>
			<form class="form-horizontal" role="form" action="" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editCompainName" class="control-label">Compain name:</label>
						</div>
						<div class="col-sm-9">
							<input type="hidden" name="compainId" id="editCompianId">
							<input type="text" name="compainName" id="editCompainName" class="form-control">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitCompainAd" value="submit" class="btn btn-primary">Edit</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="newCompainModal" tabindex="false" role="dialog" aria-labelledby="formModalLabelnewCompainModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">New compain</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ route('admin.searchads.compain.new') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="newComainUser" class="control-label">User:</label>
						</div>
						<div class="col-sm-9">
							<select class="form-control select2" name="compainUser" id="newComainUser" data-placeholder="Select a User" style="width: 100%;"></select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="newCompainName" class="control-label">Compain name:</label>
						</div>
						<div class="col-sm-9">
							<input type="text" name="compainName" id="newCompainName" class="form-control">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitNewCompain" value="submit" class="btn btn-primary">New</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->
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

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Ad preview</h4>
			</div>
				<div class="modal-body">
				<div class="row">
				  <div class="col-sm-6">
				       <p>Basic information:</p>
					   <p><strong>Owner Email:</strong> <span id="showOwnerEmail"></span></p>
					   <p><strong>Ad URL:</strong> <a href="#" target="_blank" id="showAdURL" class="text-info"></a></p>
					   <p><strong>Ad Visible URL:</strong> <span id="showAdVURL"></span></p>
					   <p><strong>Ad keywords:</strong> <span id="showAdKeywords"></span></p>
					   <p><strong>Ad Statu:</strong> <span id="showAdStatu"></span></p>
				  </div>
				  <div class="col-sm-6">
				       <p>How users will see this ad:</p>
				  <div class="card">
				   <div class="card-body">
				    <a class="text-info" id="showDemoAdURL" target="_blank" href="#"></a>
					<p class="text-success"><span class="badge style-warning">Ad</span> <span id="showDemoVURL"></span></p> 
					<p id="showDemoAdDescription"></p>
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
@endsection

@section('javascript')
<script>
function deleteCompain($id){
	c = confirm("Are you sure you want to delete this compain with all its ads?");
	if(c){
		window.location.href = "{{ route('admin.searchads.compain.delete', '') }}/" + $id;
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

function editModal($id, $name){
	// id
	$('#editCompianId').val($id);
	// email
	$('#editCompainName').val($name);
}

function deleteModel($id){
	$('#deleteAdId').val($id);
}

function copyModel($id, $email, $url, $Vurl, $keywords, $statu, $title, $desc){
	// email
	$('#CeditOwnerEmail').val($email);
	// URL
	$('#CeditAdURL').val($url);
	// VURL
	$('#CeditAdVURL').val($Vurl);
	// Keywords
	$('#CeditAdKeywords').val($keywords);
	// statu
	$('#CeditAdStatu').prop('checked', $statu);
	// Title
	$('#CeditAdTitle').val($title);
	// dsecription
	$('#CeditAdDescription').val($desc);
}

$(document).ready(function() {
    $('.select2#newComainUser').select2({
        ajax: {
            url: '{{ route('admin.api.ajax.users') }}',
            dataType: 'json',
            data: function (params) {
                var query = {
                    q: params.term,
                    page: params.page || 1
                }
                return query;
            }
        }
    });
});

</script>
@endsection