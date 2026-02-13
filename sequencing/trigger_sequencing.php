<?php
$learner_id = 1;
$course_id = $_GET['course_id'];

exec("python3 /home/username/python/content_sequencer.py $learner_id $course_id");

header("Location: course_view.php?course_id=$course_id");
?>
