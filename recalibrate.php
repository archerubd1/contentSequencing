<?php
session_start();

// 1. Identify the user
$user_id = 1; 

// 2. Trigger the AI Sequencer using your verified Python 313 path
// We use double backslashes for Windows path compatibility
$python_path = "C:\\Users\\Vedika\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
$script_path = "sequencer.py";

exec("$python_path $script_path $user_id");

// 3. Redirect back to the dashboard immediately after the AI finishes
header("Location: dashboard.php");
exit();
?>