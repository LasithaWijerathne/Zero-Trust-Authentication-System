<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_agent = $_SESSION['os_device'];
$os = "Unknown OS";

if (preg_match('/windows/i', $user_agent)) { $os = "Windows"; }
elseif (preg_match('/mac/i', $user_agent)) { $os = "Mac OS"; }
elseif (preg_match('/linux/i', $user_agent)) { $os = "Linux"; }
elseif (preg_match('/android/i', $user_agent)) { $os = "Android"; }
elseif (preg_match('/iphone|ipad/i', $user_agent)) { $os = "iOS"; }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Security Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #2c3e50; padding: 50px; color: white; display: flex; justify-content: center; }
        .card { background: #34495e; padding: 30px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.5); width: 100%; max-width: 500px; }
        h2 { border-bottom: 2px solid #1abc9c; padding-bottom: 10px; margin-top: 0; }
        .data-box { background: #16a085; padding: 15px; border-radius: 5px; margin-top: 15px; color: #fff; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .data-box.raw-data { background: #2980b9; font-size: 13px; font-family: monospace; word-wrap: break-word; }
        .btn { display: block; width: 100%; padding: 12px; background: #e74c3c; color: white; text-align: center; text-decoration: none; border-radius: 5px; margin-top: 25px; box-sizing: border-box; font-weight: bold; transition: 0.3s; }
        .btn:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Welcome, <?php echo strtoupper($_SESSION['username']); ?>!</h2>
        <p>Your identity has been verified. Access Granted.</p>
        
        <div class="data-box">
            <b>📍 Your IP Address:</b> <br>
            <?php echo $_SESSION['ip']; ?>
        </div>

        <div class="data-box">
            <b>💻 Operating System (OS):</b> <br>
            <?php echo $os; ?>
        </div>

        <div class="data-box raw-data">
            <b>🔍 Full Device/Browser Info (Raw Data):</b> <br>
            <?php echo $user_agent; ?>
        </div>

        <a href="logout.php" class="btn">Secure Logout</a>
    </div>
</body>
</html>