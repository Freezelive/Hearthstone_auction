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

       
        $result=mysqli_query($conn,$generateIDQuerry); 
        $result=$result->fetch_array();
        $generatedID = $result[0];
        $stmt = $conn->prepare("INSERT INTO auction_players VALUES (?, ?, ?)");
        $stmt->bind_param('sii',$player, $dust,$id );

        $player=$name;
        $id=$generatedID;
        
        $dust=150;

        
        if ($stmt->execute() === TRUE) {
            $stmt->close();
            $conn->close();

            $_SESSION['user_session'] = $name;
            $cookie_name = "user";
            $cookie_value = $name;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            echo "Great!";

            exit();
        } else {
            echo "Error: " . $stmt . "<br>" . $conn->error;
            $stmt->close();
            $conn->close();
        }
    }
?>

