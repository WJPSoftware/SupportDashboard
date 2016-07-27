<?php

	output();

	function output(){

	
		//Users

		//$Users = json_decode(users());

		//print_r($Users);

		$OutputArray = array();

		//Users
		$Users[0] = ""; //JP
		//$Users[1] = "1098036882208989260"; //SL
		//$Users[2] = "1054659565007053193"; //JL
		//$Users[3] = "1132889807467380974"; //SQCL
		//$Users[4] = "1100769933341483309"; //WJPS
		//$Users[5] = "1132948781569351846"; //SQCLGrou


		foreach ($Users as $User) {
			# code...
			//print($User->{'id'});

			$ch = curl_init();
 
			curl_setopt($ch,CURLOPT_URL,"https://deskapi.gotoassist.com/v1/changes.json?limit=99&selected_user_id=" . $User);
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

			$headr = array();
			//$headr[] = '-u x:b0a377a7a77dce64e593a95385eb3374 -H';
			$headr[] = 'Content-type: application/json';

			curl_setopt($ch, CURLOPT_USERPWD, "x:b0a377a7a77dce64e593a95385eb3374");

			curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

		//  curl_setopt($ch,CURLOPT_HEADER, false); 
		 
		    $output=curl_exec($ch);
		 
		    curl_close($ch);

		    //print_r($output . "<br/><br/><br/>");

		    $obj = json_decode($output);

		    if(sizeof($OutputArray) == 0){
		    	$OutputArray = $obj->{'result'}->{'changes'};
		    } else {
			    $OutputArray = array_merge($OutputArray,$obj->{'result'}->{'changes'});
			}


			//print(sizeof($OutputArray));
		    //print_r(json_encode($obj->{'result'}->{'incidents'}));
    
		}

		print_r(json_encode($OutputArray));

	   }

   





?>