<?

function send_remote_syslog($message, $component = "", $program = "") {
  $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
  foreach(explode("\n", $message) as $line) {
    $syslog_message = "<22>" . date('M d H:i:s ') . $program . ' function=' . $component . ' ' . $line;
    socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, SYSLOG_HOSTNAME, SYSLOG_PORT);
  }
  socket_close($sock);
}
 
?>
