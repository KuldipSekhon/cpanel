<?php
//load config file
include 'config.incl.php';

//load syslog lib
include 'syslog.incl.php';

//load config file
include 'loginverify.incl.php';

// default response
header('Content-Type: application/json');

if (isset($_GET['server']) && isset($_GET['command'])) {
	$url = $_execute_url_monitoring03_helper['url'] . "server=" . $_GET['server'] . "&command=" . $_GET['command'];
	send_remote_syslog("UserName=" . $_SESSION['username'] . " Server=" . $_GET['server'] . " Executed='" . $_GET['command'] . "'" . " RemoteURL=$url",'execute', $_SERVER['PHP_SELF']);
	echo file_get_contents($url, true);
}

?>