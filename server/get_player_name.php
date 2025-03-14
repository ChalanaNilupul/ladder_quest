<?php
include "./DB_Connect.php"; 

if (isset($_GET['player1_id']) && isset($_GET['player2_id'])) {
    $player1Id = $_GET['player1_id'];
    $player2Id = $_GET['player2_id'];

    $stmt = $conn->prepare("SELECT id, username FROM players WHERE id IN (?, ?)");
    $stmt->bind_param("ss", $player1Id, $player2Id);
    $stmt->execute();
    $result = $stmt->get_result();

    $players = [];
    while ($row = $result->fetch_assoc()) {
        $players[$row['id']] = $row['username'];
    }

    echo json_encode($players);

    $stmt->close();
    $conn->close();
}
?>
