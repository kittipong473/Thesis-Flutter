<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
error_reporting(0);
$name = null;
$garage = null;
$name = $_POST["Sname"];
$garage = $_POST["Sgarage"];
if ($name != null) {
  $sql = "SELECT * FROM event WHERE name LIKE '%$name%' AND garage is NOT NULL AND status != 'เสร็จสิ้น' ORDER BY name ASC";
  $results = mysqli_query($conn, $sql);
} else if ($garage != null) {
  $sql = "SELECT * FROM event WHERE garage LIKE '%$garage%' AND garage is NOT NULL AND status != 'เสร็จสิ้น' ORDER BY garage ASC";
  $results = mysqli_query($conn, $sql);
} else {
  $sql = "SELECT * FROM event WHERE garage is NOT NULL AND status != 'เสร็จสิ้น'";
  $results = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Status Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</head>

<body>
  <?php
  require('fragment/header.php');
  ?>
  <br>
  <form class="form-inline" method="POST">
    <div class="row col-md-12">
      <div class="form-group col-md-2.5" style="margin:auto">
        <input class="form-control" name="Sname" type="search" placeholder="ชื่อผู้แจ้ง..." aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </div>
      <div class="form-group col-md-2.5" style="margin:auto">
        <input class="form-control" name="Sgarage" type="search" placeholder="ชื่ออู่ซ่อมรถ..." aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </div>
    </div>
  </form>

  <table class="table" style="margin-top:25px">
    <thead>
      <tr class="table-info">
        <th scope="col">ลำดับ</th>
        <th scope="col">วันที่/เวลา ที่แจ้ง</th>
        <th scope="col">เหตุการณ์</th>
        <th scope="col">ชื่อผู้แจ้ง</th>
        <th scope="col">เบอร์โทรผู้แจ้ง</th>
        <th scope="col">อู่ซ่อมรถที่ทำงาน</th>
        <th scope="col">ข้อมูลเพิ่มเติม</th>
        <th scope="col">สถานะ</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
        <tr>
          <th scope="row"> <?php echo $rows["No"]; ?> </th>
          <td> <?php echo $rows["date"]; ?> </td>
          <td> <?php echo $rows["eventName"]; ?> </td>
          <td> <?php echo $rows["name"]; ?> </td>
          <td> <?php echo $rows["telephone"]; ?> </td>
          <td> <?php echo $rows["garage"]; ?> </td>
          <td><a href="detail_status.php?No= <?php echo $rows["No"]; ?>">แสดงข้อมูลเพิ่มเติม</a></td>
          <td class="btn btn-secondary btn-md" style="cursor:default;"> <?php echo $rows["status"]; ?> </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>