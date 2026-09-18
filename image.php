<?php
require './includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    die('Invalid image id.');
}

$stmt = mysqli_prepare($conn, "SELECT image_data, image_type FROM posts WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $data, $type);
if (!mysqli_stmt_fetch($stmt) || $data === null) {
    http_response_code(404);
    die('Image not found.');
}
mysqli_stmt_close($stmt);

header('Content-Type: ' . $type);
header('Content-Length: ' . strlen($data));
echo $data;
