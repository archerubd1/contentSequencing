<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "astraal_lxp");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $unit_id = $_POST['unit_id'];
    $user_id = $_SESSION['user_id']; // Ensure you save user_id in session during login

    // 1. Record activity
    $sql = "INSERT INTO learner_content_activity (learner_id, unit_id, completion_status, time_spent) 
            VALUES ('$user_id', '$unit_id', 1, 300) 
            ON DUPLICATE KEY UPDATE completion_status=1";
    
    if ($conn->query($sql)) {
        // 2. TRIGGER PCSE ENGINE RECALIBRATION
        // This runs your Python ML logic to update the personalized_sequence table
        exec("python3 /path/to/content_sequencer.py $user_id 1");

        // 3. Return to dashboard with a success message
        header("Location: dashboard.php?sequence_updated=true");
    }
}
?>