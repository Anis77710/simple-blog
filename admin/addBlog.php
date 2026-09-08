<?php require('../includes/config.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

    <title>Document</title>
</head>
<body>
<?php include './adminHeader.php' ?>
<div class="container">


<form action="./blogCreate.php" method="POST">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title of your blog post" required>
    </div>

    <div class="mb-3">
      <label for="category" class="form-label">Category</label>
      <?php
      $sql = "SELECT * from categories";
      $result = mysqli_query($conn, $sql);

      $num = mysqli_num_rows($result);

    //   $row = mysqli_fetch_assoc($result);

      
      ?>
      <select class="form-select" id="category" name="category" required>
        <option value="">Select Category</option>
        <?php 
        if($num>0){
        while ($row = mysqli_fetch_assoc($result)){  
            ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['category_name'] ?></option>
       <?php }}
        
        ?>
       
        <!-- <option value="lifestyle">Lifestyle</option>
        <option value="health">Health</option>
        <option value="business">Business</option> -->
      </select>
    </div>

    <div class="mb-3">
      <label for="content" class="form-label">Content</label>
      <textarea class="form-control" id="content" name="content" rows="6" placeholder="Write your blog content here..." required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Publish Post</button>
  </form>
  </div>
</body>
</html>