<?php
// Include Composer's autoloader to load external libraries
require __DIR__ . '/vendor/autoload.php';

// Use the Dotenv namespace for environment variable management
use Dotenv\Dotenv;

// Load environment variables from the .env file in the project root
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Establish a connection to the MySQL database using credentials from the .env file
$conn = mysqli_connect(
    $_ENV['DB_HOST'], // Database host
    $_ENV['DB_USER'], // Database username
    $_ENV['DB_PASS'], // Database password
    $_ENV['DB_NAME']  // Database name
);

// Check if the connection failed and terminate the script with an error message
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Connection successful, $conn can now be used for database queries
?>

