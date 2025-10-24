<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$id' AND user_id='$user_id'");
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("Post not found or unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id='$id' AND user_id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating post.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
<h2>Edit Post</h2>
<form method="POST">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>
    Content:<br>
    <textarea name="content" rows="6" cols="50" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>
    <button type="submit">Update</button>
</form>
</body>
</html>

