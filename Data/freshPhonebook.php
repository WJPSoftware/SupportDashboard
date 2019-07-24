<?php

header('Content-type: text/xml');
    header('Pragma: public');
    header('Cache-Control: private');
    header('Expires: -1');


    print("<?xml version='1.0' encoding='UTF-8'?>");

    print("<YearlinkIPPhoneBook>");

    print("<Title>Yealink</Title>");

    print("<Menu Name='PhoneBook'>");

$PhoneArray = getPhone(1);

$displayName = array();
$mobileNumber = array();
$workNumber = array();

$pages= $PhoneArray['meta']['total_pages'];

for($p = 1; $p < $pages + 1; $p++){
  
  $i = 0;
  $PhoneArray = getPhone($p);

  foreach ($PhoneArray["contacts"] as $key => $value) {
    $displayName[$i] = $value["display_name"];
    if($value["mobile_number"] != NULL) {
      $mobileNumber[$i] = $value["mobile_number"];
      $mobileNumber[$i] = str_replace(' ','',$mobileNumber[$i]);
    }
    else {
      $mobileNumber[$i] = NULL;
    }
    if($value["work_number"] != NULL) {
      $workNumber[$i] = $value["work_number"];
      $workNumber[$i] = str_replace(' ','',$workNumber[$i]);
    }
    else {
      $workNumber[$i] = NULL;
    }
    /*usort($PhoneArray["contacts"], function ($a, $b){
      return $a['display_name'] <=> $b['display_name'];
    });*/
    //print_r($displayName);
    //print_r($mobileNumber);

    if(strlen($mobileNumber[$i]) > 0 || strlen($workNumber[$i]) > 0){
      print("<Unit Name='" . $displayName[$i] . "' default_photo='' Photo3='' Phone2='" . $mobileNumber[$i] ."' Phone1='" . $workNumber[$i] ."'/>");
    }
    $i++;

    //print_r($PhoneArray);
   
  }
}
   
print("</Menu>");

print("</YearlinkIPPhoneBook>");


function getPhone($page) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://wjps.freshsales.io/api/contacts/view/8000591475?page={$page}&per_page=100&sort=last_name&sort_type=asc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      "Accept-Encoding: gzip, deflate",
      'Authorization: Token token="k6XHoCaB-HpBrr8iPLeaMA"',
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Host: wjps.freshsales.io",
      "Postman-Token: 63f5bd73-9a33-47dc-a0ed-01e9791f4379,1d5d3e0b-7fa9-41ec-b2ce-8bd1d9e5f895",
      "User-Agent: PostmanRuntime/7.15.2",
      "cache-control: no-cache"
    ),
  ));

  $getPhone = curl_exec($curl);
  $err = curl_error($curl);

  //echo $getPhone;

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
      $PhoneArray = json_decode($getPhone, true);
      //print_r($PhoneArray);
  }
  return $PhoneArray;
}

?>