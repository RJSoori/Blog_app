<?php
session_start();
include 'db.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user's posts
$result = mysqli_query($conn, "SELECT * FROM posts WHERE user_id='$user_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="index.php">Dashboard</a>
        <a href="create.php">Create Post</a>
        <a href="home.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <h3>Your Posts</h3>
        <hr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="post">
                <h4><?= htmlspecialchars($row['title']) ?></h4>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <small>Posted on: <?= $row['created_at'] ?></small><br>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn" onclick="return confirm('Delete this post?')">Delete</a>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>

