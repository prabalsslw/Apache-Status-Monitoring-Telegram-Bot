<?php 

	function parseServerLog($server_path) {
		$read_line = file($server_path);

		foreach ($read_line as $line) {
			if (strpos($line, 'currently being processed') !== false) {
			    $container = explode(",", $line);
			    $process = strip_tags(str_replace("requests currently being processed","", $container[0] ));
			    $idle = strip_tags(str_replace("idle workers","", $container[1] ));
			    
			    $process = str_ireplace("\r\n"," ", $process );
			    $process = str_ireplace("\n"," ", $process );
			    $process = preg_replace('!\s+!', ' ', $process);
			    $process = intval(trim($process));

			    $idle = str_ireplace("\r\n"," ", $idle );
			    $idle = str_ireplace("\n"," ", $idle );
			    $idle = preg_replace('!\s+!', ' ', $idle);
			    $idle = intval(trim($idle));

			    return [
			    	"process" => $process,
			    	"idle" => $idle,
			    	"total" => ($process + $idle)
			    ];
			}
		}
	}