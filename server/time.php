<?php


session_start();


if (!isset($_SESSION['time_left'])) {
    $_SESSION['time_left'] = 15; 
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $_SESSION['time_left'] -= 1;

    if ($_SESSION['time_left'] <= 0) {
        
        $_SESSION['time_left'] = 15;  
       
    }

    // Return the current time left to the client
    echo json_encode(['time_left' => $_SESSION['time_left']]);
    exit;
}


?>