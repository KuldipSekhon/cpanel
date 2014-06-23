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

$user_server   = strtolower($_GET["server"]);
$user_command  = strtolower($_GET["command"]);

if ($user_server && $user_command)  {

	// find relevant commands inside for windows platform 
	for ($i=0; $i<=count($_allowed_commands_windows); $i++) {
       if (strtolower($_allowed_commands_windows[$i]['name']) == $user_command) {
			$command = $_allowed_commands_windows[$i]['cmd'];
			break;
		}
	} 	

	// if not found inside windows platform go for linux and vise versa
	for ($i=0; $i<=count($_allowed_commands_linux); $i++) {
       if (strtolower($_allowed_commands_windows[$i]['name']) == $user_command) {
			$command = $_allowed_commands_windows[$i]['cmd'];
			break;
		}
	} 	
		
	try {

		$time 		= time();
	
		$api = new ZabbixApi(ZABBIX_API_URL, ZABBIX_USER, ZABBIX_PASS);

		$host = $api->hostgetobjects(array('output' => 'extend', 'name' => $_GET["server"]));	
		
		if (count($host) && count($command) == 1 ) {
			
			$int = $api->hostinterfaceget(array('output' => 'extend', 'hostids' => $host[0]->hostid, 'main' => '1'));

			$zabbix_agent_ip = $int[0]->ip;
			
			if (!isset($_SESSION['login'])){ 
				send_remote_syslog("ClientIP=" . $_SERVER['REMOTE_ADDR'] . " UserName=!!Token!! Server=" . $user_server . " ZabbixAgentIP=" . $zabbix_agent_ip . " Executed='" . $command . "'",'execute', $_SERVER['PHP_SELF']);
			} else {
				send_remote_syslog("ClientIP=" . $_SERVER['REMOTE_ADDR'] . " UserName=" . $_SESSION['username'] . " Server=" . $user_server . " ZabbixAgentIP=" . $zabbix_agent_ip . " Executed='" . $command . "'",'execute', $_SERVER['PHP_SELF']);
			}
			
			// Prepare Exec string
			$cmd = dirname ( __FILE__ ) . "/exec/zabbix_get -s $zabbix_agent_ip -k system.run['$command']";

			// Execute 
			exec($cmd, $retbuff, $retval);

			// Human readable vars 
			$retbuff = implode(",", $retbuff);
			
			$output = [
				"executed" => "$cmd",
				"output" => "$retbuff",
				"return_code" => "$retval",
				"timestamp" => "$time",
			];
			echo json_encode($output);		
			
		} else {
			$output = [
				"return_code" => "-20000",
				"timestamp" => "$time",
			];
			echo json_encode($output);		
		}
	
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}

?>