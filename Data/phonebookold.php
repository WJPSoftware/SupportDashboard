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

    print("<vp_contact>");

    print("<root_group>");

        print("<group display_name='Phonebook'/>");

    print("</root_group>");

    print("<root_contact>");

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

                print("<contact display_name='" . $item->{'FIRST_NAME'} . " " . str_replace("'", "", $item->{'LAST_NAME'}) . "' default_photo='' other_number='" . $PhoneNumbers[2] ."' mobile_number='" . $PhoneNumbers[1] ."' office_number='" . $PhoneNumbers[0] ."' group_id_name='Phonebook'/>");

            }

            //print("<Unit Name='" . $Hello . "'/>");

    		//$return = array_merge($return,array($item->{'FIRST_NAME'},$item->{'LAST_NAME'}));
    	//}
    }

    print("</root_contact>");

    print("</vp_contact>");
    
    //print_r(json_encode($return));



?>