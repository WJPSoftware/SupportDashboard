<?php 

  $url = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/dashboard/1867294";
  $JSON = file_get_contents($url);
  
  $usersUrl = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/workspaces/1867294/users";
  $usersJSON = file_get_contents($usersUrl);
  
  $ActivityArray = json_decode($JSON, true)[activity];
  $UsersArray = json_decode($usersJSON, true);
  
  // print_r($ActivityArray);
  // print_r($UsersArray);
  
  $FullArr = array();
  
  foreach ($ActivityArray as $key => $value) {
    $user = $value[user_id];
    $Username = getUser($user, $UsersArray);
    
    $current = $value[duration] < 0 ? 1 : 0;
    $duration = $value[duration] > 0 ? round($value[duration]/60) : round((time() + $value[duration])/60);
    
    $InnerArr = array("Username" => $Username, "IsCurrent" => $current, "Duration" => $duration, "Description" => $value[description]);
    array_push($FullArr,$InnerArr);
  }
  
  print(json_encode($FullArr));
  
  
  function getUser($userid, $UsersArray){
    foreach ($UsersArray as $userKey => $userValue) {
      if($userid == $userValue[id]){
        return $userValue[fullname];
      }
    }
  }
  
  

?>