<?php
// Database connection setup
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student_system";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
