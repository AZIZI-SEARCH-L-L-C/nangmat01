<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Azizi search engine - Dashboard</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/admin/css/vendor.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/admin/css/style.css') }}">
		<!-- END STYLESHEETS -->
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="assets/admin/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="assets/admin/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed">

<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								<a href="{{ URL::action('admin\DashboardController@get') }}">
									<span class="text-lg text-bold text-primary"><i class="fa fa-setting"></i> AZIZI SEARCH ENGINE</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</header>
		<!-- END HEADER-->
			
            <!-- BEGIN CONTENT-->
			<div id="content">
				<section>
					<div class="section-body">
					
									
									@if(Session::has('message'))
										<div class="row">
											<div class="alert @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
											      {{ Session::get('message') }}
				                            </div>
				                        </div>
									@endif
									
							
							<!-- BEGIN VALIDATION FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form action="{{ URL::action('admin\InstallerController@post') }}" method="post" class="form floating-label form-validation" role="form" novalidate="novalidate">
												<div class="form-wizard-nav">
													<div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
													<ul class="nav nav-justified">
														<li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">Database</span></a></li>
														<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">Admin</span></a></li>
														<li><a href="#step3" onclick="SetConfirm();" data-toggle="tab"><span class="step">3</span> <span class="title">CONFIRM</span></a></li>
													</ul>
												</div><!--end .form-wizard-nav -->
												<div class="tab-content clearfix">
													<div class="tab-pane active" id="step1">
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<input type="text" name="dbHost" id="dbHost" class="form-control" required>
																	<label for="dbHost" class="control-label">Database host</label>
																</div>
															</div>
															<div class="col-sm-6">
																<div class="form-group">
																	<input type="text" name="dbName" id="dbName" class="form-control" required>
																	<label for="dbName" class="control-label">Database name</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<input type="text" name="dbUsername" id="dbUsername" class="form-control" required>
																	<label for="dbUsername" class="control-label">Database username</label>
																</div>
															</div>
															<div class="col-sm-6">
																<div class="form-group">
																	<input type="password" name="dbPassword" id="dbPassword" class="form-control" required>
																	<label for="dbPassword" class="control-label">Database password</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-12">
																<div class="form-group">
																	<input type="text" name="dbPrefix" id="dbPrefix" class="form-control">
																	<label for="dbPrefix" class="control-label">Database prefix (optional)</label>
																</div>
															</div>
														</div>
													</div><!--end #step1 -->
													<div class="tab-pane" id="step2">
														<br/><br/>
														<div class="form-group">
															<input type="text" name="adminUsername" id="adminUsername" class="form-control" required>
															<label for="adminUsername" class="control-label">Admin username</label>
														</div>
														<div class="form-group">
															<input type="password" name="adminPassword" id="adminPassword" class="form-control" data-rule-rangelength="[6, 30]" required>
															<label for="adminPassword" class="control-label">Admin password</label>
															<p class="help-block">Between 6 and 30 </p>
														</div>
													</div><!--end #step2 -->
													<div class="tab-pane" id="step3">
														<br/><br/>
														<div class="form-group text-center">
														    <h3>You are ready to start installing Azizi search engine.</h3>
															<p>please check information bollow and if all is correct click on start button.</p><hr/>
															<div class="row">
															<div class="col-sm-6">
															<div class="row">
															    <div class="col-sm-6">
															    <p><b>Database host: </b></p>
															    </div>
															    <div class="col-sm-6">
															    <p id="dbHostShow"></p>
															    </div>
															</div>
															<div class="row">
															    <div class="col-sm-6">
															    <p><b>Database name: </b></p>
															    </div>
															    <div class="col-sm-6">
															    <p id="dbNameShow"></p>
															    </div>
															</div>
															<div class="row">
															    <div class="col-sm-6">
															    <p><b>Database username: </b></p>
															    </div>
															    <div class="col-sm-6">
															    <p id="dbUsernameShow"></p>
															    </div>
															</div>
															<div class="row">
															    <div class="col-sm-6">
															    <p><b>Database password: </b></p>
															    </div>
															    <div class="col-sm-6">
															    <p id="dbPasswordShow"></p>
															    </div>
															</div>
															</div>
															<div class="col-sm-6">
															<div class="row">
															    <div class="col-sm-6">
															    <p><b>Admin username: </b></p>
															    </div>
															    <div class="col-sm-6">
															    <p id="AdminUsernameShow"></p>
															    </div>
															</div>
															<div class="row">
															    <div class="col-sm-6">
															    <p><b>Admin password: </b></p>
															    </div>
															    <div class="col-sm-6">
															    <p id="AdminPasswordShow"></p>
															    </div>
															</div>
															</div>
															</div>
															<button type="submit" name="submitInstall" value="submit" class="btn btn-primary">Start Installer!</button>
														</div>
													</div><!--end #step3 -->
												</div><!--end .tab-content -->
												<ul class="pager wizard">
													<li class="previous"><a onclick="SetConfirm();" class="btn-raised" href="javascript:void(0);">Previous</a></li>
													<li class="next"><a onclick="SetConfirm();" class="btn-raised" href="javascript:void(0);">Next</a></li>
												</ul>
											</form>
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
								</div><!--end .card -->
								<em class="text-caption">Azizi search engine installer wizard.</em>
							</div><!--end .col -->
						</div><!--end .row -->
						<!-- END VALIDATION FORM WIZARD -->

							
							
				      </div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->			

		<script>
		    function SetConfirm(){
				var dbHost = $("#dbHost").val();
				$("#dbHostShow").html(dbHost);
				var dbName = $("#dbName").val();
				$("#dbNameShow").html(dbName);
				var dbUsername = $("#dbUsername").val();
				$("#dbUsernameShow").html(dbUsername);
				var dbPassword = $("#dbPassword").val();
				$("#dbPasswordShow").html(dbPassword);
				var adminUsername = $("#adminUsername").val();
				$("#AdminUsernameShow").html(adminUsername);
				var AdminPassword = $("#adminPassword").val();
				$("#AdminPasswordShow").html(AdminPassword);
			}
		</script>
			
		<!-- BEGIN JAVASCRIPT -->
		<script type="text/javascript" src="{{ URL::asset('assets/admin/js/vendor.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('assets/admin/js/app.js') }}"></script>
		<!-- END JAVASCRIPT -->
	</body>
</html>
