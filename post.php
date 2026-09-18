<?php
require './includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    die('Invalid post id. <a href="./index.php">Back</a>');
}

$sql = "SELECT p.id, p.title, p.category_id, p.content, p.created_at, (p.image_data IS NOT NULL) AS has_image, c.category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";
$result = mysqli_query($conn, $sql);
$post = $result ? mysqli_fetch_assoc($result) : null;
if (!$post) {
    http_response_code(404);
    die('Post not found. <a href="./index.php">Back</a>');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./assets/css/style.css">
<title><?php echo htmlspecialchars($post['title']); ?> - Simple Blog</title>
</head>
<body>
<p><a href="./index.php">Home</a></p>
<hr>
<h1><?php echo htmlspecialchars($post['title']); ?></h1>
<p>Category: <?php echo htmlspecialchars($post['category_name'] ?? 'Uncategorized'); ?> | Date: <?php echo htmlspecialchars($post['created_at']); ?></p>
<?php if (!empty($post['has_image'])): ?>
<p><img src="./image.php?id=<?php echo (int)$post['id']; ?>" alt="" width="500"></p>
<?php endif; ?>
<hr>
<p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
<hr>
<p><a href="./index.php">Back to all posts</a></p>
</body>
</html>
