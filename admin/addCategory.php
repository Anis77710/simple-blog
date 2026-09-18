<?php
require('../includes/config.php');
$message = '';

if (isset($_POST['addCategory'])) {
    $category_name = mysqli_real_escape_string($conn, trim($_POST['category_name'] ?? ''));
    if ($category_name === '') {
        $message = 'Category name is required.';
    } else {
        $sql = "INSERT INTO `categories`(`category_name`) VALUES ('$category_name')";
        $result = mysqli_query($conn, $sql);
        $message = $result ? 'Category added.' : 'Failed: ' . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM `categories` ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categories - Simple Blog</title>
</head>
<body>
<h1>Categories</h1>
<?php include './adminHeader.php' ?>
<?php if ($message): ?>
<p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<h2>Add Category</h2>
<form method="post">
<p>
<label>Category Name:<br>
<input type="text" name="category_name" required>
</label>
</p>
<p><input type="submit" name="addCategory" value="Add"></p>
</form>
<hr>
<h2>All Categories</h2>
<?php if ($result && mysqli_num_rows($result) > 0): ?>
<table border="1" cellpadding="5">
<tr>
<th>ID</th>
<th>Name</th>
<th>Actions</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?php echo (int)$row['id']; ?></td>
<td><?php echo htmlspecialchars($row['category_name']); ?></td>
<td>
<a href="./manageCategory.php?id=<?php echo (int)$row['id']; ?>&action=e">Edit</a> |
<a href="./manageCategory.php?id=<?php echo (int)$row['id']; ?>&action=d" onclick="return confirm('Delete this category?');">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No categories found.</p>
<?php endif; ?>
</body>
</html>
