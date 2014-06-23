<?php
//load config file
include 'config.incl.php';

//load syslog lib
include 'syslog.incl.php';

//load config file
include 'loginverify.incl.php';

// load ZabbixApi
require 'incl/ZabbixApiAbstract.class.php';
require 'incl/ZabbixApi.class.php';


if (isset($_GET['function']) && $_GET["function"]=='logout') {
	logout();
}

?>

<html ng-app="myApp">
  <head> 
    <script src="./js/jquery.min.js"></script>
	<script src="./js/angular.min.js"></script>
	<script src="./js/angular-sanitize.min.js"></script>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="./css/dashboard.css">
	<script src="./js/engine.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	
    <title>OOVOO CPANEL (SOC)</title>
	<style> 
		.bs-callout-warning { 
			background-color: #fcf8f2;
			border-color: #f0ad4e;
		}
		.bs-callout {
			margin: 10px 20px;
			padding: 20px;
			border-left: 3px solid #eee;
		}
		<!-- #fe9024 -->
	</style>
  </head>
  <body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">SOC CONTROL PORTAL</a>
				
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<!-- <li><a href="#">Dashboard</a></li>
					<li><a href="#">Settings</a></li> -->
					<li><a href=<?=$_SERVER['PHP_SELF']?>?function=logout><? echo $_SESSION['username']; ?> | Logout</a></li>
				</ul>
				
				<!-- <form class="navbar-form navbar-right">
					<input type="text" class="form-control" placeholder="Search...">
				</form> -->
			</div>
		</div>
	</div>
	<div class="container-fluid">
      <div class="row" ng-controller="TodoCtrl">
        <div class="col-sm-3 col-md-2 sidebar"> 
			<ul class="nav nav-sidebar">
				<li><input type="text" class="form-control" ng-change="getServerList()" placeholder="Search" ng-model="query" style="margin-left: 15px;width:90%;"></input></li>
				<hr />
				
				<!--<li ng-repeat="srv in serversList | orderBy:'host'">-->
				<li ng-repeat="srv in serversList | filter:query | orderBy:'host'">
					<a ng-click="getServerCommands(srv.name)" href="#">{{srv.name}}</a>
				</li>
				 
			</ul>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Run command on: <span style="color:#fe9024">{{ getRunningServer()}}</span></h1>
		  <div >
					
						<div class="hidden-xs">
							<div class="hidden-xs" style="max-width: 90%; margin: 0 auto 10px;">
								<span ng-repeat="cmd in getCommandsList()">
									 <a href="#" ng-click="commandSend(cmd.name)" class="btn btn-large btn-block btn-default">{{cmd.display_name}}</a>  
								</span>
							</div>
							<!-- write command response -->
							<div class="alert alert-warning" style="max-width: 90%; margin: 0 auto 10px;" ng-if="commandRtrn().output!=null">
								<span class="label label-primary">Remotely executed by (cmd):</span>
								<br><br>
								<div ng-bind-html='commandRtrn().executed | nl2br'></div>
								<br>
								<span class="label label-success">Output:</span>
								<br><br>
								<div ng-bind-html='commandRtrn().output | nl2br'></div>
								<br>
								<span class="label label-warning">Return code:</span>
								<br><br>
								<div ng-bind-html='commandRtrn().return_code'></div> 
							</div>
						</div> 

				</div> 
		</div>
		</div> 
    </div>

  		
    

  </body>
</html>
