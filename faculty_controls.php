<?php
$conn = new PDO("mysql:host=localhost;dbname=astraal_db", "root", "");

// Handle the update form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mode = $_POST['mode'];
    $stmt = $conn->prepare("UPDATE sequencing_settings SET mode = ?, last_updated = NOW() WHERE course_id = 1");
    $stmt->execute([$mode]);
    $msg = "Engine Mode Updated to: " . $mode;
}

// Fetch current setting
$res = $conn->query("SELECT mode FROM sequencing_settings WHERE course_id = 1")->fetch();
$current_mode = $res['mode'] ?? 'Standard';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Astraal Governance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #020617; color: #f8fafc; font-family: 'JetBrains Mono', monospace; padding: 50px; }
        .config-card { background: rgba(30, 41, 59, 0.7); border: 1px solid #334155; border-radius: 15px; padding: 30px; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h2 class="mb-4">Faculty <span class="text-primary">Governance</span></h2>
        
        <?php if(isset($msg)): ?>
            <div class="alert alert-success bg-dark text-success border-success"><?= $msg ?></div>
        <?php endif; ?>

        <div class="config-card">
            <form method="POST">
                <label class="mb-3 text-info">Select Sequencing Engine Mode:</label>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="mode" value="Standard" <?= ($current_mode=='Standard')?'checked':'' ?>>
                    <label class="form-check-label">Standard (Linear 1-2-3)</label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="mode" value="Personalized" <?= ($current_mode=='Personalized')?'checked':'' ?>>
                    <label class="form-check-label">Personalized (PCSE ML-Ranked)</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">APPLY ENGINE SETTINGS</button>
            </form>
        </div>
        <br>
        <a href="dashboard.php" class="text-muted text-decoration-none small">← Return to Dashboard</a>
    </div>
</body>
</html>