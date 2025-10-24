<?php
include 'db.php';
session_start();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 60px;
            background-color: #f5f5f5;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
        }
        button {
            padding: 10px 15px;
            background-color: #0066cc;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0052a3;
        }
        .register-btn {
            background-color: #28a745;
            margin-top: 10px;
        }
        .register-btn:hover {
            background-color: #218838;
        }
        .message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h2>User Login</h2>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

<p class="message"><?= $message ?></p>

<form action="register.php" method="get">
    <button type="submit" class="register-btn">Create an Account</button>
</form>

</body>
</html>


