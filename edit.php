<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Validate post ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch the post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post not found or unauthorized access.");
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $update_stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $update_stmt->bind_param("ssii", $title, $content, $id, $user_id);

        if ($update_stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $message = "Error updating post.";
        }
    } else {
        $message = "All fields are required.";
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
        <a href="home.php">Home</a>
        <a href="create.php">Create Post</a>
        <a href="index.php">My Posts</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h2>Edit Post</h2>
        <form method="POST" class="form-box">
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Post Title" required>
            <textarea name="content" rows="8" placeholder="Post Content" required><?= htmlspecialchars($post['content']) ?></textarea>
            <button type="submit">Update</button>
        </form>
        <?php if (!empty($message)) { ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php } ?>
    </div>
</div>
</body>
</html>



