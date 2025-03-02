<?php

include('./dbConnect.php');

$userName = trim($_POST['userName']);
$score = $_POST['score'];

$sql = "SELECT `highScore` FROM `players` WHERE `userName`='" . $userName . "'";

$result = mysqli_query($con, $sql);

$row = mysqli_fetch_assoc($result);
$currScore = $row['highScore'];

if($currScore < $score){
    $sql1 = "UPDATE `users`
    SET `highScore` = '$score'
    WHERE `userName`='".$userName."'";

    if(mysqli_query($con, $sql1)){

        echo "Success";
    }
    else{
        echo "Error";
    }
}
else {
    echo "Lower";
}



?>