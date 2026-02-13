<?php
include("../config/db.php");

$learner_id = 1;
$course_id = $_GET['course_id'];

$result = $conn->prepare("
SELECT cu.unit_title
FROM personalized_sequence ps
JOIN content_units cu ON ps.unit_id = cu.unit_id
WHERE ps.learner_id=? AND ps.course_id=?
ORDER BY ps.rank_position
");

$result->bind_param("ii", $learner_id, $course_id);
$result->execute();
$data = $result->get_result();
?>

<h2>Personalized Course Order</h2>

<a href="trigger_sequence.php?course_id=<?php echo $course_id; ?>">
<button>Recalculate Sequence</button></a>

<ul>
<?php while($row=$data->fetch_assoc()): ?>
<li><?php echo htmlspecialchars($row['unit_title']); ?></li>
<?php endwhile; ?>
</ul>
