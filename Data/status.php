<?php

	$Servers = array("Hosting" => "109.203.107.129","Portal" => "5.77.35.102","AD01" => "192.168.1.100");

	$i = 0;



	foreach ($Servers as $Name => $Server) {
		//echo($Server . " " . ping($Server) . " | ");
		$Status[$i] = array("Label" => $Name, "Status" => ping($Server));
		$i++;
	}

	//$arr = array_merge($Servers,$Status);

	print(json_encode($Status));

	function ping($host,$port=80,$timeout=6)
	{
        $fsock = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!is_resource($fsock))
        {
                return "FALSE";
        }
        else
        {
                return "TRUE";
        }
	}

?>