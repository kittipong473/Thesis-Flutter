<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
$sql = "SELECT * FROM customers";
$results = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Customers_data Page</title>
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
        <th scope="col">รหัสผู้ใช้งาน</th>
        <th scope="col">username </th>
        <th scope="col">ชื่อผู้ใช้งาน</th>
        <th scope="col">เบอร์โทร</th>
        <th scope="col">สถานะผู้ใช้งาน</th>
        <?php if ($_SESSION['role'] == "admin") { ?>
          <th scope="col">อัพเดทสถานะ</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
        <tr>
          <th scope="row"> <?php echo $rows["customerID"]; ?> </th>
          <td> <?php echo $rows["username"]; ?> </td>
          <td> <?php echo $rows["name"]; ?> </td>
          <td> <?php echo $rows["telephone"]; ?> </td>
          <?php if ($rows["status"] == "อยู่ในระบบ") { ?>
            <td style="color:green;"> <?php echo $rows["status"]; ?> </td>
          <?php } else if ($rows["status"] == "ปิดการใช้งาน") { ?>
            <td style="color:lightgray;"> <?php echo $rows["status"]; ?> </td>
          <?php } ?>
          <?php if ($_SESSION['role'] == "admin") { ?>
            <?php if ($rows["status"] == "อยู่ในระบบ") { ?>
              <td>
                <a class="btn btn-outline-danger" href="process_status_customer.php?customerID=<?php echo $rows["customerID"]; ?>">ปิดการใช้งาน</a>
              </td>
            <?php } else if ($rows["status"] == "ปิดการใช้งาน") { ?>
              <td>
                <a class="btn btn-outline-success" href="process_status_customer.php?customerID=<?php echo $rows["customerID"]; ?>">เปิดการใช้งาน</a>
              </td>
            <?php } ?>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>