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
	  
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="{{ route('home') }}" target="_blank"><i class="fa fa-external-link"></i></a>
          </li>
		  @if(!$notifications->isEmpty())
			  <li class="dropdown notifications-menu">
				<a href="#" id="makeItRead" class="dropdown-toggle" data-toggle="dropdown">
				  <i class="fa fa-bell-o"></i>
				  <span class="label label-danger">{{ $notifications->count() }}</span>
				</a>
				<ul class="dropdown-menu">
				  <li class="header">You have {{ $notifications->count() }} notifications</li>
				  <li>
					<!-- inner menu: contains the actual data -->
					<ul class="menu">
						@foreach($notifications as $notification)
							<li><a href='{{ action("admin\LogController@get", ["day" => date("Y-m-d", strtotime($notification["created_at"]))]) }}'><i class="fa fa-times-circle @if(in_array($notification['type'], ['emergency','alert','critical','error'])) text-red @elseif($notification['type'] == 'info' || $notification['type'] == 'debug') text-aqua @endif"></i> {{ $notification['message'] }}</a></li>
						@endforeach
					</ul>
				  </li>
				  <li class="footer"><a href="{{ action("admin\LogController@get") }}">View all</a></li>
				</ul>
			  </li>
		  @endif
          <!--li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-align-left"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ getUserThumbnail() }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ $user->username }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ getUserThumbnail() }}" class="img-circle" alt="User Image">

                <p>
                  {{ $user->username }} - Admin
                  {{--<small>Member since Nov. 2012</small>--}}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('profile.edit.info') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ getUserThumbnail() }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ $user->username }}</p>
          <a href="{{ route('profile.edit.info') }}" target="_blank"><i class="fa fa-arrow-right text-success"></i> Admin</a>
        </div>
      </div>
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
        <li  class="@yield('AadminLog')"><a href="{{ action('admin\DashboardController@getAdminLog') }}"><i class="fa fa-table"></i> <span>Admin Log</span></a></li>
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
<script>
var Selector = {
    wrapper       : '.wrapper',
    contentWrapper: '.content-wrapper',
    layoutBoxed   : '.layout-boxed',
    mainFooter    : '.main-footer',
    save	      : '#saveChangesContainer',
    mainHeader    : '.main-header',
    sidebar       : '.sidebar',
    controlSidebar: '.control-sidebar',
    fixed         : '.fixed',
    sidebarMenu   : '.sidebar-menu',
    logo          : '.main-header .logo'
};

var ClassName = {
    fixed          : 'fixed',
    holdTransition : 'hold-transition'
};
  
$('form.save input, form.save textarea, form.save select').on('input ifChecked ifUnchecked keyup change', function() {
	$("#saveChangesContainer").show();
	fix();
});
$('#cancel').on('click', function() {
	window.location.href = "{{ url()->current() }}";
});

$('.sidebar-toggle').on('click', function() {
	var isOpen = !$('body').hasClass("sidebar-collapse");
	if(isOpen){
		$("#saveChangesContainer").css({'margin-left':'50px'});
	}else{
		$("#saveChangesContainer").css({'margin-left':'230px'});
	}
});

function fix(){
	// Remove overflow from .wrapper if layout-boxed exists
    $(Selector.layoutBoxed + ' > ' + Selector.wrapper).css('overflow', 'hidden');

    // Get window height and the wrapper height
    var saveHeight    = $(Selector.save).outerHeight() || 0;
    var footerHeight  = $(Selector.mainFooter).outerHeight() || 0;
    var neg           = $(Selector.mainHeader).outerHeight() + footerHeight + saveHeight;
    var windowHeight  = $(window).height();
    var sidebarHeight = $(Selector.sidebar).height() || 0;

    // Set the min-height of the content and sidebar based on
    // the height of the document.
    if ($('body').hasClass(ClassName.fixed)) {
      $(Selector.contentWrapper).css('min-height', windowHeight - footerHeight - saveHeight);
    } else {
      var postSetHeight;

      if (windowHeight >= sidebarHeight) {
        $(Selector.contentWrapper).css('min-height', windowHeight - neg);
        postSetHeight = windowHeight - neg;
      } else {
        $(Selector.contentWrapper).css('min-height', sidebarHeight);
        postSetHeight = sidebarHeight;
      }

      // Fix for the control sidebar height
      var $controlSidebar = $(Selector.controlSidebar);
      if (typeof $controlSidebar !== 'undefined') {
        if ($controlSidebar.height() > postSetHeight)
          $(Selector.contentWrapper).css('min-height', $controlSidebar.height());
      }
    }
}
function sendMessage($statu, $message){
	$('#statu .alert').attr('class', 'alert alert-dismissible');
	$('#statu').hide();
	$('#statu').show("slow");
	$('#statu .alert span').html($message);
	$('#statu .alert').addClass($statu, 1000, "easeOutBounce");
}

//iCheck for checkbox and radio inputs
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
});

$(document).ready(function() {
	$('.select2').select2();
	$('[data-toggle="tooltip"]').tooltip();
});

$('#makeItRead').click(function(){
    $.ajax({
        url: "{{ route('admin.api.ajax.makeNotficationsRead') }}",
        type: "post",
    }).done(function(d) {
        $('#makeItRead .label.label-danger').hide('slow');
    });
});
</script>
@yield('javascript')
</body>
</html>
