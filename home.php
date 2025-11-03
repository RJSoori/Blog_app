<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all posts
$result = mysqli_query($conn, "SELECT posts.*, users.username FROM posts 
                               JOIN users ON posts.user_id = users.id 
                               ORDER BY posts.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Blog App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="home.php" class="active">Home</a>
        <a href="create.php">Create Post</a>
        <a href="index.php">My Posts</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <hr>
        <h3>All Blog Posts</h3>

        <div class="posts-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="post fade-in">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                        <span class="read-more">Read More</span>
                        <small>By <b><?= htmlspecialchars($row['username']) ?></b> on <?= $row['created_at'] ?></small><br><br>

                        <?php if ($_SESSION['user_id'] == $row['user_id']): ?>
                            <div class="actions">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this post?')">Delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-content" id="modalContent">
        <span class="modal-close" id="modalClose">&times;</span>
        <h3 id="modalTitle"></h3>
        <p id="modalBody"></p>
    </div>
</div>

<script>
    // Fade-in animation
    document.addEventListener("DOMContentLoaded", () => {
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

        // Modal functionality for Read More
        const readMoreButtons = document.querySelectorAll(".read-more");
        const modal = document.getElementById("modalOverlay");
        const modalTitle = document.getElementById("modalTitle");
        const modalBody = document.getElementById("modalBody");
        const modalClose = document.getElementById("modalClose");

        readMoreButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                const post = btn.closest(".post");
                modalTitle.textContent = post.querySelector("h3").textContent;
                modalBody.innerHTML = post.querySelector("p").innerHTML;
                modal.classList.add("active");
            });
        });

        modalClose.addEventListener("click", () => {
            modal.classList.remove("active");
        });

        modal.addEventListener("click", e => {
            if (e.target === modal) modal.classList.remove("active");
        });
    });
</script>
</body>
</html>
