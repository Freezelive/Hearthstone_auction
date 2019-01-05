<?php
include '../resources/functions.php';

//prevent unauthorised user
$authorisedIp=authoriseduser();
if($authorisedIp)
{}
else {
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/hsauc/hearthstone/user.php");
}
//prevent unauthorised user

session_start();

$conn=hsauccoonect();  //connect to database

//post data
$round_count_repost_prot=$_POST['round_count_prot'] ?? '';
$player_id = $_POST['id'] ?? '';
$bid = $_POST['bid'] ?? '';
//post data



$round_count = $conn->query('SELECT count(*) + 1 FROM auction_log')->fetch_row()[0];
$total_rounds = $conn->query('SELECT count(*) + 1 FROM auction_round')->fetch_row()[0];
$_SESSION['$round_count_repost_prot_saved']=$round_count;

echo "$round_count_repost_prot--|";
echo $_SESSION['$round_count_repost_prot_saved']."|---";
echo "$round_count---";
echo "$total_rounds";

//repost protection
if ($round_count_repost_prot==$_SESSION['$round_count_repost_prot_saved']-1 &&$round_count!=1)
{
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/hsayc/hearthstone/admin.php");
    die();
}else
{
    
}
//repost protection




if ($player_id != ""  && $round_count!=$total_rounds){
    $sql = "insert into auction_log (round, player, bid) values ($round_count, $player_id, $bid)";
    $conn->query($sql);
    $sql="update auction_players set auction_players.dust=(auction_players.dust-$bid) where auction_players.id=$player_id;";
    $conn->query($sql);   
    $round_count++;
}




echo "<html>";
echo "<head>";
echo "<style>table {	font-family: arial, sans-serif;	border-collapse: collapse;width: 100%;}td, th {border: 1px solid #dddddd;padding: 8px;}tr:nth-child(even) {   background-color: #dddddd;   }tr:nth-child(1) {	   font-size: 150%;   }</style>";
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
            "<input type=\"hidden\" name='round_count_prot' value=\"$round_count\">".
            "<input type=\"number\" required=\"required\" name='bid'>".
            "<input type=\"submit\" value=\"Submit\">".
            "</form></td></tr>";
    }
} else {
    echo "0 results";
}
echo "</table>";


//player list

echo "</br>";
echo "</br>";
echo "</br>";
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
echo "</br>";
echo "</br>";
echo "</br>";

//cards sum
echo "<table>".
    "<tr>".
    "<td>Player</td> <td>Common</td> <td>Rare</td> <td>Epic</td> <td>Legendary</td>".
    "</tr>";

$sql = "select auction_players.player as Player, sum(auction_round.common) as Common,sum(auction_round.rare) as Rare,sum(auction_round.epic) as Epic,sum(auction_round.legendary) as Legendary  from auction_round inner join auction_log on auction_round.round=auction_log.round inner join auction_players on auction_log.player=auction_players.id group by auction_players.player;";
$result = $conn->query($sql);


if ($result->num_rows > 0 ) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" .
            $row["Player"].
            "</td><td>" .
            $row["Common"].
            "</td><td>" .
            $row["Rare"].
            "</td><td>" .
            $row["Epic"].
            "</td><td>" .
            $row["Legendary"].
            "</td></tr>";
    }
} else {
    //	echo "<tr>0 results</tr>";
}
echo "</table>";

//card sum
echo "</br>";
echo "</br>";
echo "</br>";

//history

$sql = " SELECT round, auction_players.player, bid FROM auction_log inner join auction_players on auction_log.player=auction_players.id  order by round desc;";
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






if ($round_count==$total_rounds)
{
session_destroy();
echo "session terminated";
header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/hsauc/hearthstone/user.php");
$conn->close();
}


echo "</body>";
echo "</html>";
$conn->close();

?>
