<?php

	$ch = curl_init();
 
	curl_setopt($ch,CURLOPT_URL,"https://www.wjps.co.uk/contactformapi.php?type=list");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	$headr = array();
	//$headr[] = '-u x:b0a377a7a77dce64e593a95385eb3374 -H';
	$headr[] = 'Content-type: application/json';

	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    
    print_r($output);



?>