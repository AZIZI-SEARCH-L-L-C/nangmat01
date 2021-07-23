@extends('admin.layout')

@section('title', 'Search engine optimizer')
@section('Aoptimizer', 'active')

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Search engine optimizer
	<small>Better performance</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Optimizer</li>
  </ol>
</section>
@endsection

@section('content')
				<div style="display:none;" id="alertNotClose">
					<div class="alert alert-warning" role="alert">
						the optimization process is started. Don't close or reaload the page during the process.
					</div>
				</div>
			
				<section>
					<div class="section-body">
					
									<div class="box">
									<div class="box-body">
										@if(Session::has('message'))
											<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
												  {{ Session::get('message') }}
											</div>
										@endif
										
										<h3>Make the search engine faster</h3>
										<p>The optimizer will do many tasks to optimize your search enigne & make it more faster. this process may take long time please don't close or refresh the page until it completed, if the page show an error (don't worry) just retry the process it will continue where it left.</p>
										
										 <form action="{{ URL::action('admin\DashboardController@optimizer') }}" role="form" method="post">
											 <a href="{{ URL::action('admin\DashboardController@get') }}"><button type="button" class="btn">Return</button></a>
											 <button type="submit" name="submitOptimizer" id="submitOptimizer" value="submit" class="btn btn-primary">Optimize</button>
										 </form>
									
									</div><!--end .card-body -->
									<div class="overlay" style="display:none">
										<i class="fa fa-refresh fa-spin"></i>
									</div>
								</div><!--end .card -->
				      </div><!--end .section-body -->
				</section>

			
@endsection

@section('javascript')
<script>
$("#submitOptimizer").click(function(){
	$( ".overlay" ).show();
	$( "#alertNotClose" ).show();
});
</script>
@endsection