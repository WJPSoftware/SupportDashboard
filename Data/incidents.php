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
		$Users[2] = "1054659565007053193"; //JH
		$Users[3] = "1132889807467380974"; //SQCL
		$Users[4] = "1100769933341483309"; //WJPS
		$Users[5] = "1132948781569351846"; //SQCLGroup
		$Users[6] = "1305880241538695169"; //LJ
		$Users[7] = "1443937850880745479"; //SH
		$Users[8] = "1478822331303378945"; //BK

		//echo("Load");

		foreach ($Users as $User) {

			//($User->{'id'});

			//echo("Help");

			$ch = curl_init();

 			// ************************************************************* //
			// Gets all incidents for the current user - See API Manual      //
			// ************************************************************* //

			$headr = array();

			$headr[] = 'Content-type: application/json';

			// ************************************************************* //
			// Your API Password always in the format x:password             //
			// ************************************************************* //
			curl_setopt_array($ch, array(
				CURLOPT_URL => "https://deskapi.gotoassist.com/v1/incidents.json?limit=99&selected_user_id=" . $User,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_USERPWD => "x:b0a377a7a77dce64e593a95385eb3374",
				CURLOPT_HTTPHEADER => array(
					"Content-type: application/json",
			    "cache-control: no-cache"
			  )
			));


	    $output=curl_exec($ch);

			if(!curl_exec($ch)){
			    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}

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

			function cmp($a, $b)
			{
			    return strcmp($a->created_at, $b->created_at) * -1;
			}

			usort($OutputArray, "cmp");

		print_r(json_encode($OutputArray));

	   }

?>
