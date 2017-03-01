<?php

// *********************************************** //
// Support Dashboard Server Ping                   //
// Original Developer: WJP Software Limited        //
// http://www.wjps.co.uk                           //
// Open Source Code - Please modify for your       //
// requirements and needs.                         //
// *********************************************** //


	// ************************************************************* //
	// Servers to check                                              //
	// ************************************************************* //
	$Servers = array("Hosting" => "109.203.107.129","Portal" => "5.77.35.102","WCS1" => "5.77.39.88","Reseller" => "109.203.107.26");

	$i = 0;

	foreach ($Servers as $Name => $Server) {
		$Status[$i] = array("Label" => $Name, "Status" => ping($Server));
		$i++;
	}

	print(json_encode($Status));

	// ************************************************************* //
	// Ping the Server                                               //
	// ************************************************************* //
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