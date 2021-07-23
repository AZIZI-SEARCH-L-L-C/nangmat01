@extends('admin.install.layout')

@section('title', 'Finalize Installation')

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
        <li role="step">
            <a href="{{ action('admin\InstallerController@settings') }}">
                <div class="icon fa fa-cog"></div>
                <div class="heading">
                    <div class="title">Setup engine</div>
                    <div class="description">Setup general settings</div>
                </div>
            </a>
        </li>
        <li role="step" class="active">
            <a href="{{ action('admin\InstallerController@complete') }}">
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
	    <header>Finalize Installation process</header>
	</div>
    <div class="box-body">
	    <form action="{{ action('admin\InstallerController@postComplete') }}" method="post">
            <div class="row form-group">
		        <div class="col-md-12">
			        <p>The installation process is almost done! after this step, you will be redirected to admin panel login.</p>
		        </div>
		    </div>
            <div class="row">
		        <div class="col-md-12 text-right">
			        <input type="submit" value="Finish" name="SubmitComplete" class="btn btn-primary">
		        </div>
		    </div>
		</form>
    </div>
</div>
@endsection