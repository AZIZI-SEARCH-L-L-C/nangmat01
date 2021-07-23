@extends('admin.layout')

@section('title', 'delete engine '.$name)

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/theme/libs/nestable/nestable.css') }}" />
@endsection

@section('content')

            <!-- BEGIN CONTENT-->
			<div id="content">
				<section>
					<div class="section-body">
					
									<div class="card">
									<div class="card-body">
									
									@if(Session::has('message'))
										<div class="row">
											<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
											      {{ Session::get('message') }}
				                            </div>
				                        </div>
									@endif
									
									<h3>Are you sure you want to delete this engine?</h3>
									<p> Please note that this action cannot be reversed so please pay careful attention with it.</p>.
									
									<div class="row">
									     <form action="{{ URL::action('admin\DeleteController@post', ['name' => $name]) }}" role="form" method="post">
									         <a href="{{ URL::action('admin\EnginesController@get') }}"><button type="button" class="btn">Return</button></a>
									         <button type="submit" name="submitDelete" value="submit" class="btn btn-primary">Delete</button>
									     </form>
									</div>
									
									</div><!--end .card-body -->
								</div><!--end .card -->
				      </div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->

			
@endsection