<!DOCTYPE html>
<html>
<head>
  <title>@yield('title') - Azizi search Engine Admin</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/admin/css/vendor.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/admin/css/style.css') }}">
  @yield('css')

</head>
<body>
<div class="app app-default">

<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="{{ URL::action('admin\DashboardController@get') }}"><span class="highlight">ASE</span> PRO</a>
    <button type="button" class="sidebar-toggle">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <li>
        <a target="_blank" href="https://support.azizisearch.com/">
          <div class="icon">
            <i class="fa fa-support" aria-hidden="true"></i>
          </div>
          <div class="title">Support</div>
        </a>
      </li>
    </ul>
  </div>
</aside>

<script type="text/ng-template" id="sidebar-dropdown.tpl.html">
  <div class="dropdown-background">
    <div class="bg"></div>
  </div>
  <div class="dropdown-container">
    @{{list}}
  </div>
</script>
<div class="app-container">

  <nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <a class="navbar-brand" href="#"><span class="highlight">ASE</span> Pro</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title">@yield('title')</li>
      </ul>
    </div>
  </div>
</nav>

<div class="row">
<div class="col-xs-12">
@yield('content')
</div>
</div>

<footer class="app-footer"> 
  <div class="row">
    <div class="col-xs-12">
      <div class="footer-copyright">
        Copyright © 2013 - 2016 Azizi, Inc.
      </div>
    </div>
  </div>
</footer>
</div>

</div>
<script type="text/javascript" src="{{ URL::asset('assets/admin/js/vendor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/admin/js/app.js') }}"></script>
@yield('javascript')
</body>
</html>