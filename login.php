<?php

$conn = new mysqli("localhost", "root", "", "zero_trust_auth");

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { return $_SERVER['HTTP_CLIENT_IP']; }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { return $_SERVER['HTTP_X_FORWARDED_FOR']; }
    else { return $_SERVER['REMOTE_ADDR']; }
}

$current_ip = getUserIP();
$current_device = $_SERVER['HTTP_USER_AGENT'];


$check = $conn->query("SELECT * FROM users WHERE username='lasitha'");
if($check->num_rows == 0) {
    $hashed = password_hash("12345", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, email, password_hash, trusted_ip, trusted_device) 
                  VALUES ('lasitha', 'lasitha@test.com', '$hashed', '$current_ip', '$current_device')");
}

$message = "";
$message_color = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($row = $result->fetch_assoc()) {
        
        
        if (password_verify($password, $row['password_hash'])) {
            
          
            if ($row['trusted_ip'] == $current_ip && $row['trusted_device'] == $current_device) {
                
                
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['ip'] = $current_ip;
                $_SESSION['os_device'] = $current_device; 
                
                header("Location: dashboard.php");
                exit();

} else {
    
    $message = "Zero-Trust Alert: Access Denied!";
    $message_color = "#e74c3c";
}
    }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zero-Trust Authentication</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .login-box h2 { color: #2c3e50; margin-bottom: 20px; }
        input[type="text"], input[type="password"] { width: 90%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        input[type="submit"] { width: 100%; padding: 12px; background: #34495e; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px; transition: 0.3s; }
        input[type="submit"]:hover { background: #2c3e50; }
        .message { margin-top: 20px; padding: 15px; border-radius: 5px; color: white; font-weight: bold; font-size: 14px; }
        .context-info { margin-top: 30px; font-size: 12px; color: #7f8c8d; text-align: left; background: #ecf0f1; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Secure Login System</h2>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username (Try: lasitha)" required>
            <input type="password" name="password" placeholder="Password (Try: 12345)" required>
            <input type="submit" value="Login">
        </form>

        <?php if($message != ""): ?>
            <div class="message" style="background-color: <?php echo $message_color; ?>;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="context-info">
            <b>Current Context (For Debugging):</b><br>
            IP: <?php echo $current_ip; ?><br>
            Device: <?php echo substr($current_device, 0, 40); ?>...
        </div>
    </div>

</body>
</html>