<?php

// Allow AJAX communications with external links 
header('Access-Control-Allow-Origin: *');

// Keep managing sessions 
session_start();

if (!isset($_GET['key'])){
	if (!isset($_SESSION['login'])){
		header( 'Location:' . CPANEL_LOGIN_PAGE);
		exit();
	}  
} else {
	if ($_GET['key']!==$_execute_remote_key) {
		header( 'Location:' . CPANEL_LOGIN_PAGE);
		exit();
	}
}

function logout() {
	session_destroy();
	header( 'Location:' . CPANEL_LOGIN_PAGE);
}

?>