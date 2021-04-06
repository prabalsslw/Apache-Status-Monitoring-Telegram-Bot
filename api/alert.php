<?php 
	$server_config = require_once('../config/server.php');

	require_once('../lib/functions.php');
	require_once('../lib/alertbot.php');

	foreach ($server_config as $key => $data) {
		
		$server_file = $data['URL'];
		$status_code = checkHttpStatusCode($server_file);
		$capacity = $data['Capacity'];

		if($status_code == 200) {
			$parsed_data = parseServerLog($server_file);

			if(($parsed_data['total']) >= ($capacity/2)) {
		    	$message = urlencode("<b><u>Caution! Monitor Apache Status</u></b>\n\n<b>Server Name: ".$data['Name']."</b>\n<b>Server IP: </b><code>".$data['Host']."</code>\n<b>Server Capacity: </b><code>".$capacity."</code>\n<b>Threshold: </b><code>".($capacity/2)."</code>\n<b>Load: </b><code>".$parsed_data['total']."</code>\n<b>Processed: </b><code>".$parsed_data['process']."</code>\n<b>Idle: </b><code>".$parsed_data['idle']."</code>\n\n<b><u>Detail Monitoring</u></b>\n\n<b>URL: </b><i>".$data['URL']."</i>" );
		    }
		}
		else {
			$http_response = get_http_response_code($status_code);
			$message = urlencode("<b><u>Sorry! Something Went Wrong</u></b>\n\n<b>Server Name: ".$data['Name']."</b>\n<b>URL: </b><code>".$data['URL']."</code>\n\n<b><u>Response</u></b>\n<code>".$status_code." : ".$http_response."</code>" );
		}

		alertRequest($message);
	}
?>