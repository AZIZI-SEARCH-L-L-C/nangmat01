@extends('admin.install.layout')

@section('title', 'Check requirements')

@section('content')
<div class="box box-primary box-solid">
<div class="box-body">
<div class="step">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li role="step" class="active">
            <a>
                <div class="icon fa fa-check"></div>
                <div class="heading">
                    <div class="title">Requirements</div>
                    <div class="description">check requirements</div>
                </div>
            </a>
        </li>
        <li role="step">
            <a>
                <div class="icon fa fa-database"></div>
                <div class="heading">
                    <div class="title">License</div>
                    <div class="description">Enter app license</div>
                </div>
            </a>
        </li>
        <li role="step">
            <a>
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
	    <header>Check system requirements</header>
	</div>
    <div class="box-body">
        <div class="row">
		    <div class="col-md-3">
			    PHP version
		    </div>
		    <div class="col-md-9">
			    @if(version_compare(PHP_VERSION, '5.6.4', '>='))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert">Not Ok! Please update PHP version to 5.6.4 or greater.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    MySql Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('mysql') or extension_loaded('mysqlnd'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! Mysql extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    PDO PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('pdo'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! pdo extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    OpenSSL PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('openssl'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! openssl extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    Mbstring PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('mbstring'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! mbstring extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    Tokenizer PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('tokenizer'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! tokenizer extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    File Info PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('fileinfo'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! fileinfo extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    XML PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('xml'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! xml extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    CURL PHP Extension
		    </div>
		    <div class="col-md-9">
			    @if(extension_loaded('curl'))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! curl extention is not loaded.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    Session
		    </div>
		    <div class="col-md-9">
			    @if(session_status())
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
					<div class="alert alert-danger" role="alert">Not Ok! Please enable mod_rewrite in your server.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    mod_rewrite module
		    </div>
		    <div class="col-md-9">
				@if(strpos($server, 'Apache') !== false)
					@if(function_exists('apache_get_modules'))
						@if(in_array('mod_rewrite', apache_get_modules()))
							<div class="alert alert-success" role="alert">Ok (Apache)</div>
						@else
							<div class="alert alert-danger" role="alert">Not Ok! Please enable mod_rewrite in your server.</div>
						@endif
					@else
						<div class="alert alert-success" role="alert">Ok (Apache)</div>
					@endif
				@else
					<div class="alert alert-success" role="alert">Ok (Nginx)</div>
				@endif
		    </div>
		</div>
		<hr>
        <div class="row">
		    <div class="col-md-3">
			    Storage directory permissions
		    </div>
		    <div class="col-md-9">
			    @if(is_writable(storage_path()))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert"><strong>Not Ok!</strong> Please chmod /application/storage folder to 777 (recursive).</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    Cache directory permissions
		    </div>
		    <div class="col-md-9">
			    @if(is_writable(base_path('bootstrap'.DIRECTORY_SEPARATOR.'cache')))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert"><strong>Not Ok!</strong> Please chmod /application/bootstrap/cache folder to 777 (recursive).</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    Config directory permissions
		    </div>
		    <div class="col-md-9">
			    @if(is_writable(base_path('config')))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert"><strong>Not Ok!</strong> Please chmod /application/config folder to 777 (recursive).</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    Languages directory permissions
		    </div>
		    <div class="col-md-9">
			    @if(is_writable(base_path('resources'.DIRECTORY_SEPARATOR.'lang')))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert"><strong>Not Ok!</strong> Please chmod /application/resources/lang folder to 777 (recursive).</div>
				@endif
		    </div>
		</div>
		<div class="row">
		    <div class="col-md-3">
			    Database directory permissions
		    </div>
		    <div class="col-md-9">
			    @if(is_writable(base_path('database')))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert"><strong>Not Ok!</strong> Please chmod /application/database folder to 777 (recursive).</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-3">
			    settings file
		    </div>
		    <div class="col-md-9">
			    @if(is_writable(base_path('.env')))
			        <div class="alert alert-success" role="alert">Ok</div>
				@else
			        <div class="alert alert-danger" role="alert"><strong>Not Ok!</strong> Please chmod /application/.env gile to 777.</div>
				@endif
		    </div>
		</div>
        <div class="row">
		    <div class="col-md-12 text-right">
			    @if($error)
					<a href="{{ action('admin\InstallerController@get') }}" class="btn btn-primary">Retry</a>
				@else
			        <a href="{{ action('admin\InstallerController@license') }}" class="btn btn-primary">Next</a>
				@endif
		    </div>
		</div>
    </div>
</div>
@endsection