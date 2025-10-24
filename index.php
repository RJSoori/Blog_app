<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM posts WHERE user_id='$user_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        a {
            text-decoration: none;
            color: #0066cc;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .post {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
<a href="create.php">Create New Post</a> |
<a href="home.php">Home</a> |
<a href="logout.php">Logout</a>
<hr>

<h3>Your Posts</h3>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="post">
        <h4><?= htmlspecialchars($row['title']) ?></h4>
        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
        <small>Posted on: <?= $row['created_at'] ?></small><br>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
    </div>
<?php } ?>

</body>
</html>
