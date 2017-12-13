<?php 

  $projectUrl = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/workspaces/1867294/projects";
  $projectJSON = file_get_contents($projectUrl);
  $clientUrl = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/workspaces/1867294/clients";
  $clientJSON = file_get_contents($clientUrl);

  $ProjectsArray = json_decode($projectJSON, true);
  $ClientArray = json_decode($clientJSON, true);
    
  $FullArr = array();
    
  foreach ($ProjectsArray as $key => $value) {
    
    if($value[estimated_hours] == null || $value[estimated_hours] == '' ){continue;}
    
    $client = $value[cid];
    
    $ClientName = getClient($client, $ClientArray);
    
    $ActualHours = $value[actual_hours] == null || $value[actual_hours] == '' ? 0 : $value[actual_hours];
    
    $TimeLeft = $value[estimated_hours] - $ActualHours;
    
    $Bad = $TimeLeft < 1;
    
    $InnerArr = array("Name" => $value[name], "ActualHours" => $ActualHours, "EstimatedHours" => $value[estimated_hours], "TimeLeft" => $TimeLeft, "Client" => $ClientName, "Bad" => $Bad);
    array_push($FullArr,$InnerArr);
  }
  
  print(json_encode($FullArr));

  function getClient($clientid, $ClientsArray){
    foreach ($ClientsArray as $clientKey => $clientValue) {      
      if($clientid === $clientValue[id]){        
        return $clientValue[name];
      }
    }
  }
  
  

?>