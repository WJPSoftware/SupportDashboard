<?php 

$mysqli = new mysqli("localhost", "dash_admin", "WJPSDBPASS", "Dashboard");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
 
$query = "SELECT * FROM paneltoggle";

if ($result = $mysqli->query($query)) {

    /* fetch object array */
    while ($obj = $result->fetch_object()) {
    	$arr = array("Status" => $obj->Status);
        print(json_encode($arr));
    }

    /* free result set */
    $result->close();
}else{
	echo"FAIL";
}

/* close connection */
$mysqli->close();

?>