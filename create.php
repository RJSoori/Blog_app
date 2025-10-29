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

    $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="index.php">Dashboard</a>
        <a href="create.php">Create Post</a>
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


