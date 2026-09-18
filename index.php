<?php
require './includes/config.php';

$cat_filter = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

$cats_result = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");

if ($cat_filter > 0) {
    $sql = "SELECT p.id, p.title, p.category_id, p.content, p.created_at, (p.image_data IS NOT NULL) AS has_image, c.category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = $cat_filter ORDER BY p.created_at DESC";
} else {
    $sql = "SELECT p.id, p.title, p.category_id, p.content, p.created_at, (p.image_data IS NOT NULL) AS has_image, c.category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC";
}
$posts_result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Simple Blog</title>
</head>
<body>
<h1>Simple Blog</h1>
<p><a href="./login.php">Login</a> | <a href="./admin/dashboard.php">Admin</a></p>
<hr>

<h2>Categories</h2>
<p>
<a href="./index.php">All</a>
<?php if ($cats_result): ?>
<?php while ($cat = mysqli_fetch_assoc($cats_result)): ?>
| <a href="./index.php?cat=<?php echo (int)$cat['id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></a>
<?php endwhile; ?>
<?php endif; ?>
</p>
<hr>

<h2>Posts</h2>
<?php if ($posts_result && mysqli_num_rows($posts_result) > 0): ?>
<?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
<h3><a href="./post.php?id=<?php echo (int)$post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
<?php if (!empty($post['has_image'])): ?>
<p><a href="./post.php?id=<?php echo (int)$post['id']; ?>"><img src="./image.php?id=<?php echo (int)$post['id']; ?>" alt="" width="200"></a></p>
<?php endif; ?>
<p>Category: <?php echo htmlspecialchars($post['category_name'] ?? 'Uncategorized'); ?> | Date: <?php echo htmlspecialchars($post['created_at']); ?></p>
<p><?php echo htmlspecialchars(mb_substr($post['content'], 0, 200)); ?><?php echo mb_strlen($post['content']) > 200 ? '...' : ''; ?></p>
<p><a href="./post.php?id=<?php echo (int)$post['id']; ?>">Read more</a></p>
<hr>
<?php endwhile; ?>
<?php else: ?>
<p>No posts yet.</p>
<?php endif; ?>
</body>
</html>
