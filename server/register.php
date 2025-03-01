<?php
include "./DB_Connect.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $score = 0;
    $image = '../images/profile.png';

    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM players WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Email already registered!";
        exit;
    }
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO players (username, email, password, score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $score);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Registration failed!";
    }
    $stmt->close();
    $conn->close();
}
?>
