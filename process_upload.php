<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "astraal_lxp");

if (isset($_POST['signup'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);

    // Check/Insert User
    $conn->query("INSERT INTO users (username, email) VALUES ('$username', '$email') ON DUPLICATE KEY UPDATE username='$username'");
    
    $_SESSION['user_name'] = $username;
    $user_id = $conn->insert_id;

    // TRIGGER PCSE ENGINE (Python CLI)
    // In a real hosting environment, this reorders the MySQL table for this specific user
    exec("python3 /path/to/content_sequencer.py $user_id 1");

    header("Location: dashboard.php");
}
?>