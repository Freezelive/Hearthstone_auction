<?php

include '../decoder/Deckcode.php';


$deckstring= $_POST['deck'];

$dc = new Deckcode;

$deck = $dc->getDeckFromCode($deckstring);

$returns='{"hero":"'.$deck->heroes[0]->id.'","cards":';
$cards='[';

$i=0;
$count=0;

while($count<30)

{

$cardstring=file_get_contents("../cards/".$deck->cards[$i]->id.".card.json");

$cardstring=json_decode($cardstring, true);

$cardstr='{"name":"'.$cardstring['name'].'", "rarity":"'.$cardstring['rarity'].'", "count": "'.$deck->cards[$i]->count.'", "id":"'.$cardstring['id'].'"}';

$cards=$cards.$cardstr.",";

$count=$count+$deck->cards[$i]->count;
$i=$i+1;

}

$cards=substr($cards, 0, -1);

$cards=$cards."]";


$returns=$returns.$cards.'}';
echo($returns);

?>
