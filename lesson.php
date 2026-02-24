<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Astraal | Neural Evaluation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { background: #020617; color: #f8fafc; font-family: 'JetBrains Mono', monospace; padding: 40px; }
        
        /* EXIT PRO MAX BUTTON STYLING */
        .btn-exit-pro-max {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: rgba(239, 68, 68, 0.1); 
            border: 2px solid #ef4444;
            color: #ef4444;
            text-decoration: none;
            border-radius: 50px; /* Capsule shape */
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: 0.3s;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);
            margin-bottom: 30px;
        }

        .btn-exit-pro-max:hover {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.6);
            transform: translateY(-2px);
        }

        .eval-container { max-width: 900px; margin-left: 280px; }
        .sidebar-nodes { width: 240px; position: fixed; left: 40px; top: 100px; }
        /* ... keep your existing lesson styles here ... */
    </style>
</head>
<body>

   <a href="dashboard.php" class="btn-exit-pro-max">
    <i class='bx bx-left-arrow-alt me-2'></i> EXIT
</a>

    <div class="sidebar-nodes">
        <h6 class="text-primary fw-bold mb-4">NEURAL NODES</h6>
        <div class="mb-3 text-white-50 small"><i class='bx bx-check-circle me-2'></i> 01. Overview</div>
        <div class="mb-3 text-white small fw-bold"><i class='bx bx-radio-circle-marked me-2 text-primary'></i> 02. Core Architecture</div>
    </div>

    <div class="eval-container">
        <span class="badge bg-primary mb-3">NODE 02</span>
        <h1 class="fw-bold mb-2">Neural Core Architecture</h1>
        <p class="text-info small mb-5">Estimated Time: 5 Minutes</p>

        <div class="p-5 rounded-4" style="background: rgba(30, 41, 59, 0.4); border: 1px solid #1e293b;">
            <h3 class="fw-bold mb-4">Understanding the PCSE Layer</h3>
            <p class="text-white-50">The Personal Cognitive Sequence Engine (PCSE) works by mapping your learning speed against the complexity of the unit. Think of it like a GPS for your brain.</p>
            
            <div class="p-3 mb-5 rounded" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981;">
                <small class="text-success fw-bold"><i class='bx bxs-zap me-1'></i> Pro Tip:</small>
                <small class="text-white">Always focus on the Rank #1 unit.</small>
            </div>

            <h5 class="text-primary mb-4"><i class='bx bx-pulse me-2'></i> Neural Evaluation</h5>
            <div class="d-grid gap-3">
                <button class="btn btn-outline-secondary text-start p-3 text-white" style="border-color: #334155;">A. Dynamic Weight Re-routing</button>
                <button class="btn btn-outline-secondary text-start p-3 text-white" style="border-color: #334155;">B. Static Data Archiving</button>
            </div>
        </div>
    </div>

</body>
=======
<?php
session_start();
// Points to your database connection file
include('config/db.php');

if (!isset($_SESSION['user'])) { 
    header("Location: index.php"); 
    exit(); 
}

// 1. Get the dynamic file path from the dashboard link
// Using isset() instead of ?? for PHP 5.6 compatibility
$file_path = isset($_GET['file']) ? $_GET['file'] : 'default.pdf';
$lesson_name = isset($_GET['name']) ? $_GET['name'] : 'Adaptive Module';

echo $file_path; 
//die();


// Check if it's a video or PDF
$is_video = (strpos($file_path, '.mp4') !== false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Learning Mode | Astraal LXP</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
    body { background: #0b0e14; color: #ffffff; }
    .content-area { background: #161c24; border-radius: 15px; border: 1px solid #334155; padding: 30px; }
    .ai-note { border-left: 4px solid #38bdf8; background: rgba(56, 189, 248, 0.1); padding: 15px; border-radius: 0 10px 10px 0; }
</style></head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="dashboard.php" class="text-info text-decoration-none"><i class="fas fa-arrow-left me-2"></i> Exit to Dashboard</a>
            <span class="badge bg-primary px-3 py-2">Module 01: Basics</span>
        </div>

        <div class="content-area p-5 shadow-lg">
            <h1 class="display-5 fw-bold text-white mb-4"><?php echo htmlspecialchars($lesson_name); ?></h1>
            
            <div class="ai-note mb-4">
                <p class="mb-0 small text-info"><i class="fas fa-robot me-2"></i> <strong>AI INSIGHT:</strong> This content was prioritized based on your previous performance and the Reinforcement Learning difficulty curve.</p>
            </div>

            <div class="text-muted lead" style="line-height: 1.8;">
                <p>Welcome to the module on <strong><?php echo htmlspecialchars($lesson_name); ?></strong>. Here you will explore the foundational concepts and practical applications required to master this topic.</p>
                <p>Ensure you review the diagrams and summary notes before proceeding to the next automated sequence.</p>
            </div>

            <hr class="my-5 border-secondary">
            <div class="row justify-content-center mb-5">
    <div class="col-lg-12">
        <div class="glass-card p-3" style="background: rgba(0,0,0,0.6); border: 1px solid #334155; border-radius: 20px;">
            <?php if ($is_video): ?>
                <video width="100%" controls autoplay style="border-radius: 15px; box-shadow: 0 0 20px rgba(56, 189, 248, 0.2);">
                    <source src="assets/content/<?php echo htmlspecialchars($file_path); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php else: ?>
                <embed src="<?php echo htmlspecialchars($file_path); ?>" width="100%" height="700px" type="application/pdf" style="border-radius: 15px;">
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="text-center mt-5">
    <form action="complete_action.php" method="POST">
        <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($file_path); ?>">
        
        <button type="submit" class="btn btn-success btn-lg px-5 py-3 fw-bold shadow-lg" style="border-radius: 50px;">
            <i class="fas fa-check-circle me-2"></i> COMPLETE MODULE & EARN REWARDS
        </button>
    </form>
    <p class="mt-3 text-muted small">
        <i class="fas fa-info-circle me-1"></i> By completing this, you provide a positive reward signal to the RL Agent.
    </p>
</div>
            <div class="text-center">
                <form action="complete_action.php" method="POST">
                    <input type="hidden" name="lesson_name" value="<?php echo htmlspecialchars($lesson_name); ?>">
                    <button type="submit" class="btn btn-success btn-lg px-5 py-3 fw-bold shadow">
                        <i class="fas fa-check-circle me-2"></i> COMPLETE MODULE
                    </button>
                </form>
                <p class="mt-3 text-muted small">By completing, you provide a positive reward signal to the RL Agent.</p>
            </div>
        </div>
    </div>
</body>
>>>>>>> 4c89be5d7f64af762e10ac103644f3e01cf35e34
</html>