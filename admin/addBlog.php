<?php require('../includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Blog - Simple Blog</title>
</head>
<body>
<h1>Add Blog</h1>
<?php include './adminHeader.php' ?>
<?php if (isset($_GET['success'])): ?>
<p>Post published successfully.</p>
<?php endif; ?>
<?php
$sql = "SELECT * FROM categories ORDER BY category_name";
$result = mysqli_query($conn, $sql);
?>
<form action="./blogCreate.php" method="POST" enctype="multipart/form-data">
<p>
<label>Title:<br>
<input type="text" name="title" size="50" required>
</label>
</p>
<p>
<label>Category:<br>
<select name="category" required>
<option value="">Select Category</option>
<?php if ($result): ?>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<option value="<?php echo (int)$row['id']; ?>"><?php echo htmlspecialchars($row['category_name']); ?></option>
<?php endwhile; ?>
<?php endif; ?>
</select>
</label>
</p>
<p>
<label>Content:<br>
<textarea name="content" rows="10" cols="60" required></textarea>
</label>
</p>
<p>
<label>Photo (optional, JPG/PNG/GIF/WEBP, max 2MB):<br>
<input type="file" name="photo" accept="image/jpeg,image/png,image/gif,image/webp">
</label>
</p>
<p><input type="submit" value="Publish Post"></p>
</form>
</body>
</html>
