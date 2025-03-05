<?php
session_start();
include "./DB_Connect.php";

if (!isset($_POST['gameId']) || !isset($_POST['playerKey']) || !isset($_POST['position'])) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$gameId = intval($_POST['gameId']);
$playerKey = $_POST['playerKey']; // "player1_pos" or "player2_pos"
$position = intval($_POST['position']);

$sql = "UPDATE game_state SET $playerKey = ? WHERE game_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $position, $gameId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update position"]);
}

$stmt->close();
$conn->close();
?>
