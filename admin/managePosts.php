<?php
require('../includes/config.php');

if (isset($_GET['action']) && $_GET['action'] === 'd') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        mysqli_query($conn, "DELETE FROM posts WHERE id = $id");
    }
    header('Location: ./managePosts.php');
    exit;
}

$result = mysqli_query($conn, "SELECT p.*, c.category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Posts - Simple Blog</title>
</head>
<body>
<h1>Manage Posts</h1>
<?php include './adminHeader.php' ?>
<p><a href="./addBlog.php">Write a new post</a></p>
<?php if ($result && mysqli_num_rows($result) > 0): ?>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Title</th><th>Category</th><th>Date</th><th>Actions</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?php echo (int)$row['id']; ?></td>
<td><a href="../post.php?id=<?php echo (int)$row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></td>
<td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
<td><?php echo htmlspecialchars($row['created_at']); ?></td>
<td><a href="./managePosts.php?action=d&id=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this post?');">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No posts yet. <a href="./addBlog.php">Write the first one</a>.</p>
<?php endif; ?>
</body>
</html>
