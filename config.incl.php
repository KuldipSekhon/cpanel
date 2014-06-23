<?php
// SYSLOG SETTINGS
define("SYSLOG_HOSTNAME", '127.0.0.1');
define("SYSLOG_PORT", '512');

// MAIN SEARCH PAGE
define("ROOT_URL", "yourdomain.com");
define("CPANEL_COMMAND_SEARCH", "http://yourdomain.com/cpanel/search.php?server=");
define("CPANEL_LOGIN_PAGE", "http://yourdomain.com/cpanel/index.php");
define("CPANEL_CONTROL_PAGE", "http://yourdomain.com/cpanel/main.php");
define("ZABBIX_API_URL", 'http://yourzabbix.com/zabbix/api_jsonrpc.php');
define("ZABBIX_USER", 'zabbix-api');
define("ZABBIX_PASS", 'password');

// MANAGE EXECUTE LINKS 
$_execute_url_monitoring01 			= array ('url' => 'http://yourdomain.com/cpanel/execute.php?');

// MANAGE WHITE LIST FOR WINDOWS
$_allowed_commands_windows = array(
 	  array('display_name' => 'IIS STOP', 'name'  => "iis_stop", 'cmd' => "iisreset /stop"),
	  array('display_name' => 'IIS STATUS', 'name'  => "iis_status", 'cmd' => "iisreset /status"),
	  array('display_name' => 'IIS START', 'name'  => "iis_start", 'cmd' => "iisreset /start"),
	  array('display_name' => 'ZABBIX AGENT STATUS','name'  => "zbx_agent_status", 'cmd' => 'sc query "Zabbix Agent"'),
	  array('display_name' => 'AVS STOP','name'  => "avs_stop", 'cmd' => 'sc stop "AVServer"'),
	  array('display_name' => 'AVS STATUS','name'  => "avs_status", 'cmd' => 'sc query "AVServer"'),
	  array('display_name' => 'AVS START','name'  => "avs_start",'cmd' => 'sc start "AVServer"'),
	  //array('display_name' => 'SPLUNKD STOP','name'  => "splunk_stop", 'cmd' => 'sc stop "Splunkd"'),
	  //array('display_name' => 'SPLUNKD STATUS','name'  => "splunk_status", 'cmd' => 'sc query "Splunkd"'),
	  //array('display_name' => 'SPLUNKD START','name'  => "splunk_start",'cmd' => 'sc start "Splunkd"')
); 

// MANAGE WHITE LIST FOR LINUX
$_allowed_commands_linux = array(
	  array('display_name' => 'ZABBIX AGENT SVC STOP', 'name'  => "zbx_agent_stop", 'cmd' => 'sc stop "Zabbix Agent"'),
	  array('display_name' => 'ZABBIX AGENT SVC START', 'cmd' => 'sc start "Zabbix Agent"'),
); 


?>