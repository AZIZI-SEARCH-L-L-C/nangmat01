@extends('admin.layout')

@section('title', 'General Settings')
@section('Adashboard', 'active')

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Dashboard
	<small>breif statistics</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Dashboard</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> Queries per Day</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Queries per Day -->
			  <div class="row">
				{{--<div class="col-md-9 col-sm-8" style="padding-right:0;">--}}
				<div class="col-md-12" style="padding-right:0;">
				<div class="chart" id="topQueries-chart" style="position: relative; height: 300px;"></div>
				</div>
				{{--<div class="col-md-3 col-sm-4" style="padding-left:0;">--}}
                  {{--<div class="pad box-pane-right bg-blue" style="min-height: 280px">--}}
                    {{--<div class="description-block margin-bottom">--}}
                      {{--<!--div class="sparkbar pad" data-color="#fff">90,70</div-->--}}
                      {{--<h5 class="description-header">8390</h5>--}}
                      {{--<span class="description-text">Visits</span>--}}
                    {{--</div>--}}
                    {{--<!-- /.description-block -->--}}
                    {{--<div class="description-block margin-bottom">--}}
                      {{--<!--div class="sparkbar pad" data-color="#fff">90,50,90,70,61,83,63</div-->--}}
                      {{--<h5 class="description-header">30%</h5>--}}
                      {{--<span class="description-text">Referrals</span>--}}
                    {{--</div>--}}
                    {{--<!-- /.description-block -->--}}
                    {{--<div class="description-block">--}}
                      {{--<!--div class="sparkbar pad" data-color="#fff">90,50,90,70,61,83,63</div-->--}}
                      {{--<h5 class="description-header">70%</h5>--}}
                      {{--<span class="description-text">Organic</span>--}}
                    {{--</div>--}}
                    {{--<!-- /.description-block -->--}}
                  {{--</div>--}}
                {{--</div>--}}
			  </div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
  </div>
</div>

<div class="row">
	<div class="col-lg-6 col-xs-12">
  <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Visitors</a></li>
              <li><a href="#tab_2" data-toggle="tab">Browsers</a></li>
              <li><a href="#tab_3" data-toggle="tab">Devices</a></li>
              <li><a href="#tab_4" data-toggle="tab">Os</a></li>
              <!--li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li-->
            </ul>
            <div class="tab-content no-padding">
              <div class="tab-pane active" id="tab_1">
				<div id="world-map" style="height: 250px; width: 100%;"></div>
					<div class="box-footer no-padding">
					  <ul class="nav nav-pills nav-stacked">
						<li><a href="#"><span id="country-selected">Country</span>
						  <span id="country-total-selected" class="pull-right">#Visitors</span></a></li>
					  </ul>
					</div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <div class="row">
					<div class="col-md-8">
						<div class="chart-responsive">
						  <div class="chart" id="topBrowsers-chart" style="position: relative; height: 300px;"></div>
						</div>
					</div>
					<div class="col-md-4">
					  <ul class="chart-legend clearfix" id="browsersLabels"></ul>
					</div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
				<div class="row">
					<div class="col-md-8">
						<div class="chart-responsive">
						  <div class="chart" id="devices-chart" style="position: relative; height: 300px;"></div>
						</div>
					</div>
					<div class="col-md-4">
					  <ul class="chart-legend clearfix" id="devicesLabels"></ul>
					</div>
				</div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
				<div class="row">
					<div class="col-md-8">
						<div class="chart-responsive">
						  <div class="chart" id="oss-chart" style="position: relative; height: 300px;"></div>
						</div>
					</div>
					<div class="col-md-4">
					  <ul class="chart-legend clearfix" id="ossLabels"></ul>
					</div>
				</div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
	</div>
	<div class="col-lg-6 col-xs-12">
		<div class="box box-primary box-solid">
            <div class="box-header">
				<h3 class="box-title">Top queries</h3>
			</div>
			<div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th>Query</th>
                  <th class="text-right">Total hits</th>
                </tr>
                <tbody id="topQueries"></tbody>
              </table>
            </div>
        </div>
	</div>
</div>
@endsection

@section('javascript')
<script>
$( document ).ready(function() {

	// top queries
    $.getJSON( "{{ action('admin\DashboardController@topQueries') }}", {}, function( data ) {
		console.log(data);
		$.each(data, function( index, value ) {
			$('#topQueries').append('<tr><td>'+ value.query +'</td><td class="text-right">'+ value.total +'</td></tr>') 
		});
	});
	
	// inject js for top queries
	var script = document.createElement('script');
	script.setAttribute('src', '{{ action("admin\DashboardController@QueriesPerday") }}');
	script.setAttribute('type', 'text/javascript');
	document.getElementsByTagName('head')[0].appendChild(script);

	// inject js for countries
	var script = document.createElement('script');
	script.setAttribute('src', '{{ action("admin\DashboardController@countries") }}');
	script.setAttribute('type', 'text/javascript');
	document.getElementsByTagName('head')[0].appendChild(script);
	
	// inject js for devices
	var script = document.createElement('script');
	script.setAttribute('src', '{{ action("admin\DashboardController@devices") }}');
	script.setAttribute('type', 'text/javascript');
	document.getElementsByTagName('head')[0].appendChild(script);

	// inject js for oss
	var script = document.createElement('script');
	script.setAttribute('src', '{{ action("admin\DashboardController@oss") }}');
	script.setAttribute('type', 'text/javascript');
	document.getElementsByTagName('head')[0].appendChild(script);

	// inject js for browsers
	var script = document.createElement('script');
	script.setAttribute('src', '{{ action("admin\DashboardController@browsers") }}');
	script.setAttribute('type', 'text/javascript');
	document.getElementsByTagName('head')[0].appendChild(script);
	
	// Fix for charts under tabs
	// $('.nav-tabs li a').click(function () {
		// donut.redraw();
	// });

// Fix for charts under tabs
  $('.nav-tabs li a').on('shown.bs.tab', function () {
    browsers.redraw();
    devices.redraw();
    oss.redraw();
  });
	
	// -----------------
  // - SPARKLINE BAR -
  // -----------------
  $('.sparkbar').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type    : 'bar',
      height  : $this.data('height') ? $this.data('height') : '30',
      barColor: $this.data('color')
    });
  });
	
  // Make the dashboard widgets sortable Using jquery UI
  // $('.connectedSortable').sortable({
    // placeholder         : 'sort-highlight',
    // connectWith         : '.connectedSortable',
    // handle              : '.box-header, .nav-tabs',
    // forcePlaceholderSize: true,
    // zIndex              : 999999
  // });
  // $('.connectedSortable .box-header').css('cursor', 'move');
	
});
</script>
@endsection