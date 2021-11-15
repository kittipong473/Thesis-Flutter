<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
$sql = "SELECT * FROM supers";
$results = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Supervisor_data Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  require('fragment/header.php');
  ?>

  <table class="table" style="margin-top:25px">
    <thead>
      <tr class="table-info">
        <th scope="col">รหัสผู้ควบคุม</th>
        <th scope="col">ชื่อผู้ควบคุม</th>
        <th scope="col">Email</th>
        <th scope="col">เบอร์โทร</th>
        <th scope="col">ชื่ออู่ซ่อมรถ</th>
        <th scope="col">สถานะผู้ใช้งาน</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
        <tr>
          <th scope="row"> <?php echo $rows["superID"]; ?> </th>
          <td> <?php echo $rows["username"]; ?> </td>
          <td> <?php echo $rows["email"]; ?> </td>
          <td> <?php echo $rows["telephone"]; ?> </td>
          <td> <?php echo $rows["garageName"]; ?> </td>
          <?php if ($rows["status"] == "อยู่ในระบบ") { ?>
            <td style="color:green;"> <?php echo $rows["status"]; ?> </td>
          <?php } else { ?>
            <td style="color:red;"> <?php echo $rows["status"]; ?> </td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>