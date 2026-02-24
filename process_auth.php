<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "astraal_lxp");

if (isset($_POST['signup'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "INSERT INTO users (username, email) VALUES ('$username', '$email')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_name'] = $username;
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>