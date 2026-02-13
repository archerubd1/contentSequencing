<?php
include("../config/db.php");

$course_id = $_POST['course_id'];
$mode = $_POST['mode'];
$engagement_weight = $_POST['engagement_weight'];
$rl_enabled = isset($_POST['rl_enabled']) ? 1 : 0;

$stmt = $conn->prepare("
REPLACE INTO sequencing_settings
VALUES (?, ?, ?, ?, NOW())
");

$stmt->bind_param("isdi", $course_id, $mode, $engagement_weight, $rl_enabled);
$stmt->execute();

echo "Settings Saved";
?>
