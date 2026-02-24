<?php
// Fix: Use the correct database name from your phpMyAdmin
$conn = new mysqli("localhost", "root", "root", "astraal_lxp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Safer way to get the module_id without using '??'
$module_id = isset($_GET['module_id']) ? $_GET['module_id'] : 1;

echo "<div style='background: #0f172a; color: #00d2ff; padding: 50px; text-align: center; font-family: sans-serif; min-height: 100vh;'>
        <h1 style='font-size: 3rem;'>🎉 Success!</h1>
        <p style='font-size: 1.5rem; color: #f8fafc;'>Module $module_id has been recorded as complete.</p>
        <br>
        <a href='dashboard.php' style='color: white; text-decoration: none; border: 2px solid #00d2ff; padding: 15px 30px; border-radius: 12px; font-weight: bold;'>Return to Dashboard</a>
      </div>";

$conn->close();
?>