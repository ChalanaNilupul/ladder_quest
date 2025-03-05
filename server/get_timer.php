<?php
session_start();
include "./DB_Connect.php";

header('Content-Type: application/json'); // Ensure JSON response

if (!isset($_GET['game_id']) || empty($_GET['game_id'])) {
    echo json_encode(["error" => "Game ID is required"]);
    exit;
}

$game_id = intval($_GET['game_id']); // Ensure game_id is an integer

// Check if the countdown has reached zero and update start_time if necessary
$sqlCheck = "SELECT start_time FROM game_timer WHERE game_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("i", $game_id);
$stmtCheck->execute();
$stmtCheck->store_result();

if ($stmtCheck->num_rows > 0) {
    $stmtCheck->bind_result($start_time);
    $stmtCheck->fetch();

    $current_time = time(); 
    if ($current_time - $start_time >= 15) {
        // Update start_time to current time
        $sqlUpdate = "UPDATE game_timer SET start_time = ? WHERE game_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $current_time, $game_id);
        $stmtUpdate->execute();
        
        // Fetch the updated start_time
        $stmtCheck->close();
        $stmtUpdate->close();
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $game_id);
        $stmtCheck->execute();
        $stmtCheck->store_result();
        $stmtCheck->bind_result($start_time);
        $stmtCheck->fetch();
    }

    $time_left = max(0, 15 - ($current_time - $start_time)); // 15-second countdown

    $response = [
        "time_left" => $time_left
    ];

    echo json_encode($response);
} else {
    echo json_encode(["error" => "Game not found"]);
}

$stmtCheck->close();
$conn->close();
?>
