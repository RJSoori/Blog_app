<?php
// Include the database connection file
include 'db.php';

// Check if the database connection ($conn) was successful
if ($conn) {
    // Connection is successful
    echo "Connection successful!";
} else {
    // Connection failed, display the error message
    echo "Connection failed: " . mysqli_connect_error();
}
?>

