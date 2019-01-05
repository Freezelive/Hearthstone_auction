<?php
include './Connection.php';
include './Session.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $name = $_POST['name'];
        $request="SELECT * FROM auction WHERE done != 1";
        $request=mysqli_query($conn,$request);
        $row=$request->fetch_array();
        //$row = mysqli_fetch_array($request,MYSQLI_ASSOC);

        $dust= "SELECT dust FROM players WHERE name='$name'";
        $dust=mysqli_query($conn,$dust);
        $dust=$dust->fetch_array()[0];

        if($row['currentPlayer'!='0']){

            $maxbid="SELECT name FROM players WHERE id='".$row['currentPlayer']."'";
            $maxbid=mysqli_fetch_array($maxbid,MYSQLI_ASSOC)[0];
        }
        else
            $maxbid='none';
        $response='{"dust":'.$dust.',"price":'.$row['currentPrice'].',"common":'.$row['common'].', "rare":'.$row['rare'].',"epic":'.$row['epic'].',"legendary":'.$row['legendary'].',"maxBid":"'.$maxbid.'"}';

        echo($response);
}
?>