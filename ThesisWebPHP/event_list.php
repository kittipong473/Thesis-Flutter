<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
error_reporting(0);
$date = null;
$evenName = null;
$name = null;
$date = $_POST["Sdate"];
$eventName = $_POST["Sevent"];
$name = $_POST["Sname"];
if ($_SESSION['role'] == "admin") {
  if ($date != null) {
    $sql = "SELECT * FROM event WHERE date LIKE '%$date%' AND status='เสร็จสิ้น' ORDER BY date ASC";
    $results = mysqli_query($conn, $sql);
  } else if ($eventName != null) {
    $sql = "SELECT * FROM event WHERE eventName LIKE '%$eventName%' AND status='เสร็จสิ้น' ORDER BY eventName ASC";
    $results = mysqli_query($conn, $sql);
  } else if ($name != null) {
    $sql = "SELECT * FROM event WHERE name LIKE '%$name%' AND status='เสร็จสิ้น' ORDER BY name ASC";
    $results = mysqli_query($conn, $sql);
  } else {
    $sql = "SELECT * FROM event WHERE status='เสร็จสิ้น'";
    $results = mysqli_query($conn, $sql);
  }
} else if ($_SESSION['role'] == "super") {
  $garageName = $_SESSION['garageName'];
  if ($date != null) {
    $sql = "SELECT * FROM event WHERE date LIKE '%$date%' AND garage = '$garageName' AND status='เสร็จสิ้น' ORDER BY date ASC";
    $results = mysqli_query($conn, $sql);
  } else if ($eventName != null) {
    $sql = "SELECT * FROM event WHERE eventName LIKE '%$eventName%' AND garage = '$garageName' AND status='เสร็จสิ้น' ORDER BY eventName ASC";
    $results = mysqli_query($conn, $sql);
  } else if ($name != null) {
    $sql = "SELECT * FROM event WHERE name LIKE '%$name%' AND garage = '$garageName' AND status='เสร็จสิ้น' ORDER BY name ASC";
    $results = mysqli_query($conn, $sql);
  } else {
    $sql = "SELECT * FROM event WHERE status='เสร็จสิ้น' AND garage = '$garageName'";
    $results = mysqli_query($conn, $sql);
  }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Event_data Page</title>
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
        <input class="form-control" name="Sdate" type="search" placeholder="วันที่แจ้ง..." aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </div>
      <div class="form-group col-md-2.5" style="margin:auto">
        <input class="form-control" name="Sevent" type="search" placeholder="ชื่อเหตุการณ์..." aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </div>
      <div class="form-group col-md-2.5" style="margin:auto">
        <input class="form-control" name="Sname" type="search" placeholder="ชื่อผู้แจ้ง..." aria-label="Search">
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
        <?php if ($_SESSION['role'] == "admin") { ?>
          <th scope="col">อู่ที่รับผิดชอบ</th>
        <?php } ?>
        <th scope="col">ข้อมูลเพิ่มเติม</th>
        <th scope="col">สถานะ</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($_SESSION['role'] == "admin") { ?>
        <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
          <tr>
            <th scope="row"> <?php echo $rows["No"]; ?> </th>
            <td> <?php echo $rows["date"]; ?> </td>
            <td> <?php echo $rows["eventName"]; ?> </td>
            <td> <?php echo $rows["name"]; ?> </td>
            <td> <?php echo $rows["telephone"]; ?> </td>
            <?php if ($_SESSION['role'] == "admin") { ?>
              <td> <?php echo $rows["garage"]; ?> </td>
            <?php } ?>
            <td><a href="detail_event_show.php?No= <?php echo $rows["No"]; ?>">แสดงข้อมูลเพิ่มเติม</a></td>
            <td style="color:lightgray;"> <?php echo $rows["status"]; ?> </td>
            </td>
          </tr>
        <?php } ?>
      <?php } else if ($_SESSION['role'] == "super") {?>
        <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
          <tr>
            <th scope="row"> <?php echo $rows["No"]; ?> </th>
            <td> <?php echo $rows["date"]; ?> </td>
            <td> <?php echo $rows["eventName"]; ?> </td>
            <td> <?php echo $rows["name"]; ?> </td>
            <td> <?php echo $rows["telephone"]; ?> </td>
            <td><a href="detail_event_show.php?No= <?php echo $rows["No"]; ?>">แสดงข้อมูลเพิ่มเติม</a></td>
            <td style="color:lightgray;"> <?php echo $rows["status"]; ?> </td>
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>