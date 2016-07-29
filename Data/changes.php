<?php

// *********************************************** //
// Support Dashboard Changes from Citrix           //
// Original Developer: WJP Software Limited        //
// http://www.wjps.co.uk                           //
// Open Source Code - Please modify for your       //
// requirements and needs.                         //
// *********************************************** //

	output();

	function output(){

		$OutputArray = array();

		//Users
		$Users[0] = "";


		foreach ($Users as $User) {
	
			$ch = curl_init();
 
 			// ************************************************************* //
			// Gets all changes for the current user - See API Manual      //
			// ************************************************************* //
			curl_setopt($ch,CURLOPT_URL,"https://deskapi.gotoassist.com/v1/changes.json?limit=99&selected_user_id=" . $User);
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
			// Merge each users Changes                                      //
			// ************************************************************* //
		    if(sizeof($OutputArray) == 0){
		    	$OutputArray = $obj->{'result'}->{'changes'};
		    } else {
			    $OutputArray = array_merge($OutputArray,$obj->{'result'}->{'changes'});
			}

		}

		print_r(json_encode($OutputArray));

	   }

?>