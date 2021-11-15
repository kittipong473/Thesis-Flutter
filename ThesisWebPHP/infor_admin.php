<?php
include('include/auth.php');
require('include/connection.php');
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrator Information</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:purple">
  <?php
  require('fragment/header.php');
  ?>
  <div class="container">
    <div class="login_area" style="height:650px;margin:left;background-color:lightskyblue">
      <br><img src="image/mechanic.png" alt="" width="100px" height="100px">
      <h1>Admin Information</h1><br>
      <form action="editAdmin.php" method="POST">
      <input type="hidden" name="adminID" value="<?php echo $row['adminID'] ?>">
      <div class="form-group">
        <label for="ID">Username : </label>
        <input type="text" name="username" value="<?php echo $row['username'] ?>" autocomplete="off" style="width:300px;padding:10px;" required><br><br>
      </div>
      <div class="form-group">
        <label for="ID">Email : </label>
        <input type="email" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" style="width:300px;padding:10px;" required><br><br>
      </div>
      <div class="form-group">
        <label for="ID">Telephone : </label>
        <input type="tel" name="telephone" value="<?php echo $row['telephone'] ?>" autocomplete="off" style="width:300px;padding:10px;" required><br><br><br>
      </div>
        <button style="width: auto;" onclick="return confirm('ยืนยันการแก้ไขหรือไม่')">Edit Information</button>
      </form>
    </div>
  </div>
</body>
</html>