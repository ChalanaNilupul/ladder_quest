<?php
include "./DB_Connect.php"; 

$gameId = $_GET['gameId'];

$query = "SELECT player1_pos, player2_pos FROM game_state WHERE game_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $gameId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Game not found"]);
}

$stmt->close();
$conn->close();
?>
