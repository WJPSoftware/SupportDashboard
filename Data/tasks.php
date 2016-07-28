<?php

	$ch = curl_init();
 
	curl_setopt($ch,CURLOPT_URL,"https://api.insight.ly/v2.1/Tasks");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	$headr = array();
	//$headr[] = '-u x:b0a377a7a77dce64e593a95385eb3374 -H';
	$headr[] = 'Content-type: application/json';

	curl_setopt($ch, CURLOPT_USERPWD, "37a8cd68-0465-4180-b82a-96f86d5fee52:");

	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);
 
    curl_close($ch);

    $return = array();

    $list = json_decode($output);

    if($list != null){

    foreach ($list as $item) {
    	//print_r($item);

    	if($item->{'COMPLETED'} != "1"){

    		$return = array_merge($return,array($item));
    	}
    }
    
    print_r(json_encode($return));

    }else{

        print("null");
        
    }


?>