<?php
session_start();
include "./DB_Connect.php";

$start_time = time(); // Get current Unix timestamp

$sql = "INSERT INTO game_timer (start_time) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $start_time);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "game_id" => $conn->insert_id, "start_time" => $start_time]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$stmt->close();
$conn->close();
?>
