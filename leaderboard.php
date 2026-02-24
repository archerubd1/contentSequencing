<?php 
date_default_timezone_set('Asia/Kolkata');
session_start();
include 'config/db.php'; // Ensure this file has your correct DB connection

// Fetch all users from the database
$query = "SELECT username, email, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Astraal | Global Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%); 
            color: white; font-family: 'Inter', sans-serif; min-height: 100vh; padding: 50px;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1); border-radius: 30px;
            padding: 40px; box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .table { color: white; border-color: rgba(255,255,255,0.1); }
        .user-row:hover { background: rgba(0, 210, 255, 0.1); transition: 0.3s; }
        .rank-badge { background: #00d2ff; color: #0f172a; font-weight: bold; border-radius: 8px; padding: 5px 12px; }
    </style>
</head>
<body>
    <div class="container glass-panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class='bx bxs-trophy text-warning'></i> Neural <span class="text-info">Leaderboard</span></h2>
            <a href="dashboard.php" class="btn btn-outline-info btn-sm">Back to Dashboard</a>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Learner Name</th>
                    <th>Neural Identity (Email)</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                while($row = mysqli_fetch_assoc($result)): ?>
                <tr class="user-row">
                    <td><span class="rank-badge">#<?php echo $rank++; ?></span></td>
                    <td class="fw-bold text-info"><?php echo htmlspecialchars($row['username']); ?></td>
                    <td class="text-white-50"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td class="small"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>