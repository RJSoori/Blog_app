<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all posts (from all users)
$result = mysqli_query($conn, "SELECT posts.*, users.username FROM posts 
                               JOIN users ON posts.user_id = users.id 
                               ORDER BY posts.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Blog App</title>
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
        .post h3 {
            margin-top: 0;
        }
        .actions a {
            margin-right: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
<a href="create.php">Create New Post</a> |
<a href="index.php">My Posts</a> |
<a href="logout.php">Logout</a>
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

</body>
</html>

