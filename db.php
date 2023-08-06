<?php
$host = "";  // Database host
$username = "";  // Database username
$password = "";  // Database password
$database = "";  // Database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>