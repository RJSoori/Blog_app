<?php
// Include Composer's autoloader to load external libraries
require __DIR__ . '/vendor/autoload.php';

// Use the Dotenv namespace for environment variable management
use Dotenv\Dotenv;

// Load environment variables from the .env file in the project root
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Establish a connection to the MySQL database
$conn = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME']
);

// Check if the connection failed
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set the character set
mysqli_set_charset($conn, "utf8mb4");
?>

