<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // Prepared statement to prevent SQL errors and injection
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        header("Location: home.php");
        exit;
    } else {
        $message = "Error creating post: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="home.php">Home</a>
        <a href="create.php" class="active">Create Post</a>
        <a href="index.php">My Posts</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h2>Create New Post</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Post Title" required>
            <textarea name="content" rows="8" placeholder="Post Content" required></textarea>
            <button type="submit">Publish</button>
        </form>
        <?php if (!empty($message)) { ?>
            <p class="message"><?= $message ?></p>
        <?php } ?>
    </div>
</div>
</body>
</html>
