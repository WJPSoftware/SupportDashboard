<?php

// *********************************************** //
// Support Dashboard Changes from Website           //
// Original Developer: WJP Software Limited        //
// http://www.wjps.co.uk                           //
// Open Source Code - Please modify for your       //
// requirements and needs.                         //
// *********************************************** //

	$ch = curl_init();
 
 	// ************************************************************* //
	// Gets all contacts from WJPS                                   //
	// ************************************************************* //
	curl_setopt($ch,CURLOPT_URL,"https://wjps.co.uk/api/contactformapi.php?type=count");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	$headr = array();
	
	$headr[] = 'Content-type: application/json';

	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

    $output=curl_exec($ch);
 
    curl_close($ch);
    
    print_r(preg_replace( "/\r|\n/", "", strip_tags($output)));
    
?>