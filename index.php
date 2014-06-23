<?php
 
//load config file
include 'config.incl.php';

//load syslog lib
include 'syslog.incl.php';

// load ZabbixApi
require 'incl/ZabbixApiAbstract.class.php';
require 'incl/ZabbixApi.class.php';

if ($_SERVER['HTTP_HOST']!=ROOT_URL) {
		header( 'Location:' . CPANEL_LOGIN_PAGE);
}

if (isset($_POST['username']) &&  isset($_POST['password'])) {

	try {
		// create new ZabbixApi instance
		$api = new ZabbixApi;

		// set API url
		$api = new ZabbixApi(ZABBIX_API_URL, ZABBIX_USER, ZABBIX_PASS);

		// try to login into Zabbix API
		$user = $api->userLogin(array('user' => $_POST['username'], 'password' => $_POST['password']));

		if (count($user) == 1) {
			session_start();
			$_SESSION['login'] = $user;
			$_SESSION['username'] = $_POST['username'];
			send_remote_syslog("UserName=".$_POST['username'],'login', $_SERVER['PHP_SELF']);
			header( 'Location:' . CPANEL_CONTROL_PAGE);
			exit();
		} else {
			session_start();
			$_SESSION['login'] = "0";
		}
		
	} catch(Exception $e) {

		// Exception in ZabbixApi catched
		echo $e->getMessage();

	}
}


?>
<!Doctype html>
<html>
	<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./js/jquery.min.js"></script>
	<script src="./js/angular.min.js"></script>
	<script src="./js/angular-sanitize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="./css/signin.css">
	<script src="./js/engine.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="container">
		<h2 style="color:#fe9024;text-align:center;">OOVOO (SOC) CONTROL PANEL</h2>
		<form class="form-signin" role="form" id='login' action='<?=$_SERVER['PHP_SELF']?>' method='post' accept-charset='UTF-8'>
			<!--<h2 class="form-signin-heading">Please sign in</h2>-->
			<input type='hidden' name='submitted' id='submitted' value='1'/>
			<input type="text" value="" name='username' id='username' class="form-control" placeholder="Login" required autofocus  maxlength="50" />
			<input type="password" class="form-control" placeholder="Password" required value="" name='password' id='password' maxlength="50" />
			<label class="checkbox">
			<!--<input type="checkbox" value="remember-me"> Remember me-->
			</label>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>
    </div>
</body>
</html>
