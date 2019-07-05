<?php 

$cardsArray = array();
$FullArray = array();

$jamesTasks = array();
$stevenTasks = array();
$samTasks = array();
$brandonTasks = array();
$alexTasks = array();
$boards[0] = [ "5c8fac795aa5808be7efb4ed"];
$boards[1] = [ "5c8faa82bea8067c25842682"];
$boards[2] = [ "5c9680294ddf4b339b633edd"];
$boards[3] = [ "5c8fac8edbe18d4b855271c0"];
$boards[4] = [ "5c8fac69af1caa4ced5d6df1"];

foreach($boards as $board){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.trello.com/1/boards/{$board[0]}/lists/?cards=open&card_fields=name,closed&card=&key=88d4072bd9e9fdaea0da0f76c2e6d1af&token=d1ae2a3576f1b10cca5d265595bec0c6a34e02820d908918b0dfae5798d83986",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Postman-Token: f5af272f-adae-4663-bebf-cb9e11fab43b",
      "cache-control: no-cache"
    ),
  ));
  $cards = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } 
  else {
    $cardsArray = json_decode($cards, true);
    foreach ($cardsArray as $key => $value){
      $boardId = $value["idBoard"];
      if($boardId == "5c8fac795aa5808be7efb4ed"){
        $boardName = "MRS 2.5";
      }
      if($boardId == "5c8faa82bea8067c25842682"){
        $boardName = "MRS 3";
      }
      if($boardId == "5c9680294ddf4b339b633edd"){
        $boardName = "MRS AF";
      }
      if($boardId == "5c8fac8edbe18d4b855271c0"){
        $boardName = "EWT";
      }
      if($boardId == "5c8fac69af1caa4ced5d6df1"){
        $boardName = "WCS";
      }
      if($value["name"] == "James"){
        $jamesTasks = count($value["cards"]);

      }
      if($value["name"] == "Steven"){
        $stevenTasks = count($value["cards"]);
      }
      if($value["name"] == "Sam"){
        $samTasks = count($value["cards"]);
      }     
      if($value["name"] == "Brandon"){
        $brandonTasks = count($value["cards"]);
      }
      if($value["name"] == "Alex"){
        $alexTasks = count($value["cards"]);

      }

      $allCards = array("board" => $boardName, "James" => $jamesTasks, "Steven" => $stevenTasks, "Sam" => $samTasks, "Brandon" => $brandonTasks, "Alex" => $alexTasks );
      
    }
    array_push($FullArray, $allCards);
    //print_r($cardsArray);
  }

}
  print(json_encode($FullArray));


