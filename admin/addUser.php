<?php
require('../includes/config.php');
$message = '';

if (isset($_POST['addUser'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $role = mysqli_real_escape_string($conn, $_POST['role'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === '' || $password === '' || ($role !== 'admin' && $role !== 'manager')) {
        $message = 'Email, valid role and password are required.';
    } else {
        $sql = "INSERT INTO `users`(`email`,`role`, `password`) VALUES ('$email', '$role', '$password')";
        $result = mysqli_query($conn, $sql);
        $message = $result ? 'User added.' : 'Failed: ' . mysqli_error($conn);
    }
}

$users_result = mysqli_query($conn, "SELECT id, email, role FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add User - Simple Blog</title>
</head>
<body>
<h1>Add User</h1>
<?php include './adminHeader.php' ?>
<?php if ($message): ?>
<p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<form action="" method="post">
<p>
<label>Email:<br>
<input type="email" name="email" required>
</label>
</p>
<p>
<label>Role:<br>
<select name="role" required>
<option value="">Select role</option>
<option value="admin">Admin</option>
<option value="manager">Manager</option>
</select>
</label>
</p>
<p>
<label>Password:<br>
<input type="password" name="password" required>
</label>
</p>
<p><input type="submit" name="addUser" value="Add User"></p>
</form>
<hr>
<h2>All Users</h2>
<?php if ($users_result && mysqli_num_rows($users_result) > 0): ?>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Email</th><th>Role</th></tr>
<?php while ($u = mysqli_fetch_assoc($users_result)): ?>
<tr>
<td><?php echo (int)$u['id']; ?></td>
<td><?php echo htmlspecialchars($u['email']); ?></td>
<td><?php echo htmlspecialchars($u['role']); ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No users found.</p>
<?php endif; ?>
</body>
</html>
