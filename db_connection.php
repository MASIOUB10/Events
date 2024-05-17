<?php
$host = "localhost"; // Your MySQL host
$user = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "eventtt"; // Your MySQL database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
