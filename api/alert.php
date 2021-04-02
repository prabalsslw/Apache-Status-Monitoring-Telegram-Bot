<?php 
	$server_config = require_once('../config/server.php');

	require_once('../lib/functions.php');
	require_once('../lib/alertbot.php');

	foreach ($server_config as $key => $data) {
		
		$server_file = $data['URL'];
		$capacity = $data['Capacity'];

		$parsed_data = parseServerLog($server_file);

		if(($parsed_data['total']) >= ($capacity/2)) {
	    	$message = urlencode("<b><u>Caution! Monitor Apache Status</u></b>\n\n<b>Server Name: ".$data['Name']."</b>\n<b>Server IP: </b><code>".$data['Host']."</code>\n<b>Server Capacity: </b><code>".$capacity."</code>\n<b>Threshold: </b><code>".($capacity/2)."</code>\n<b>Load: </b><code>".$parsed_data['total']."</code>\n<b>Processed: </b><code>".$parsed_data['process']."</code>\n<b>Idle: </b><code>".$parsed_data['idle']."</code>\n\n<b><u>Detail Monitoring</u></b>\n\n<b>URL: </b><i>".$data['URL']."</i>" );

			alertRequest($message);
	    }
	}
?>