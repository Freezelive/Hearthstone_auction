<?php

include 'Deckcode.php';


$dc = new Deckcode;

$deck = $dc->getDeckFromCode('AAEBAaoIBPIFsQiUvQLN9AIN0wHZB/AH1g+QELIU96oC+6oCoLYCh7wC0bwC9r0ClO8CAA==');
print_r($deck);


?>
