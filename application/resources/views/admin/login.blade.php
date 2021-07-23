<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Azizi search Engine Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/css/select2.min.css') }}" >

    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/admin/plugins/iCheck/all.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/AdminLTE.min.css') }}">

    @yield('css')
    <style>
        .flex{
            display: flex;
        }
        #statu{
            display: none;
        }
    </style>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>SE PRO</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>ASE</b>PRO</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="@yield('Adashboard')">
                    <a href="{{ action('admin\DashboardController@get') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="treeview @yield('Asettings')">
                    <a href="#">
                        <i class="fa fa-paperclip"></i> <span>Settings</span>
                        <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ action('admin\SettingsController@get') }}"><i class="fa fa-link"></i> General settings</a></li>
                        <li><a href="{{ action('admin\SettingsController@getSocialLogin') }}"><i class="fa fa-paperclip"></i> Social login</a></li>
                        <li><a href="{{ action('admin\SettingsController@getPaymentsGateways') }}"><i class="fa fa-paperclip"></i> Payments Gateways</a></li>
                    </ul>
                </li>
                <li class="@yield('Aoptimizer')"><a href="{{ action('admin\DashboardController@getOptimizer') }}"><i class="fa fa-bolt"></i> <span>Optimizer</span></a></li>
                <li class="@yield('Aengines')"><a href="{{ action('admin\EnginesController@get') }}"><i class="fa fa-search"></i> <span>Search Engines</span></a></li>
                {{--        <li class="treeview @yield('Aengines')">--}}
                {{--          <a href="#">--}}
                {{--            <i class="fa fa-paperclip"></i> <span>Engines</span>--}}
                {{--            <span class="pull-right-container">--}}
                {{--				<i class="fa fa-angle-left pull-right"></i>--}}
                {{--            </span>--}}
                {{--          </a>--}}
                {{--          <ul class="treeview-menu">--}}
                {{--            <li><a href="{{ action('admin\EnginesController@get') }}"><i class="fa fa-link"></i> Engines</a></li>--}}
                {{--            <li><a href="{{ action('admin\SitesController@getComments') }}"><i class="fa fa-paperclip"></i> Comments</a></li>--}}
                {{--            <li><a href="{{ action('admin\SitesController@getBookmarks') }}"><i class="fa fa-paperclip"></i> Bookmarks</a></li>--}}
                {{--          </ul>--}}
                {{--        </li>--}}
                <li class="@yield('Alanguages')"><a href="{{ action('admin\LanguagesController@getAll') }}"><i class="fa fa-language"></i> <span>Languages</span></a></li>
                <li class="@yield('Alogos')"><a href="{{ action('admin\LogosController@getAll') }}"><i class="fa fa-image"></i> <span>Logos</span></a></li>
            <!--li><a href="{{ action('admin\UserInfoController@get') }}"><i class="fa fa-circle-o"></i> Change login info</a></li-->
                <li class="treeview @yield('AapiSettings')">
                    <a href="#">
                        <i class="fa fa-database"></i> <span>APIs configuration</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--            <li><a href="{{ action('admin\ApiController@getSettings') }}"><i class="fa fa-circle-o"></i> <span> Settings</span></a></li>--}}
                        @foreach(config('app.apiProviders') as $api => $apisengines)
                            <li><a href="{{ action('admin\ApiController@get', last(explode('\\', $api))) }}"><i class="fa fa-circle-o"></i> <span>{{ last(explode('\\', $api)) }}</span></a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="treeview @yield('Aplugins')">
                    <a href="#">
                        <i class="fa fa-database"></i> <span>Plugins</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ action('admin\PluginsController@installed') }}"><i class="fa fa-circle-o"></i> <span> Installed Plugins</span></a></li>
                        <li><a href="{{ action('admin\PluginsController@installed', ['new' => 1]) }}"><i class="fa fa-circle-o"></i> <span> Upload Plugins</span></a></li>
                        <li><a href="{{ action('admin\TemplatesController@get') }}"><i class="fa fa-circle-o"></i> <span> Installed Templates</span></a></li>
                        <li><a href="{{ action('admin\TemplatesController@get', ['new' => 1]) }}"><i class="fa fa-circle-o"></i> <span> Upload Template</span></a></li>
                        <li><a href="https://azizisearch.com/plugins"><i class="fa fa-circle-o"></i> <span> Plugins store</span></a></li>
                    </ul>
                </li>
                <li class="treeview @yield('Amonetize')">
                    <a href="#">
                        <i class="fa fa-dollar"></i> <span>Monetizing</span>
                        <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ action('admin\AdvertisementsController@getCompains') }}"><i class="fa fa-circle-o"></i> Compains</a></li>
                        <li><a href="{{ action('admin\AdvertisementsController@getPrimaryKeywords') }}"><i class="fa fa-circle-o"></i> Premium keywords</a></li>
                        <li><a href="{{ action('admin\AdvertisementsController@getFieldsfactors') }}"><i class="fa fa-circle-o"></i> Fields cost factors</a></li>
                        <li><a href="{{ action('admin\AdvertisementsController@getAdsSettings') }}"><i class="fa fa-circle-o"></i> Settings</a></li>
                        <li><a href="{{ action('admin\AdvertisementsController@getAdsBlocks') }}"><i class="fa fa-circle-o"></i> Ads Blocks</a></li>
                    </ul>
                </li>
                <li class="treeview @yield('Asites')">
                    <a href="#">
                        <i class="fa fa-paperclip"></i> <span>Sites</span>
                        <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ action('admin\SitesController@getRankedSites') }}"><i class="fa fa-link"></i> Ranked sites</a></li>
                        <li><a href="{{ action('admin\SitesController@getWaitingSites') }}"><i class="fa fa-paperclip"></i> Waiting sites</a></li>
                    </ul>
                </li>
                <li class="treeview @yield('Ausers')">
                    <a href="#">
                        <i class="fa fa-paperclip"></i> <span>Users</span>
                        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ action('admin\UserInfoController@get') }}"><i class="fa fa-link"></i> All users</a></li>
                        {{--              <li><a href="{{ action('admin\SitesController@getComments') }}"><i class="fa fa-paperclip"></i> Comments</a></li>--}}
                        {{--              <li><a href="{{ action('admin\SitesController@getBookmarks') }}"><i class="fa fa-paperclip"></i> Bookmarks</a></li>--}}
                    </ul>
                </li>
                <li class="@yield('AsystemLog')"><a href="{{ action('admin\LogController@get') }}"><i class="fa fa-exclamation-circle"></i> <span>System log</span></a></li>
                <li  class="@yield('AblockTerr')"><a href="{{ action('admin\DashboardController@getBlockTerr') }}"><i class="fa fa-ban"></i> <span>Block territories</span></a></li>
                <li  class="@yield('Aqueries')"><a href="{{ action('admin\DashboardController@getQueries') }}"><i class="fa fa-table"></i> <span>Queries</span></a></li>
                <!--li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
                <li class="header">LABELS</li>
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li-->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @yield('header')

    <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <style>
        #saveChangesContainer{
            display:none;
            background: #fff;
            padding: 15px;
            color: #444;
            border-top: 1px solid #d2d6de;
        }
        @media (min-width: 767px){
            #saveChangesContainer {
                margin-left: 230px;
            }
        }
    </style>
    <div id="saveChangesContainer">
        <div class="pull-right">
            <button id="save" class="btn btn-primary">Save</button>
            <button id="cancel" class="btn">Cancel</button>
        </div>
        <b style="line-height: 34px;">There are unsaved changes. Click on save button to save.</b>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ config('app.version') }}
        </div>
        <strong>Copyright ©</strong> 2013 - {{ date('Y') }} AZIZI SEARCH LTD.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ URL::asset('assets/admin/components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ URL::asset('assets/admin/components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('assets/admin/components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ URL::asset('assets/admin/components/raphael/raphael.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/components/morris.js/morris.js') }}"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('assets/admin/components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ URL::asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ URL::asset('assets/admin/components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ URL::asset('assets/admin/components/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ URL::asset('assets/admin/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL::asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ URL::asset('assets/admin/components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('assets/admin/components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ URL::asset('assets/admin/components/chart.js/Chart.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
<!-- added -->
<script src="{{ URL::asset('assets/admin/plugins/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
</body>
</html>
