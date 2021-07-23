@extends('admin.install.layout')

@section('title', 'General Settings')

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
        <li role="step">
            <a href="{{ action('admin\InstallerController@database') }}">
                <div class="icon fa fa-database"></div>
                <div class="heading">
                    <div class="title">Database</div>
                    <div class="description">Setup MySQL Database</div>
                </div>
            </a>
        </li>
        <li role="step" class="active">
            <a href="{{ action('admin\InstallerController@settings') }}">
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
	
<form action="{{ action('admin\InstallerController@postSettings') }}" method="post">
<div class="box box-primary box-solid">
    <div class="box-header">
	    <header>Search engine informations</header>
	</div>
    <div class="box-body">
	    @if(Session::has('message'))
		    <div class="row">
				<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
					{{ Session::get('message') }}
				</div>
			</div>
		@endif
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Search engine Name</label>
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="siteName" class="form-control" placeholder="Enter your site name">
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Search engine Description</label>
		        </div>
		        <div class="col-md-4">
			        <textarea name="siteDescription" rows="3" class="form-control" placeholder="Enter your site description"></textarea>
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Search engine URL</label>
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="siteURL" class="form-control" value="{{ url('/') }}">
		        </div>
		    </div>
    </div>
</div>
	
<div class="box box-primary box-solid">
    <div class="box-header">
	    <header>Admin account</header>
	</div>
    <div class="box-body">
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Admin Username</label>
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="adminUsername" class="form-control" placeholder="Enter your admin username">
		        </div>
		    </div>
            <div class="row form-group">
		        <div class="col-md-3">
			        <label>Admin password</label>
		        </div>
		        <div class="col-md-4">
			        <input type="password" name="adminPassword" class="form-control" placeholder="Enter your admin password">
		        </div>
		    </div>
            <div class="row">
		        <div class="col-md-12 text-right">
			        <input type="submit" value="Next" name="SubmitSettings" class="btn btn-primary">
		        </div>
		    </div>
    </div>
</div>
</form>
@endsection