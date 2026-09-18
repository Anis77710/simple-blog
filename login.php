<?php
session_start();
require './includes/config.php';
$error = '';
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);

    if($result && mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        if($row['password']==$password){
           $_SESSION['role'] = $row['role'];
           header('Location:./admin/dashboard.php');
           exit;
        } else {
            $error = 'Incorrect password.';
        }
    } else {
        $error = 'No user found with that email.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Simple Blog</title>
</head>
<body>
<h1>Login</h1>
<p><a href="./index.php">Back to blog</a></p>
<hr>
<?php if ($error): ?>
<p><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form action="" method="post">
<p>
<label>Email:<br>
<input type="email" name="email" required>
</label>
</p>
<p>
<label>Password:<br>
<input type="password" name="password" required>
</label>
</p>
<p><input type="submit" name="login" value="Login"></p>
</form>
</body>
</html>
