<?php
$conn = new mysqli("localhost", "root", "root", "astraal_lxp");

if ($conn->connect_error) {
    die("Failed: " . $conn->connect_error);
}

echo "Connected successfully!";
?>