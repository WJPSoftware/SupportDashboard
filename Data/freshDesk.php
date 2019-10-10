<?php

date_default_timezone_set('Europe/Paris');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://wjps.freshdesk.com/api/v2/tickets",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Authorization: Basic YWxleC50dWVyc2xleUB3anBzLmNvLnVrOlN0b2NrcG9ydGNvdW50eTEyMw==",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Cookie: _x_w=33_1; _x_m=x_c",
    "Host: wjps.freshdesk.com",
    "Postman-Token: 674ecadc-3cf3-4d00-87a1-4520d40c7ce7,0943037c-041b-4290-87fa-7b2a7419cc94",
    "User-Agent: PostmanRuntime/7.15.2",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} 
else {


  //echo $response;
  $tickets = json_decode($response, True);
  //print_r($tickets);
  
  $FullArray = array();

  foreach($tickets as $key => $value){
    
    $subject = $value['subject'];
    $dueVal = new DateTime($value['due_by']);
    $createdVal = new DateTime($value['created_at']);
    $priority = $value['priority'];
    $type = $value['type'];
    $responderID = $value['responder_id'];
    $id = $value['id'];

    $createdAt = $createdVal->format('d/m/y');
    $dueBy = $dueVal->format('d/m/y');


    if($responderID == 48000119202){
      $responder = "JP";
    }
    if($responderID == 48000127914){
      $responder = "SL";
    }
    if($responderID == 48001148483){
      $responder = "BK";
    }
    if($responderID == 48001261508){
      $responder = "SH";
    }
    if($responderID == 48005376967){
      $responder = "AT";
    }
    if($responderID == NULL){
      $responder = "WJPS";
    }
    if($value['status'] == 2 || $value['status'] == 3){
      $InnerArray = array("assigned_user" => $responder, "title" => $subject, "service" => $type, "created_at" => $createdAt, "due_date" => $dueBy, "reference_num" => $id, "priority" => $priority);
      array_push($FullArray, $InnerArray);
    }

  }
    print(json_encode($FullArray));
}



?>