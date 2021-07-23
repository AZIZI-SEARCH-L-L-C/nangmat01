@extends('admin.layout')

@section('title', 'Manage advertisers')
@section('Amonetize', 'active')

@section('content')
					
									<div class="card">
									<div class="card-body">
									
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
									<th>name</th>
									<th>email</th>
									<th>message</th>
									<th>statu</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
							@foreach($advertiser as $Cadvertisement)
								<tr>
									<td>{{ $Cadvertisement['name'] }}</td>
									<td>{{ $Cadvertisement['email'] }}</td>
									<td>{{ $Cadvertisement['message'] }}</td>
									<td>@if($Cadvertisement['read']) <span class="text-success">Discussed</span> @else <span class="text-danger">Not yet</span> @endif</td>
									<td class="text-right">
										@if($Cadvertisement['read']) No action required @else<button onclick="contactAdvertiser({{ $Cadvertisement['id'] }});" type="button" data-toggle="modal" data-target="#contactedModal" class="btn btn-icon-toggle"><i class="fa fa-envelope"></i></button> @endif
									</td>
								</tr>
						   @endforeach
							</tbody>
						</table>
									</div><!--end .card-body -->
								</div><!--end .card -->

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="contactedModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Make As contected</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\AdvertiserController@post') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
						    <input name="adId" type="hidden" id="contactedAdId">
							<p>do you contact this advertiser? if yes just click on contacted so that it will be deleted from your TODO-list.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitContacted" value="submit" class="btn btn-primary">contacted</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->			
@endsection

@section('javascript')
<script>
function contactAdvertiser($id){
	$('#contactedAdId').val($id);
}
</script>
@endsection