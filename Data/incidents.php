<?php

// *********************************************** //
// Support Dashboard Incidents from Citrix           //
// Original Developer: WJP Software Limited        //
// http://www.wjps.co.uk                           //
// Open Source Code - Please modify for your       //
// requirements and needs.                         //
// *********************************************** //

	//echo("Hello");

	output();

	function output(){

	
		$OutputArray = array();

		// ************************************************************* //
		// Pass all Citrix Users and Groups ID's                         //
		// ************************************************************* //
		$Users[0] = "868813227640179608"; //JP
		$Users[1] = "1098036882208989260"; //SL
		$Users[2] = "1054659565007053193"; //JL
		$Users[3] = "1132889807467380974"; //SQCL
		$Users[4] = "1100769933341483309"; //WJPS
		$Users[5] = "1132948781569351846"; //SQCLGrou

		//echo("Load");

		foreach ($Users as $User) {
			
			//($User->{'id'});

			//echo("Help");

			$ch = curl_init();
 
 			// ************************************************************* //
			// Gets all incidents for the current user - See API Manual      //
			// ************************************************************* //
			curl_setopt($ch,CURLOPT_URL,"https://deskapi.gotoassist.com/v1/incidents.json?limit=99&selected_user_id=" . $User);
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

			$headr = array();

			$headr[] = 'Content-type: application/json';

			// ************************************************************* //
			// Your API Password always in the format x:password             //
			// ************************************************************* //
			curl_setopt($ch, CURLOPT_USERPWD, "x:b0a377a7a77dce64e593a95385eb3374");

			curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

		    $output=curl_exec($ch);
		 
		    curl_close($ch);

		    $obj = json_decode($output);

		    // ************************************************************* //
			// Merge each users Incident                                     //
			// ************************************************************* //
		    if(sizeof($OutputArray) == 0){
		    	$OutputArray = $obj->{'result'}->{'incidents'};
		    } else {
			    $OutputArray = array_merge($OutputArray,$obj->{'result'}->{'incidents'});
			}

		}

		print_r(json_encode($OutputArray));

	   }

?>