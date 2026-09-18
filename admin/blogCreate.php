<?php
require('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category_id = (int)($_POST['category'] ?? 0);
    $content = $_POST['content'] ?? '';

    if ($title === '' || $category_id <= 0 || $content === '') {
        http_response_code(400);
        die('Title, category and content are all required.');
    }

    $image_data = null;
    $image_type = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            die('Photo upload failed.');
        }
        if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
            http_response_code(400);
            die('Photo must be under 2MB.');
        }
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $info = @getimagesize($_FILES['photo']['tmp_name']);
        if (!in_array($ext, $allowed_ext, true) || $info === false) {
            http_response_code(400);
            die('Photo must be a JPG, PNG, GIF or WEBP image.');
        }
        $image_data = file_get_contents($_FILES['photo']['tmp_name']);
        $image_type = $info['mime'];
        if ($image_data === false) {
            http_response_code(500);
            die('Could not read photo.');
        }
    }

    if ($image_data !== null) {
        $stmt = mysqli_prepare($conn, "INSERT INTO `posts` (`title`, `category_id`, `content`, `image_data`, `image_type`) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            die('Failed to publish post: ' . htmlspecialchars(mysqli_error($conn)));
        }
        mysqli_stmt_bind_param($stmt, 'sisss', $title, $category_id, $content, $image_data, $image_type);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO `posts` (`title`, `category_id`, `content`) VALUES (?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            die('Failed to publish post: ' . htmlspecialchars(mysqli_error($conn)));
        }
        mysqli_stmt_bind_param($stmt, 'sis', $title, $category_id, $content);
    }
    $result = mysqli_stmt_execute($stmt);
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