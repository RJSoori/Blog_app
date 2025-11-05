<?php
session_start();
include 'db.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);


?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="home.php">Home</a>
        <a href="create.php">Create Post</a>
        <a href="index.php" class="active">My Posts</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <h3>Your Posts</h3>
        <hr>

        <div class="posts-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="post fade-in">

                        <h3>
                            <a href="view_post.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
                        </h3>
                        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                        <div class="post-footer">
                            <a href="view_post.php?id=<?= $row['id'] ?>" class="read-more">Read More</a><br>
                            <small>Posted on <?= $row['created_at'] ?></small><br><br>
                            <div class="actions">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this post?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You haven't created any posts yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Fade-in animation
        const fadeElements = document.querySelectorAll(".fade-in");
        const appearOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
        const appearOnScroll = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add("visible");
                observer.unobserve(entry.target);
            });
        }, appearOptions);
        fadeElements.forEach(el => appearOnScroll.observe(el));

    });
</script>
</body>
</html>