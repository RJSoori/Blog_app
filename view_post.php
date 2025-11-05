<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//Validate the ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}
$post_id = intval($_GET['id']);

// We JOIN with the users table to get the author's username
$stmt = $conn->prepare("SELECT posts.*, users.username 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        WHERE posts.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

//Check if the post exists
if (!$post) {
    die("Post not found.");
}

// Check the 'HTTP_REFERER' to see which page the user came from.
$back_link = 'home.php'; // Default to home.php
$back_text = 'Back to Home';

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer_page = basename($_SERVER['HTTP_REFERER']); // Gets just the filename, e.g., "index.php"

    if ($referer_page == 'index.php') {
        $back_link = 'index.php';
        $back_text = 'Back to My Posts';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="home.php">Home</a>
        <a href="create.php">Create Post</a>
        <a href="index.php">My Posts</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <div class="post-full-view">
            <h2><?= htmlspecialchars($post['title']) ?></h2>

            <div class="post-meta">
                By <b><?= htmlspecialchars($post['username']) ?></b> <br>
                Posted on: <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?> <br>
                Last updated: <?= date('F j, Y, g:i a', strtotime($post['updated_at'])) ?>
            </div>

            <hr>

            <div class="post-full-content">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>

            <br>
            <a href="<?= htmlspecialchars($back_link) ?>" class="btn">&larr; <?= htmlspecialchars($back_text) ?></a>
        </div>
    </div>
</div>
</body>
</html>