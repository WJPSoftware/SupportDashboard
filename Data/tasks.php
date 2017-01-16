<?php

// *********************************************** //
// Support Dashboard Tasks from Insightly          //
// Original Developer: WJP Software Limited        //
// http://www.wjps.co.uk                           //
// Open Source Code - Please modify for your       //
// requirements and needs.                         //
// *********************************************** //

	$ch = curl_init();
 
    // ************************************************************* //
    // Get tasks from Insightly                                      //
    // ************************************************************* //
	curl_setopt($ch,CURLOPT_URL,"https://api.insight.ly/v2.1/Tasks");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	$headr = array();

	$headr[] = 'Content-type: application/json';

    // ************************************************************* //
    // API Password                                                  //
    // ************************************************************* //
	curl_setopt($ch, CURLOPT_USERPWD, "37a8cd68-0465-4180-b82a-96f86d5fee52:");

	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

    $output=curl_exec($ch);
 
    curl_close($ch);

    $return = array();

    $list = json_decode($output);

    if($list != null){

    foreach ($list as $item) {

    	if($item->{'COMPLETED'} != "1" && $item->{'DUE_DATE'} < date("Y-m-d",strtotime('+3 months'))){

    		$return = array_merge($return,array($item));
    	}
    }
    
    print_r(json_encode($return));

    }else{

        print("null");
        
    }


?>