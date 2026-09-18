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

    $image_path = null;
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
        $filename = 'post_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $dest = dirname(__DIR__) . '/uploads/' . $filename;
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
            http_response_code(500);
            die('Could not save photo.');
        }
        $image_path = 'uploads/' . $filename;
    }

    $image_sql = $image_path === null ? 'NULL' : "'" . mysqli_real_escape_string($conn, $image_path) . "'";
    $sql = "INSERT INTO `posts` (`title`, `category_id`, `content`, `image`) VALUES ('$title', $category_id, '$content', $image_sql)";
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