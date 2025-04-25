<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "handmade_db"; // Replace with your DB name if different
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, port: $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
