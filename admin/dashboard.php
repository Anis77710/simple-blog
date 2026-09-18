<?php
require("../includes/config.php");

$posts = mysqli_query($conn, "SELECT COUNT(*) AS c FROM posts");
$posts_count = $posts ? (int)mysqli_fetch_assoc($posts)['c'] : 0;
$cats = mysqli_query($conn, "SELECT COUNT(*) AS c FROM categories");
$cats_count = $cats ? (int)mysqli_fetch_assoc($cats)['c'] : 0;
$users = mysqli_query($conn, "SELECT COUNT(*) AS c FROM users");
$users_count = $users ? (int)mysqli_fetch_assoc($users)['c'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/style.css">
<title>Dashboard - Simple Blog</title>
</head>
<body>
<h1>Dashboard</h1>
<?php include './adminHeader.php' ?>
<p>Posts: <?php echo $posts_count; ?></p>
<p>Categories: <?php echo $cats_count; ?></p>
<p>Users: <?php echo $users_count; ?></p>
<hr>
<p><a href="./addBlog.php">Write a new post</a></p>
<p><a href="./managePosts.php">Manage posts</a></p>
<p><a href="./addCategory.php">Manage categories</a></p>
</body>
</html>
