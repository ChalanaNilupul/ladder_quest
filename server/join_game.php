<?php
session_start();
include "DB_Connect.php";

$user_id = $_SESSION["user_id"];
$roomId = $_POST["gameId"];

$result = $conn->query("SELECT * FROM games WHERE game_id = $roomId");

if ($result->num_rows > 0) {
    $game = $result->fetch_assoc();

    if ($game['status'] === 'waiting') {
        // Add Player 2
        $conn->query("UPDATE games SET status = 'started', player2_id = $user_id WHERE game_id = $roomId");

        $_SESSION["game_id"] = $roomId;
        echo json_encode(["success" => true, "gameId" => $roomId]);
    } else {
        echo json_encode(["error" => "Room is full or already started"]);
    }
} else {
    echo json_encode(["error" => "Room not found"]);
}
?>
