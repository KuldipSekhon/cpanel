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

// default response
header('Content-Type: application/json');
try {

	if ($_GET["server"]) {
		// Search param
		$enquiry = $_GET["server"];
		
		//current time
		$time 		= time();
		
		// Connect to Zabbix API
		$api = new ZabbixApi(ZABBIX_API_URL, ZABBIX_USER, ZABBIX_PASS);
		$host = $api->hostget(array('output' => 'extend',  'search' => array('name' => $enquiry)));
		
		// Found results 
		if (count($host) > 0) {
				
					if (isset($_GET['function']) && $_GET["function"]=='list') {
						$item = $api->itemget(array('output' => 'extend', 'hostids' => $host[0]->hostid, 'search' => array('key_' => 'system.uname')));
						
						//switch per platform
						$item = strtolower($item[0]->lastvalue);
			
						if (strpos($item,"windows")!==false) {
								echo json_encode($_allowed_commands_windows);
						} else if (strpos($item,"linux")!==false) {
								echo json_encode($_allowed_commands_linux);
						} else {
								$output = [
									"display_name" => "No commands available",
									"timestamp" => "$time",
								];
								echo json_encode($output);								
						}
						
					} else if (isset($_GET['function']) && $_GET["function"]=='execute') {
						echo json_encode($_execute_url_monitoring01);
					} else {
						// return found results
						echo json_encode($host);
					}
		} else {
			// server parameter wasn't provided
			$output = [
				"return_msg" => "Host not found",
				"timestamp" => "$time",
			];
			echo json_encode($output);		
		}
		
	} else {
		// function is not defined
		$output = [
			"return_msg" => "No requested function recognised",
			"timestamp" => "$time",
		];
		echo json_encode($output);		
	}
	

} catch(Exception $e) {
	// felt inside of main try
    echo $e->getMessage();

}
?> 

			
