<?php

// Start the session to access session variables
session_start();

// Include the database connection file
include 'db.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the post ID
$id = $_GET['id'];

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

mysqli_query($conn, "DELETE FROM posts WHERE id='$id' AND user_id='$user_id'");
header("Location: index.php");
exit;
?>

