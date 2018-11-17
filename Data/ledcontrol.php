<?php

$Type = $_GET['type'];

if(!$Type){echo('Invalid Input'); exit();}

$mysqli = new mysqli("localhost", "dash_admin", "WJPSDBPASS", "dashboard");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
switch ($Type) {
  case 'update':
    $Name = $_GET['name'];
    $Value = $_GET['val'];
    $query = "UPDATE led_control SET command = \"" . $Value . "\" WHERE Name = \"" . $Name . "\";";
    runQuery($query,$mysqli);
    break;
  case 'getfeature':
    $Feature = $_GET['feature'];
    $query = "SELECT command FROM led_control WHERE Name = \"" . $Feature . "\";";
    $val = runQuery($query,$mysqli,true);

    echo$val;
    break;
  default:
    # code...
    break;
}

function runQuery($q,$sql,$return = false){
  $result = $sql->query($q);
  if (!$result) {
  	echo"FAIL";
  }

  if($return){
    return $result->fetch_assoc()['command'];
  }

  $sql->close();

  return;
}
?>
