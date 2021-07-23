@extends('admin.layout')

@section('title', 'manage language phrases')
@section('Alanguages', 'active')


@section('content')
					
											<div class="row">
											  <div class="col-sm-12">
											
												<div class="btn-group">
													<button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="md md-keyboard-arrow-right"></i> Phrases category</button>
													<button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-caret-down"></i></button>
													<ul class="dropdown-menu dropdown-menu-left" role="menu">
													@foreach($phrases_files as $cate)
														    <li><a href="{{ URL::action('admin\LanguagesController@getEditPhrases', [$lang_code, $cate]) }}">{{ ucfirst($cate) }}</a></li>
													@endforeach
														<li class="divider"></li>
														<li><a href="{{ URL::action('admin\LanguagesController@getAll') }}">All languages</a></li>
													</ul>
												</div>
											  </div>
											</div><br/>
					
									<div class="box box-primary box-solid">
									<div class="box-body">
									
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
									<th>Phrase</th>
									<th class="text-right">Edit</th>
								</tr>
							</thead>
							<tbody>
							@foreach($phrases as $key => $phrase)
							    @if(!is_array($phrase))
								<tr>
									<td>{{ $phrase }}</td>
									<td class="text-right">
										<button onclick="editModel('{{ $key }}', '{{ addslashes($phrase) }}');" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-icon-toggle"><i class="fa fa-pencil"></i></button>
									</td>
								</tr>
								@endif
						   @endforeach
							</tbody>
						</table>
									</div><!--end .card-body -->
								</div><!--end .card -->

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Edit language phrase</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LanguagesController@postEditPhrases', [$lang_code, $lang_file]) }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="editLangPhrase" class="control-label">Edit phrase:</label>
						</div>
						<div class="col-sm-9">
						    <input name="Langkey" type="hidden" id="editLangkey">
							<textarea name="langPhrase" id="editLangPhrase" class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitEditPhrase" value="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->			
			
@endsection

@section('javascript')
<script>
function editModel($key, $phrase){
	$('#editLangkey').val($key);
	$('#editLangPhrase').val($phrase);
}
</script>
@endsection