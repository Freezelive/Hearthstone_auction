<?php

echo  "test";

// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents("cards.collectible.json");
//var_dump($strJsonFileContents); // show contents

// Convert to array 
$array = json_decode($strJsonFileContents, true);

echo sizeof($array);

//echo json_encode($array[1]); // print array

for ($i=0; $i<sizeof($array);$i++)
{
$cardid=$array[$i][dbfId];
//echo json_encode($array[0]);
$cardinf=json_encode($array[$i]);
echo $cardinf;
$myfile = fopen($cardid.".card.json", "w");
fwrite($myfile,$cardinf);
fclose($myfile);
}

?>
