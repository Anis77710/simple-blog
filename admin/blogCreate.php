<?php
require('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $category_id = (int)($_POST['category'] ?? 0);
    $content = mysqli_real_escape_string($conn, $_POST['content'] ?? '');

    if ($title === '' || $category_id <= 0 || $content === '') {
        http_response_code(400);
        die('Title, category and content are all required.');
    }

    $sql = "INSERT INTO `posts` (`title`, `category_id`, `content`) VALUES ('$title', $category_id, '$content')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: ./addBlog.php?success=1');
        exit;
    } else {
        http_response_code(500);
        die('Failed to publish post: ' . htmlspecialchars(mysqli_error($conn)));
    }
} else {
    header('Location: ./addBlog.php');
    exit;
}