<?php
session_start();
include "./DB_Connect.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Fetch user from database
    $stmt = $conn->prepare("SELECT id, password FROM players WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            echo "success";
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "Invalid credentials!";
    }
    $stmt->close();
    $conn->close();
}
?>
