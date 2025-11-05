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

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {

        // Prepared statement to prevent SQL errors and injection
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            header("Location: home.php"); // Redirect to home to see all posts
            exit;
        } else {
            $message = "Error creating post: " . $stmt->error;
        }

        $stmt->close();

    } else {
        $message = "Title and content cannot be empty.";
    }

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
    <div class="sidebar">
        <h2>MyBlog</h2>
        <a href="home.php">Home</a>
        <a href="create.php" class="active">Create Post</a>
        <a href="index.php">My Posts</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h2>Create New Post</h2>
        <form method="POST" class="form-box">
            <input type="text" name="title" placeholder="Post Title" required>

            <textarea name="content" rows="15" placeholder="Post Content" required></textarea>

            <button type="submit">Publish</button>
        </form>

        <?php if (!empty($message)) { ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php } ?>
    </div>
</div>
</body>
</html>