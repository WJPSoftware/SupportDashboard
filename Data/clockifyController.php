<?php 

$timeEntries = array();
$projectName = array();
$FullArray = array();

$Users[0] = array("5c754c34b07987684a855622", "James"); //JP
$Users[1] = array("5c7e6974b079872e4b9a5739", "Steven"); //SL
//$Users[2] = array("5c7f99e9b079872e4b9ecfb9", "Jo"); //JH
$Users[2] = array("5cfe7e5cd278ae14c4c5021d", "Brandon"); //BK
$Users[3] = array("5cf512c11080ec5e234f0b98", "Sam"); //SH
$Users[4] = array("5cf52d11f15c987da0328e22", "Alex"); //AT


// Gets all Users
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.clockify.me/api/workspaces/5c754c35b07987684a855629/users",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Host: api.clockify.me",
    "X-Api-Key: XPUvC9J4rn2Oyr7+",
    "cache-control: no-cache"
  ),
));

$getUsers = curl_exec($curl);
$err = curl_error($curl);


curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    $UsersArray = json_decode($getUsers, true);
    //print_r($UsersArray);
}


foreach ($Users as $User) {

  $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.clockify.me/api/v1/workspaces/5c754c35b07987684a855629/user/{$User[0]}/time-entries",
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Host: api.clockify.me",
      "X-Api-Key: XPUvC9J4rn2Oyr7+",
      "cache-control: no-cache"
    ),
  ));

  $getTimeEntries = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  }
  else {
    $TasksArray = json_decode($getTimeEntries, true);
    foreach($TasksArray as $key => $value) {
      $projectName = $value["description"];
      $Username = $User[1];
      $startTime = $value["timeInterval"]["start"];
      $endTime = $value["timeInterval"]["end"];
      $current = 0;

      $convertStart = strtotime($startTime);
      $convertEnd = strtotime($endTime);


      
      if ($endTime != NULL) {
        $taskTime = round(($convertEnd - $convertStart) /60, 0);
        $current = 0;
      }
      else{
        $taskTime = round((time() - $convertStart) /60, 0);
        $current = 1;
      }

      if($taskTime >= 60 && $convertEnd != NULL) {
        $hours = round(floor($taskTime/60), 0);
        $minutes = $taskTime % 60;
        $taskTime = $hours . "." . $minutes . " hours";
      }
      elseif ($taskTime >= 60 && $convertEnd == NULL) {
        $hours = round(floor($taskTime/60), 0);
        $minutes = $taskTime % 60;
        if($minutes < 10 ){
          $taskTime = $hours . ".0" . $minutes . " hours";
        }
        else {
          $taskTime = $hours . "." . $minutes . " hours";
        }
        $current = 1;
      }

      else {
        $taskTime = $taskTime. " minutes";
      }


      $Projects = array("Username" => $Username,"Description" => $projectName, "IsCurrent" => $current ,"Duration" => $taskTime);
      array_push($FullArray, $Projects);
   
    }

  }
}

print(json_encode($FullArray));

?>