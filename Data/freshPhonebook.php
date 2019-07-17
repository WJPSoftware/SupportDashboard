<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://wjps.freshsales.io/api/contacts/view/8000591475?per_page=1000&sort=name&sort_type=asc",
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
    'Authorization: Token token="nHyFbEwRPrCfEQlbB0M_7Q"',
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Host: wjps.freshsales.io",
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

header('Content-type: text/xml');
    header('Pragma: public');
    header('Cache-Control: private');
    header('Expires: -1');


    print("<?xml version='1.0' encoding='UTF-8'?>");

    print("<YearlinkIPPhoneBook>");

    print("<Title>Yealink</Title>");

    print("<Menu Name='PhoneBook'>");

$displayName = array();
$mobileNumber = array();
$workNumber = array();

$i = 0;
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

  //print_r($displayName);
  //print_r($mobileNumber);

  if(strlen($mobileNumber[$i]) > 0 || strlen($workNumber[$i]) > 0){

                print("<Unit Name='" . $displayName[$i] . "' default_photo='' Photo3='' Phone2='" . $mobileNumber[$i] ."' Phone1='" . $workNumber[$i] ."'/>");

  }
  $i++;
}
   
print("</Menu>");

print("</YearlinkIPPhoneBook>");



?>