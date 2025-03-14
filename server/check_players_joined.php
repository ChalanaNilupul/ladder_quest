<?php
session_start();
include "DB_Connect.php";

$roomId = $_SESSION["game_id"];

$result = $conn->query("SELECT status FROM games WHERE game_id = $roomId");
$row = $result->fetch_assoc();

if ($row["status"] === "started") {
    echo json_encode(["started" => true]);
} else {
    echo json_encode(["started" => false]);
}
?>
