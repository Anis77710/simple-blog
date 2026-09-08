<?php
require('../includes/config.php');

if (isset($_POST['addUser'])) {
    // print_r($_POST);

    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $sql = "INSERT INTO `users`(`email`,`role`, `password`) VALUES ('$email', '$role', '$password')";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "success";
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <?php include './adminHeader.php' ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <select class="form-select" name='role' aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <!-- <option value="3">Three</option> -->
                    </select>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <input type="submit" name='addUser' value="Add User">
                </form>
            </div>
        </div>
    </div>
</body>

</html>