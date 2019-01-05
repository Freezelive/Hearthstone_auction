<?php

    include './Connection.php';
    include './Session.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $name = $_POST['name'];

        $name = mysqli_escape_string($conn, $name);

        $total_rounds = $conn->query('SELECT count(*) + 1 FROM auction_round')->fetch_row()[0];

        $round=0;

        $free=0;
        $common=0;
        $rare=0;
        $epic=0;
        $legendary=0;

        $sql = "select auction_players.player as Player, sum(auction_round.common) as Common,sum(auction_round.rare) as Rare,sum(auction_round.epic) as Epic,sum(auction_round.legendary) as Legendary  from auction_round inner join auction_log on auction_round.round=auction_log.round inner join auction_players on auction_log.player=auction_players.id group by auction_players.player;";
        $result = $conn->query($sql);

        $response="";

        if ($result->num_rows > 0 ) {
            while($row = $result->fetch_assoc()) {
                if($row["Player"]==$name){
                    $response = json_encode('{"common":'.$row["Common"].', "rare":'.$row["Rare"].', "Epic":'.$row["Epic"].', "Legendary":'.$row["Legendary"].'}');
                    echo $response;
                    exit();
                }
            }
        } 

    }

    ?>