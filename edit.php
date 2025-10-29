<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get post ID and user ID
$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$id' AND user_id='$user_id'");
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("Post not found or unauthorized access.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id='$id' AND user_id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        $message = "Error updating post: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
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
        <h2>Edit Post</h2>
        <form method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Post Title" required>
            <textarea name="content" rows="8" placeholder="Post Content" required><?= htmlspecialchars($post['content']) ?></textarea>
            <button type="submit">Update</button>
        </form>
        <?php if (!empty($message)) { ?>
            <p class="message"><?= $message ?></p>
        <?php } ?>
    </div>
</div>
</body>
</html>


