<?php
session_start();
include "./DB_Connect.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $google_id = trim($_POST['google_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Validate the input data
    if (empty($google_id) || empty($email)) {
        echo json_encode(["success" => false, "message" => "Google authentication failed!"]);
        exit;
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM players WHERE email = ? OR google_id = ?");
    $stmt->bind_param("ss", $email, $google_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
       
        $stmt->bind_result($id);
        $stmt->fetch();
        $_SESSION['user_id'] = $id;
        echo json_encode(["success" => true, "player_id" => $_SESSION['user_id']]);
    } else {
        
        $insertQuery = "INSERT INTO players (google_id, username, email, score) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $score = 0;
        $insertStmt->bind_param("sssi", $google_id, $name, $email, $score);

        if ($insertStmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            echo json_encode(["success" => true, "player_id" => $_SESSION['user_id']]);
        } else {
            
            echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
        }
    }

    $stmt->close();
    $conn->close();
}
?>
