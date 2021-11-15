<?php
include('include/auth.php');
require('include/connection.php');
error_reporting(0);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Garage_Information</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:purple">
  <?php
  require('fragment/header.php');
  ?>

  <?php
    $sqlIn = "SELECT * FROM insurance ORDER BY name ASC";
    $resultIn = mysqli_query($conn, $sqlIn);
  ?>
  <div class="container">
    <div class="login_area" style="height:1020px;margin:left;background-color:lightskyblue">
      <br><h1>Garage Information</h1><br>
      <img src="<?php echo $_SESSION['URL'] ?>/project/ICS/<?php echo $row0['urlPicture'] ?>" alt="" width="300px" height="200px"><br><br><br>
      <form action="editGarage.php" method="POST" name="addGarage" enctype="multipart/form-data">
        <input type="hidden" name="garageID" value="<?php echo $row0['garageID'] ?>">
        <div class="form-group">
          <label for="garageName">Garage Name: </label>
          <input type="text" name="garageName" value="<?php echo $row0['garageName'] ?>" autocomplete="off" style="width:200px;padding:10px;" required>
        </div><br>
        <div class="form-group">
          <label for="country">Country: </label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          <input type="text" name="country" value="<?php echo $row0['country'] ?>" autocomplete="off" style="width:200px;padding:10px;" required>
        </div><br>
        <div class="form-group">
          <label for="description">Description: </label>
          <textarea name="description" value="<?php echo $row0['description'] ?>" autocomplete="off" style="width:300px;padding:10px;" rows="5" required><?php echo $row0['description'] ?></textarea>
        </div>
        <div class="form-group col-md-6" style="margin:auto">
          <label for="insurance">Insurance: </label>
          <select name="insurance" class="form-control col-md-12" style="width:200px;margin:auto" required>
            <option value="<?php echo $row0['insurance'] ?>" selected="selected"><?php echo $row0['insurance'] ?></option>
            <?php while ($rowIn = mysqli_fetch_assoc($resultIn)) { ?>
              <option value="<?php echo $rowIn['name'] ?>"><?php echo $rowIn['name'] ?></option>
            <?php } ?>
          </select>
        </div><br><br>
        <div class="form-group col-md-6" style="margin:auto">
          <label for="urlPicture">แก้ไขรูปเกี่ยวกับอู่ซ่อมรถ</label>
          <input type="file" name="urlPicture" class="form-control-file col-12"><br><br>
        </div><br>

        <button style="width: auto;" onclick="return confirm('ยืนยันการแก้ไขหรือไม่')">Edit Information</button><br><br>
      </form>
    </div>
  </div>
</body>
<?php
include('include/script.php');
?>

</html>