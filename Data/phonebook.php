<?php

	$ch = curl_init();
 
	curl_setopt($ch,CURLOPT_URL,"https://api.insight.ly/v2.1/Contacts");
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

    //print_r($list);

    header('Content-type: text/xml');
    header('Pragma: public');
    header('Cache-Control: private');
    header('Expires: -1');


    print("<?xml version='1.0' encoding='UTF-8'?>");

    print("<YearlinkIPPhoneBook>");

    print("<Title>Yealink</Title>");

    print("<Menu Name='PhoneBook'>");

    foreach ($list as $item) {
    	//print_r($item);

    //	if($item->{'COMPLETED'} != "1"){

            //echo($item->{'LAST_NAME'});

            //Get Phone Numbers
            $Contacts = $item->{'CONTACTINFOS'};

            $PhoneNumbers =  array();
            $i = 0;

            foreach ($Contacts as $Contact) {
                if($Contact->{'TYPE'} == "PHONE"){
                    $PhoneNumbers[$i] = $Contact->{'DETAIL'};
                    $i++;
                }
            }

            //print_r($Contact);

            if(sizeof($PhoneNumbers) > 0){

                print("<Unit Name='" . $item->{'FIRST_NAME'} . " " . str_replace("'", "", $item->{'LAST_NAME'}) . "' default_photo='' Phone3='" . $PhoneNumbers[2] ."' Phone2='" . $PhoneNumbers[1] ."' Phone1='" . $PhoneNumbers[0] ."'/>");

            }

            //print("<Unit Name='" . $Hello . "'/>");

    		//$return = array_merge($return,array($item->{'FIRST_NAME'},$item->{'LAST_NAME'}));
    	//}
    }

    print("</Menu>");

    print("</YearlinkIPPhoneBook>");
    
    //print_r(json_encode($return));



?>