<?php 
include 'resources/functions.php';


$authorisedIp=authoriseduser();
if($authorisedIp)
{
    echo "<a>User interface</a>";
    echo " <a href=\"hearthstone/user.php\">Hearthstone auction</a>"; 
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "<a>admin interface</a>";
    echo " <a href=\"hearthstone/admin.php\">Hearthstone auction</a>"; 
    
}
else {
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] ."\hsauc/hearthstone/user.php");
}

?>
