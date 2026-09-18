<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "php_blog";

try {
    $conn = mysqli_connect($server, $username, $password, $database);
    if (!$conn) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Throwable $e) {
    http_response_code(500);
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}