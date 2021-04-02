<?php 

	require_once('../config/telegram.php');

	function alertRequest($text) {

		$api_url = API_URL.API_TOKEN.ACTION."?chat_id=".CHAT_ID."&text=$text&parse_mode=html";

		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $api_url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

		$result = curl_exec($handle);

		$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		if($code == 200 && !( curl_errno($handle)))
		{
			return json_decode($result, true);
		}
	}