<?php
include "DB_Connect.php";

$gameId = $_POST["gameId"];
$player = $_POST["player"]; // Player ID who played

if (!$gameId || !$player) {
    echo json_encode(["error" => "Missing game ID or player ID"]);
    exit;
}

// Update the current turn in game_state
$sql = "UPDATE game_state SET current_turn = ? WHERE game_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $player, $gameId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update turn"]);
}
?>
