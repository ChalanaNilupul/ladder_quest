<?php

include "./DB_Connect.php";

$userId = trim($_POST['userId']);
$score = $_POST['score'];

$sql = "SELECT `score` FROM `players` WHERE `id`='" . $userId . "'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
$currScore = $row['score'];

$total = $currScore + $score;

$sql1 = "UPDATE `players`
    SET `score` = '$total'
    WHERE `id`='" . $userId . "'";

if (mysqli_query($conn, $sql1)) {

    echo "Success";
} else {
    echo "Error";
}


?>