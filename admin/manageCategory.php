<?php
require('../includes/config.php');
$cid = $_GET['id'];
$action = $_GET['action'];

if ($action == 'e') {
    $sql = "SELECT * FROM `categories` WHERE `id`=$cid";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $categoryName = $row['category_name'];

    if (isset($_POST['update'])) {
        $catName= $_POST['categoryName'];
        $updateQuery = "UPDATE `categories` SET `category_name`='$catName' WHERE `id`=$cid";

    $result = mysqli_query($conn, $updateQuery);
    if ($result) {
       echo"Category updated successfully";
    } else {
        echo"Category cannot be updated.";
    }
    header("location: ./addCategory.php");
    die;
    }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

        <title>Edit Category</title>
    </head>

    <body>
        <?php include './adminHeader.php' ?>


        <!-- --------------------------content area----------------------- -->
        <main class="mt-5 py-3 ps-2">
            <div class="container-fluid main-content pt-2">
                <div class="row">
                    <div class="col-md-12 fw-bold fs-3">
                        Edit Category
                    </div>
                </div>
                <!-- ---------------------------content starts here----------------------------- -->
                <div class="row mt-1 p-3">

                    <div class="col-3">
                        <form action="#" method="post">
                            <div class="row g-3">
                                <!-- name -->
                                <div class="form-floating col-12">
                                    <input type="text" value="<?= $categoryName ?>" name="categoryName" id="categoryName" class="form-control" placeholder="Category Name" required>
                                    <label for="categoryName" class="form-label">Category Name</label>
                                    <div class="error-message" id="cnameErrorMessage"></div>
                                </div>
                                <div class="col-12">
                                    <input type="submit" value="Update" id="update" name="update" class="form-control btn btn-primary">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </body>

    </html>

<?php

}
if ($action === 'd') {

    $sql = "DELETE FROM `categories` WHERE `id`=$cid";
    $result = mysqli_query($conn, $sql);

    if ($result) {
       echo "Book Category Deleted Successfully";
    } else {
        echo "Book Category cannot be Deleted";
    }
    header("location: ./addCategory.php");
    die;
}
?>