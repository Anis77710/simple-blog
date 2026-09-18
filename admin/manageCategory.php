<?php
require('../includes/config.php');
$cid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($cid <= 0 || ($action !== 'e' && $action !== 'd')) {
    http_response_code(400);
    die('Invalid request. <a href="./addCategory.php">Back</a>');
}

if ($action === 'd') {
    $sql = "DELETE FROM `categories` WHERE `id`=$cid";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Cannot delete: " . htmlspecialchars(mysqli_error($conn)) . ' <a href="./addCategory.php">Back</a>');
    }
    header("location: ./addCategory.php");
    exit;
}

$sql = "SELECT * FROM `categories` WHERE `id`=$cid";
$result = mysqli_query($conn, $sql);
$row = $result ? mysqli_fetch_assoc($result) : null;
if (!$row) {
    http_response_code(404);
    die('Category not found. <a href="./addCategory.php">Back</a>');
}
$categoryName = $row['category_name'];

if (isset($_POST['update'])) {
    $catName = mysqli_real_escape_string($conn, trim($_POST['categoryName'] ?? ''));
    if ($catName === '') {
        die('Name is required. <a href="./addCategory.php">Back</a>');
    }
    $updateQuery = "UPDATE `categories` SET `category_name`='$catName' WHERE `id`=$cid";
    $result = mysqli_query($conn, $updateQuery);
    if (!$result) {
        die("Cannot update: " . htmlspecialchars(mysqli_error($conn)));
    }
    header("location: ./addCategory.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Category - Simple Blog</title>
</head>
<body>
<h1>Edit Category</h1>
<?php include './adminHeader.php' ?>
<form method="post">
<p>
<label>Category Name:<br>
<input type="text" name="categoryName" value="<?php echo htmlspecialchars($categoryName); ?>" required>
</label>
</p>
<p><input type="submit" name="update" value="Update"></p>
</form>
</body>
</html>
