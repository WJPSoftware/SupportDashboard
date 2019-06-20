<?php 

$address = $_GET['address'];
$paddress = $_GET['paddress'];

if($address == '' || $address == null){
	exit('Invalid Address');
}
if($paddress == '' || $paddress == null){
	exit('Invalid Physical Address');
}

wol($address, $paddress);

function wol($broadcast, $mac)
{
	echo'<br/>Running wake on lan for ' . $broadcast;
    $mac_array = explode(':', $mac);

    $hwaddr = '';

    foreach($mac_array AS $octet)
    {
        $hwaddr .= chr(hexdec($octet));
    }

    // Create Magic Packet

    $packet = '';
    for ($i = 1; $i <= 6; $i++)
    {
        $packet .= chr(255);
    }

    for ($i = 1; $i <= 16; $i++)
    {
        $packet .= $hwaddr;
    }

    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    if ($sock)
    {
        $options = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, true);

        if ($options >=0) 
        {    
            $e = socket_sendto($sock, $packet, strlen($packet), 0, $broadcast, 7);            
            socket_close($sock);
        }    
    }
}

 ?>