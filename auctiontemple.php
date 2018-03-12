<?php /* Template Name: auctiontemple */ ?>
 
<?php get_header(); 
 //https://stackoverflow.com/questions/768431/how-to-make-a-redirect-in-php redirect
?>

<?php ;
$user_right= get_current_user_id();  //if 0 they are visitors. everything else its a user
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


$round_count = $conn->query('SELECT count(*) + 1 FROM auction_log')->fetch_row()[0];
$total_rounds = $conn->query('SELECT count(*) + 1 FROM auction_round')->fetch_row()[0];
//echo "$total_rounds";
//echo "$round_count";
$player_id = $_POST['id'];
$bid = $_POST['bid'];

if ($player_id != "" && $user_right!=0 && $round_count<=$total_rounds ){
$sql = "insert into auction_log (round, player, bid) values ($round_count, $player_id, $bid)";
$conn->query($sql);
$sql="update auction_players set auction_players.dust=(auction_players.dust-$bid) where auction_players.id=$player_id;";
$conn->query($sql);
$round_count++;
}
if ($user_right==0 && $round_count!=$total_rounds)
{
echo "<meta http-equiv=\"refresh\" content=\"40\">";
}
?>
<!- Rules expalined and they will be active at the start of the game and at the end  ->
 <div>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <center> <font size="6"> <?php the_title() ?> </font> </center>
                </br>
            <?php 
                if ( $round_count<2 || $round_count==$total_rounds)
                {  the_content(); /*This code prints the content*/} ?>
        <?php endwhile; endif; ?>
    </div>




<style>
table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
//width: 100%;
}

td, th {
border: 1px solid #dddddd;
padding: 8px;
}

tr:nth-child(even) {
	   background-color: #dddddd;
   }
tr:nth-child(1) {
	   font-size: 120%;
   }
</style>

<table>
<tr>
<th>Players</th>  
<?php

  if($round_count==$total_rounds)
            {
            echo "<th>Remaining Dust</th>";
             
}

     if($user_right!=0)
            {
                echo " <th>Input Bid</th> ";
                }
?>
  </tr>
<?php
//select auction_players.player, auction_players.dust-sum(auction_log.bid) as dust ,auction_players.id from auction_log inner join auction_players on auction_log.player=auction_players.id  group by auction_log.player;
$sql = "SELECT player, dust, id FROM auction_players";
//$sql="select auction_players.player, auction_players.dust-sum(auction_log.bid) as dust ,auction_players.id from auction_players inner join auction_log on auction_log.player=auction_players.id  group by auction_log.player;";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$player_id = $row['id'];
		echo "<tr><td>" .
			$row["player"].
			"</td>" ;
               if($round_count==$total_rounds || $user_right!=0)
            {
            echo "<td>".
             $row["dust"]. "</td>" ;
}
   if($user_right!=0)
            {
		echo "<td>" .
            "<form method='POST'><input type=\"hidden\" name='id' value=\"$player_id\">".
			 "<input type=\"number\" required=\"required\" name='bid'>".
			"<input type=\"submit\" value=\"Submit\">".
            "</form></td>";
			}
           echo "</tr>";
	}
} else {
//	echo "0 results";
}

?>
</table>
<?php

//final results 

if ( $round_count >=$total_rounds)
        {
            echo "<div>".
            "<table>".
            "<tr>".
            "<td>Player</td> <td>Common</td> <td>Rare</td> <td>Epic</td> <td>Legendary</td>".
            "</tr>";
       
$sql = "select auction_players.player as Player, sum(auction_round.common) as Common,sum(auction_round.rare) as Rare,sum(auction_round.epic) as Epic,sum(auction_round.legendary) as Legendary  from auction_round inner join auction_log on auction_round.round=auction_log.round inner join auction_players on auction_log.player=auction_players.id group by auction_players.player;";
$result = $conn->query($sql);
 }

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
?>

<?php
if ($round_count<$total_rounds)
{
echo "<table>".
        "<tr>".
        "<th>Round</th><th>Common</th><th>Rare</th><th>Epic</th><th>Legendary</th>".
        "</tr>";

$sql = "SELECT * FROM auction_round where round = $round_count";
$result = $conn->query($sql);

if ($result->num_rows > 0 &&  $round_count<=$total_rounds) {
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
//	echo "0 results";
}
}
?>
</table>
</div>


<?php
if ( $user_right!=0 || $round_count==$total_rounds )
        {
            echo "<div>".
            "<table>".
            "<tr>".
            "<td>Round</td> <td>Player</td> <td>Bid</td>".
            "</tr>";
       
$sql = " SELECT round, auction_players.player, bid FROM auction_log inner join auction_players on auction_log.player=auction_players.id  order by round desc;";
$result = $conn->query($sql);
 }

if ($result->num_rows > 0 ) {
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
//	echo "<tr>0 results</tr>";
}





//select auction_players.player, sum(auction_round.common),sum(auction_round.rare),sum(auction_round.epic),sum(auction_round.legendary) from auction_round inner join auction_log on auction_round.round=auction_log.round inner join auction_players on auction_log.player=auction_players.id group by auction_players.player;
$conn->close();
?>
</table>
</div>

<!- ban area ->
 <img src="../../banimages/img1.png" onerror="this.style.display='none'">
<img src="../../banimages/img2.png"  onerror="this.style.display='none'">
<img src="../../banimages/img3.png"  onerror="this.style.display='none'">
<img src="../../banimages/img4.png"  onerror="this.style.display='none'">
<img src="../../banimages/img5.png"  onerror="this.style.display='none'">
<img src="../../banimages/img6.png"  onerror="this.style.display='none'">
<img src="../../banimages/img7.png"  onerror="this.style.display='none'">
<img src="../../banimages/img8.png"  onerror="this.style.display='none'">

 

    </main><!-- .site-main -->

 
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>


