@extends('admin.install.layout')

@section('title', 'Setup MySQL Database')

@section('content')
<div class="box box-primary box-solid">
<div class="box-body">
<div class="step">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li role="step">
            <a href="{{ action('admin\InstallerController@get') }}">
                <div class="icon fa fa-check"></div>
                <div class="heading">
                    <div class="title">Requirements</div>
                    <div class="description">check requirements</div>
                </div>
            </a>
        </li>
        <li role="step">
            <a href="{{ action('admin\InstallerController@license') }}">
                <div class="icon fa fa-database"></div>
                <div class="heading">
                    <div class="title">License</div>
                    <div class="description">Enter app license</div>
                </div>
            </a>
        </li>
        <li role="step" class="active">
            <a href="{{ action('admin\InstallerController@database') }}">
                <div class="icon fa fa-database"></div>
                <div class="heading">
                    <div class="title">Database</div>
                    <div class="description">Setup MySQL Database</div>
                </div>
            </a>
        </li>
        <li role="step">
            <a>
                <div class="icon fa fa-cog"></div>
                <div class="heading">
                    <div class="title">Setup engine</div>
                    <div class="description">Setup general settings</div>
                </div>
            </a>
        </li>
        <li role="step">
            <a>
                <div class="icon fa fa-thumbs-o-up"></div>
                <div class="heading">
                    <div class="title">Complete</div>
                    <div class="description">complete installation process</div>
                </div>
            </a>
        </li>
    </ul>
</div>
</div>
</div>
	
<div class="box box-primary box-solid">
    <div class="box-header">
	    <header>MySQL Database informations</header>
	</div>
    <div class="box-body">
	    @if(Session::has('message'))
		    <div class="row">
				<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
					{{ Session::get('message') }}
				</div>
			</div>
		@endif
	    <form action="{{ action('admin\InstallerController@postDatabase') }}" method="post">
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Database Host</label>
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="dbHost" class="form-control" placeholder="Enter DB host">
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Database Name</label>
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="dbName" class="form-control" placeholder="Enter DB Name">
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Database Username</label>
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="dbUsername" class="form-control" placeholder="Enter DB Username">
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Database Password</label>
		        </div>
		        <div class="col-md-4">
			        <input type="password" name="dbPassword" class="form-control" placeholder="Enter DB Password">
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Database Prefix</label>(optinal)
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="dbPrefix" class="form-control" value="ase_">
		        </div>
		    </div>
            <div class="row">
		        <div class="col-md-12 text-right">
			        <input type="submit" value="Next" name="SubmitDatabase" class="btn btn-primary">
		        </div>
		    </div>
		</form>
    </div>
</div>
@endsection