<!DOCTYPE html>
<html>
<head>
    <title>Astraal | Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; }
        .login-box { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); padding: 40px; border-radius: 20px; width: 380px; text-align: center; }
        .form-control { background: #1e293b; border: none; color: white; border-radius: 10px; margin-bottom: 15px; }
        .btn-primary { background: #00d2ff; border: none; font-weight: bold; width: 100%; border-radius: 10px; padding: 10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3 class="mb-4 text-info">Astraal Login</h3>
        <form action="process_auth.php" method="POST">
            <input type="text" name="username" class="form-control" placeholder="Your Name" required>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            <button type="submit" name="signup" class="btn btn-primary">Enter Dashboard</button>
        </form>
    </div>
</body>
</html>