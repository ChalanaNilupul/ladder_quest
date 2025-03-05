<?php
session_start();
include "DB_Connect.php";

$user_id = $_SESSION["user_id"]; // Ensure user is authenticated

$roomId = rand(10000, 99999);

// Insert the game into the database
$sql = "INSERT INTO games (game_id, status, player1_id) VALUES ($roomId, 'waiting', $user_id)";
if ($conn->query($sql) === TRUE) {
    $_SESSION["game_id"] = $roomId;

    echo json_encode(["success" => true, "gameId" => $roomId]);
} else {
    echo json_encode(["error" => "Error creating game"]);
}
?>
