<?php
include '../resources/functions.php';

$authorisedIp=authoriseduser();
$conn=hsauccoonect();  //connect to database

if($authorisedIp)
{
$player_id = $_POST['id'];
$bid = $_POST['bid'];
}
$round_count = $conn->query('SELECT count(*) + 1 FROM auction_log')->fetch_row()[0];
if ($player_id != ""){
    $sql = "insert into auction_log (round, player, bid) values ($round_count, $player_id, $bid)";
    $conn->query($sql);
    $round_count++;
}



echo "<html>";
echo "<head>";
echo "<style>table {	font-family: arial, sans-serif;	border-collapse: collapse;idth: 100%;}td, th {border: 1px solid #dddddd;padding: 8px;}tr:nth-child(even) {   background-color: #dddddd;   }tr:nth-child(1) {	   font-size: 150%;   }</style>";
echo "</head>";
echo "<body>";




//player list
$sql = "SELECT player, dust, id FROM auction_players";
$result = $conn->query($sql);
echo "<table>";
echo "<th>Players</th>    <th>Remaining Dust</th> <th>Input Bid</th>";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $player_id = $row['id'];
        echo "<tr><td>" .
            $row["player"].
            "</td><td>" . $row["dust"]. "</td>" .
            "<td>" .
            "<form method='POST'><input type=\"hidden\" name='id' value=\"$player_id\">".
            "<input type=\"number\" name='bid'>".
            "<input type=\"submit\" value=\"Submit\">".
            "</form></td></tr>";
    }
} else {
    echo "0 results";
}
echo "</table>";


//player list


//list of cards

$sql = "SELECT * FROM auction_round where round = $round_count";

$result = $conn->query($sql);
echo "<table>";
echo "<th>Round</th><th>Common</th><th>Rare</th><th>Epic</th><th>Legendary</th>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" .
            $row["round"].
            "</td><td>" .
            $row["common"].
            "</td><td>" .
            $row["rare"].
            "</td><td>" .
            $row["epic"].
            "</td><td>" .
            $row["legendary"].
            "</td></tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

//list of cards

//history
$sql = "SELECT round, player, bid FROM auction_log";
$result = $conn->query($sql);
echo "<table>";
echo "<td>Round</td> <td>Player</td> <td>Bid</td>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" .
            $row["round"].
            "</td><td>" .
            $row["player"].
            "</td><td>" .
            $row["bid"].
            "</td></tr>";
    }
} else {
    echo "<tr>0 results</tr>";
}

echo "</table>";
//history



echo "</body>";
echo "</html>";
$conn->close();

?>