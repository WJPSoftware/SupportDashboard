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
	$Servers = array("ALBPC" => "www.aiskewleemingbarpc.org.uk", "ATHP" => "www.athp.org.uk", "BCL" => "www.bedalecommunitylibrary.org.uk", "BTC" => "www.bedale-tc.gov.uk", "MHS" => "www.mashamshireshow.org.uk", "NEPPS" => "www.nepps.org.uk", "NESPS" => "www.nesps.org.uk", "NWPQA" => "www.nwpqa.nhs.uk", "PASG" => "www.pasg.co.uk", "QANEY" => "www.qaney.co.uk", "QCNW" => "www.qcnw.nhs.uk", "SQCL" => "www.sqcl.org.uk", "WJPS" => "www.wjps.co.uk", "YCP" => "www.ycp.org.uk", "YHPPC" => "www.yhppc.nhs.uk");

	$i = 0;

	foreach ($Servers as $Name => $Server) {
		$Status[$i] = array("Label" => $Name, "URL" => $Server, "Status" => ping($Server));
		$i++;
	}

	print(json_encode($Status));

	// ************************************************************* //
	// Ping the Server                                               //
	// ************************************************************* //
	function ping($host,$port=80,$timeout=3)
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