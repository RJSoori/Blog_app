<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all posts from all users
$result = mysqli_query($conn, "SELECT posts.*, users.username FROM posts 
                               JOIN users ON posts.user_id = users.id 
                               ORDER BY posts.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Blog App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="home.php">Home</a>
        <a href="index.php">My Posts</a>
        <a href="create.php">Create Post</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <hr>
        <h3>All Blog Posts</h3>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="post">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <small>By <b><?= htmlspecialchars($row['username']) ?></b> on <?= $row['created_at'] ?></small><br><br>

                    <?php if ($_SESSION['user_id'] == $row['user_id']) { ?>
                        <div class="actions">
                            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No posts available yet.</p>
        <?php } ?>
    </div>
</div>
</body>
</html>


