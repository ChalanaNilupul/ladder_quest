<?php
session_start();
include "DB_Connect.php";

$gameId = $_POST["gameId"];
$userId = $_SESSION["user_id"];

$sql = "SELECT current_turn FROM game_state WHERE game_id = $gameId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["success" => true, "current_turn" => $row["current_turn"]]);
} else {
    echo json_encode(["success" => false, "error" => "Game state not found"]);
}
?>
