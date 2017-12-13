<?php 

  $url = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/dashboard/1867294";
  $JSON = file_get_contents($url);
  
  $usersUrl = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/workspaces/1867294/users";
  $usersJSON = file_get_contents($usersUrl);
  
  $projectUrl = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/workspaces/1867294/projects";
  $projectJSON = file_get_contents($projectUrl);
  
  $taskUrl = "https://02d71770f854e519d0bd93528fa6c87b:api_token@www.toggl.com/api/v8/workspaces/1867294/tasks";
  $taskJSON = file_get_contents($taskUrl);
  
  $ActivityArray = json_decode($JSON, true)[activity];
  $UsersArray = json_decode($usersJSON, true);
  $ProjectsArray = json_decode($projectJSON, true);
  $TasksArray = json_decode($taskJSON, true);
    
  //print_r($TasksArray);
  // print_r($UsersArray);
  
  $FullArr = array();
  
  foreach ($ActivityArray as $key => $value) {
    $user = $value[user_id];
    $project = $value[project_id];
    $task = $value[tid];
    
    $Username = getUser($user, $UsersArray);
    $ProjectName = getProject($project, $ProjectsArray);
    $TaskName = getTask($task, $TasksArray);
    
    $current = $value[duration] < 0 ? 1 : 0;
    //$duration = $value[duration] > 0 ? round($value[duration]/60) : round((time() + $value[duration])/60);
    
    if($value[duration] > 0){
      $duration = minutesToHours($value[duration]/60);
    }else{
      $duration = minutesToHours((time() + $value[duration])/60);
    }
        
    $InnerArr = array("Username" => $Username, "IsCurrent" => $current, "Duration" => $duration, "Description" => $value[description], "Project" => $ProjectName, "Task" => $TaskName);
    array_push($FullArr,$InnerArr);
  }
  
  print(json_encode($FullArr));
  
  function minutesToHours($minutes){
    if($minutes >= 60){
      return round($minutes/60, 1) . " Hours";
    }else{
      return round($minutes) . " Minutes";
    }
  }
  
  function getUser($userid, $UsersArray){
    foreach ($UsersArray as $userKey => $userValue) {
      if($userid == $userValue[id]){
        return $userValue[fullname];
      }
    }
  }
  
  function getProject($projectid, $ProjectsArray){
    foreach ($ProjectsArray as $projectKey => $projectValue) {
      if($projectid == $projectValue[id]){
        //print($projectValue[name]);
        return $projectValue[name];
      }
    }
  }
  
  function getTask($taskid, $TasksArray){
    foreach ($TasksArray as $taskKey => $taskValue) {      
      if($taskid === $taskValue[id]){        
        return $taskValue[name];
      }
    }
  }
  
  

?>