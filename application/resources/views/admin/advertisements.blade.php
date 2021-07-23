@extends('admin.layout')

@section('title', 'Manage compains')
@section('Amonetize', 'active')

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/theme/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" />
@endsection

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	search ads
	<small>Internal ads</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.searchads.get') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Search ads</li>
  </ol>
</section>
@endsection


@section('content')
					
					<div class="row">
					    <div class="col-sm-12">
					     <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#settingsModal"><i class="md md-settings"></i> Settings</button>
					     <button onclick="clearNewAdvertisement();" type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#newModal"><i class="md md-add"></i> New advertisement</button>
						</div>
					</div><br/>
					
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
						  <h3 class="box-title">Users ads compains</h3>
						</div>
						<div class="box-body table-responsive">
									
							@if(Session::has('message'))
								<div class="row">
									<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
										  {{ Session::get('message') }}
									</div>
								</div>
							@endif
									
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
											<button type="button" data-toggle="modal" data-target="#showModal" class="btn btn-icon-toggle"><i class="fa fa-eye"></i></button>
											<button onclick="deleteModel({{ $compain['id'] }});" type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button>
										</td>
									</tr>
							   @endforeach
								</tbody>
							</table>
							<center>{{ $compains->render() }}</center>
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
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertisementsController@post') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="CeditOwnerEmail" class="control-label">Enable advertisments on your site:</label>
						</div>
						<div class="col-sm-6">
						    <div class="checkbox">
								<input type="checkbox" id="adsStatuU" name="adsStatu" @if($settings['advertisements']) checked @endif>
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Delete advertisement</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertisementsController@post') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
						    <input name="adId" type="hidden" id="deleteAdId">
							<p>Are you sure you want to delete this advertisement? please now that this action cannot be reversed.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitDelete" value="submit" class="btn btn-primary">Delete</button>
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
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertisementsController@post') }}" method="post">
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
				<h4 class="modal-title" id="formModalLabel">Edit advertisement</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertisementsController@post') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editOwnerEmail" class="control-label">Owner email:</label>
						</div>
						<div class="col-sm-9">
							<input type="hidden" name="adId" id="editAdId">
							<input type="email" name="ownerEmail" id="editOwnerEmail" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editAdTitle" class="control-label">Ad Title:</label>
						</div>
						<div class="col-sm-9">
							<input type="text" name="adTitle" id="editAdTitle" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editAdURL" class="control-label">Ad URL:</label>
						</div>
						<div class="col-sm-9">
							<input type="url" name="adURL" id="editAdURL" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editAdVURL" class="control-label">Ad visible URL:</label>
						</div>
						<div class="col-sm-9">
							<input type="text" name="adVURL" id="editAdVURL" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editAdDescription" class="control-label">Ad Description:</label>
						</div>
						<div class="col-sm-9">
							<textarea name="adDescription" id="editAdDescription" class="form-control" rows="3"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editAdKeywords" class="control-label">Ad Keywords:</label>
						</div>
						<div class="col-sm-9">
							<textarea name="adKeywords" id="editAdKeywords" class="form-control" rows="3"></textarea>
							<p class="help-block">keywords should be separated by comma.</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
						     <label for="editAdStatu" class="control-label">Ad statu:</label>
						</div>
						<div class="col-sm-9">
							<div class="checkbox">
								<input type="checkbox" name="adStatu" id="editAdStatu"> 
								<label for="editAdStatu">Active</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitEditAd" value="submit" class="btn btn-primary">Edit</button>
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

</script>
@endsection