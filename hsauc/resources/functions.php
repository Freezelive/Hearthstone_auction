<?php 



function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function hsauccoonect()
{
    $servername = "localhost";
    $username = "auctionear_manager";
    $password = "y7JD9kSFcd7bv3nw";
    $dbname = "HSAuc";
    
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function authoriseduser()
{
    
    $adminIp= array("127.0.0.1","192.168.9.102","10.190.109.20","10.190.109.100","10.190.109.101");
    $authorisedIp=boolval(false);
    
    foreach($adminIp as $ip)
    {
        if($ip===getRealIpAddr())
        {
            $authorisedIp=true;
            break;
        }
    }
    return $authorisedIp;
}



?>
