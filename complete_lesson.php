<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "astraal_lxp");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lesson = $_POST['lesson_name'];
    $user_id = $_SESSION['user']['id'];

    // This records that the student finished the lesson (The "Reward" for the AI)
    $sql = "INSERT INTO learner_content_activity (user_id, content_id, status) 
            VALUES ('$user_id', (SELECT id FROM content_units WHERE unit_name='$lesson'), 'completed')";
    
    if ($conn->query($sql)) {
        header("Location: dashboard.php?status=success");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>