<?php
include 'db.php';

$message = '';
$is_success = false; // To control the message styling

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validate and trim inputs (Server-Side Validation)
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    }
    else {
        // 2. Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 3. Use a Prepared Statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // --- START OF FIX: Replace if/else with try/catch ---

        // 4. Try to execute, and Catch the error if it fails
        try {
            // This is line 25 (or around there)
            $stmt->execute();

            // If we get to this line, it worked!
            $message = "Registration successful. <a href='login.php'>Login here</a>";
            $is_success = true;

        } catch (mysqli_sql_exception $e) {
            // We caught the ugly error! Now, let's make it nice.
            // Check if the error code is 1062 (Duplicate entry)
            if ($e->getCode() == 1062) {
                $message = "Username or email already taken.";
            } else {
                // It was some other database error
                $message = "Registration failed. Please try again later.";
                // Log the real, ugly error for your eyes only, not for the user
                error_log("SQL Error: " . $e->getMessage());
            }
        }
        // --- END OF FIX ---

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add a style for the success message */
        .message.success {
            color: #28a745; /* A nice green */
        }
    </style>
</head>
<body class="auth-page"> <div class="auth-container">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Register</button>
    </form>

    <?php if (!empty($message)) { ?>
        <?php if ($is_success): ?>
            <p class="message success"><?= $message ?></p>
        <?php else: ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    <?php } ?>

    <p class="signup-text">Already have an account?</p>
    <a href="login.php" class="btn register-btn">Login Here</a>
</div>
</body>
</html>