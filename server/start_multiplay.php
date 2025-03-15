<?php
session_start();
include "DB_Connect.php";

$gameId = $_POST["gameId"] ?? null;

if (!$gameId) {
    echo json_encode(["error" => "Game ID is required"]);
    exit;
}

// Get game details
$sql = "SELECT player1_id, player2_id, status FROM games WHERE game_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gameId);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    echo json_encode(["error" => "Game not found"]);
    exit;
}

// Check if Player 2 has joined
if (!empty($game["player2_id"])) {
    
    $checkGameState = $conn->prepare("SELECT * FROM game_state WHERE game_id = ?");
    $checkGameState->bind_param("i", $gameId);
    $checkGameState->execute();
    $stateResult = $checkGameState->get_result();

    if ($stateResult->num_rows === 0) {
        $insertGameState = $conn->prepare("INSERT INTO game_state (game_id, player1_pos, player2_pos, current_turn, started) VALUES (?, 1, 1, ?, 1)");
        $insertGameState->bind_param("ii", $gameId, $game["player1_id"]);
        $insertGameState->execute();
    }

    echo json_encode(["started" => true, "player1_id" => $game["player1_id"], "player2_id" => $game["player2_id"]]);
} else {
    echo json_encode(["started" => false]);
}
?>
