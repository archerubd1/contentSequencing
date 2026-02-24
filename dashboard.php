<?php
session_start();
try {
    // Database connection
    $conn = new PDO("mysql:host=localhost;dbname=astraal_lxp", "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// User Identification
$user_id = 1;
$display_name = "divyaruge"; 

// Dynamic Maturity Score Logic
// Checks if any lessons have cloud URLs to set progress
try {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM content_units WHERE file_url IS NOT NULL");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    // If we have uploaded content to Cloudinary, show 45% maturity
    $maturity = ($count > 0) ? 45 : 0; 
} catch (Exception $e) { 
    $maturity = 0; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Astraal | Command Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root { --primary: #3b82f6; --neon-blue: #00d2ff; --bg: #020617; }
        body { background: var(--bg); color: #f8fafc; font-family: 'JetBrains Mono', monospace; }
        
        .sidebar { width: 240px; height: 100vh; position: fixed; background: #000; border-right: 1px solid #1e293b; padding: 40px 25px; }
        .main-content { margin-left: 240px; padding: 60px; }

        .node-card { 
            background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(59, 130, 246, 0.4); 
            border-radius: 12px; padding: 30px; margin-bottom: 25px; position: relative;
            transition: 0.3s;
        }
        .node-card:hover { border-color: var(--primary); background: rgba(30, 41, 59, 0.8); }
        
        .text-label { color: #94a3b8 !important; font-weight: bold; font-size: 11px; letter-spacing: 1px; }
        .text-data { color: var(--neon-blue) !important; font-weight: bold; }

        .rank-badge { 
            position: absolute; right: 20px; top: -10px; font-size: 10px; 
            color: #fff; background: var(--primary); font-weight: bold; 
            padding: 4px 12px; border-radius: 4px; box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }
        
        .analytics-card { background: rgba(15, 23, 42, 0.9); border: 1px solid #334155; border-radius: 15px; padding: 25px; }
        .bar-container { display: flex; align-items: flex-end; justify-content: space-between; height: 130px; margin-bottom: 10px; border-bottom: 1px solid #475569; }
        .bar { width: 14px; background: #1e293b; border-radius: 4px; }
        .bar-blue { background: var(--primary); box-shadow: 0 0 15px var(--primary); }
        .bar-green { background: #10b981; box-shadow: 0 0 15px #10b981; }

        .btn-recalibrate { 
            width: 100%; background: transparent; border: 1px dashed var(--primary); 
            color: var(--primary); padding: 12px; border-radius: 8px; font-size: 11px; 
            letter-spacing: 2px; text-transform: uppercase; transition: 0.3s; font-weight: bold;
        }
        
        .btn-primary { background: var(--primary); border: none; transition: 0.3s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4); }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <h3 class="fw-bold text-white mb-5">ASTRAAL</h3>
    <nav class="nav flex-column gap-4">
        <a href="#" class="text-white text-decoration-none small"><i class='bx bxs-zap me-2 text-primary'></i> PCSE ENGINE</a>
        <a href="upload_content.php" class="text-white-50 text-decoration-none small"><i class='bx bxs-cloud-upload me-2'></i> CLOUD ASSETS</a>
        <a href="#" class="text-white-50 text-decoration-none small"><i class='bx bxs-bar-chart-alt-2 me-2'></i> LEADERBOARD</a>
    </nav>
    
    <div class="mt-auto mb-4">
        <a href="logout.php" class="text-white-50 text-decoration-none small opacity-50" style="letter-spacing: 2px;">
            <i class='bx bx-power-off me-2'></i> EXIT
        </a>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
       <div>
            <h1 class="fw-bold text-white">Hey <span class="text-primary"><?php echo $display_name; ?></span></h1>
            <p class="text-success small mb-0 fw-bold"><i class='bx bxs-circle me-1'></i> ML SEQUENCE OPTIMIZED</p>
        </div>
        <div class="text-end">
            <small class="text-label text-uppercase">Maturity</small>
            <h2 class="text-primary fw-bold"><?php echo $maturity; ?>%</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <h6 class="text-label mb-4">OPTIMIZED SEQUENCE</h6>
            <?php
            // Pulling rank and content from the dynamic sequencing engine
            $stmt = $conn->prepare("SELECT cu.* FROM personalized_sequence ps JOIN content_units cu ON ps.unit_id = cu.unit_id WHERE ps.learner_id = ? ORDER BY ps.rank_position ASC");
            $stmt->execute([$user_id]);
            $units = $stmt->fetchAll();

            if($units):
                foreach($units as $i => $u): ?>
                
                <div class="node-card">
                    <?php if($i == 0): ?><span class="rank-badge">RANK #1</span><?php endif; ?>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-1">
                                0<?php echo $i+1; ?>. <?php echo htmlspecialchars($u['unit_title']); ?>
                            </h4>
                            <div class="d-flex gap-3">
                                <span class="text-label">DIFF: <span class="text-data"><?php echo $u['difficulty_level']; ?></span></span>
                                <span class="text-label">GAP: <span class="text-data">0.8</span></span>
                            </div>
                        </div>
                        
                        <a href="lesson.php?id=<?php echo $u['unit_id']; ?>" class="btn btn-primary btn-sm px-4 fw-bold shadow">
                            START LESSON
                        </a>
                    </div>
                </div>

            <?php endforeach; else: ?>
                <div class="node-card"><p class="text-white">Awaiting system sync...</p></div>
            <?php endif; ?>
        </div>

        <div class="col-md-5">
            <h6 class="text-label mb-4">SYSTEM ANALYTICS</h6>
            <div class="analytics-card">
                <h6 class="text-white small mb-4">NEURAL GROWTH MAP</h6>
                <div class="bar-container">
                    <div class="bar" style="height: 35%;"></div>
                    <div class="bar bar-blue" style="height: 65%;"></div>
                    <div class="bar" style="height: 25%;"></div>
                    <div class="bar bar-blue" style="height: 85%;"></div>
                    <div class="bar bar-green" style="height: 95%;"></div>
                    <div class="bar bar-green" style="height: 75%;"></div>
                </div>
                <div class="d-flex justify-content-between px-1 text-label" style="font-size: 10px;">
                    <span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SUN</span>
                </div>
                
               <div class="mt-5">
                    <a href="recalibrate.php" style="text-decoration:none;">
                        <button class="btn-recalibrate">Recalibrate Engine</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>