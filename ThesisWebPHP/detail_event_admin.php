<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
$No = $_GET["No"];
$_SESSION['No'] = $No;

$sql = "SELECT * FROM event WHERE No=$No";
$results = mysqli_query($conn, $sql);

$rows = mysqli_fetch_assoc($results);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv=Content-Type content=”text/html; charset=utf-8″>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGJWZXtTeyE62k_Rp_pjY5x0yznq9pvfo&callback=initMap&libraries=&v=weekly"></script>
  <style>
    table,
    td,
    th {
      text-align: center;
    }
  </style>
</head>

<body>
  <?php
  require('fragment/header.php');
  ?>
  <form action="" method="POST" style="margin-top:50px">
    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-2">
        <label for="date">วันที่/เวลา ที่แจ้ง</label>
        <input type="text" readonly class="form-control" name="date" value="<?php echo $rows['date']; ?>">
      </div>
      <div class="form-group col-md-1"></div>
      <div class="form-group col-md-2">
        <label for="eventName">ประเภทเหตุการณ์</label>
        <input type="text" readonly class="form-control" name="eventName" value="<?php echo $rows['eventName']; ?>">
      </div>
      <div class="form-group col-md-1"></div>
      <div class="form-group col-md-2">
        <label for="name">ชื่อ นามสกุล</label>
        <input type="text" readonly class="form-control" name="name" value="<?php echo $rows['name']; ?>">
      </div>
      <div class="form-group col-md-2"></div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-2">
        <label for="categoryCar">ประเภทรถยนต์</label>
        <input type="text" readonly class="form-control" name="carType" value="<?php echo $rows['carType']; ?>">
      </div>
      <div class="form-group col-md-1"></div>
      <div class="form-group col-md-2">
        <label for="insurance">บริษัทประกันที่ผูก</label>
        <input type="text" readonly class="form-control" name="insurance" value="<?php echo $rows['insurance']; ?>">
      </div>
      <div class="form-group col-md-1"></div>
      <div class="form-group col-md-2">
        <label for="tel">เบอร์โทรติดต่อ</label>
        <input type="tel" readonly class="form-control" name="telephone" value="<?php echo $rows['telephone']; ?>"">
      </div>
      <div class=" form-group col-md-2">
      </div>
    </div><br><br><br>

    <div class="row col-md-12">
      <div class="form-group col-md-2.5" style="margin:auto">
        <img src="<?php echo $_SESSION['URL'] ?><?php echo $rows['urlPicture'] ?>" alt="" width="300px" height="300px"" />
      </div>
    </div><br><br><br>

    <div class=" row col-md-12">
        <div class="form-group col-md-2.5" style="margin:auto">
          <?php
          $lat = $rows['lat'];
          $lng = $rows['lng'];
          ?>
          <iframe width="520" height="400" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=th&amp;q=<?php echo $lat; ?>,<?php echo $lng; ?>&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a type="hidden" href='https://www.embed-map.net/'>.</a>
          <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=234b0acce89c5e0d686aea67a16000bc0b628017'></script>
        </div>
      </div><br><br><br><br>
  </form>
  <?php
  $insurance = $rows['insurance'];

  $sql2 = "SELECT * FROM garage WHERE status='พร้อมทำงาน' AND insurance='$insurance'";
  $results2 = mysqli_query($conn, $sql2);

  $sql3 = "SELECT * FROM garage WHERE status='พร้อมทำงาน' AND insurance!='$insurance'";
  $results3 = mysqli_query($conn, $sql3);
  ?>

  <h2 style="text-align: center">เลือกทีมช่างที่จะทำงาน</h2><br>
  <div class="form-group col-md-4" style="margin:auto">
    <h5 style="color:green;text-align: center;float:left">บริษัทประกันตรงกันกับผู้แจ้ง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <h5 style="color:red;text-align: center;float:left">บริษัทประกันไม่ตรงกับผู้แจ้ง</p>
        <br>
  </div>
  <table class="table" style="margin-top:25px">
    <thead>
      <tr class="table-info">
        <th scope="col">ชื่ออู่ซ่อมรถ</th>
        <th scope="col">ที่ตั้งอู่ซ่อมรถ</th>
        <th scope="col">บริษัทประกันที่ผูก</th>
        <th scope="col">ระยะทาง(km)</th>
        <th scope="col">เลือกทีมช่าง</th>
      </tr>
    </thead>
    <?php
    function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
      $theta = $longitude1 - $longitude2;
      $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
      $distance = acos($distance);
      $distance = rad2deg($distance);
      $distance = $distance * 60 * 1.1515;
      $distance = $distance * 1.609344;
      return (round($distance, 2));
    }
    ?>
    <tbody>
      <form action="accept_event_admin.php" method="POST">
        <?php while ($rows2 = mysqli_fetch_assoc($results2)) { ?>
          <?php
          $lat2 = $rows2['lat'];
          $lng2 = $rows2['lng'];
          $distance = getDistance($lat, $lng, $lat2, $lng2);
          ?>
          <tr style="color:green;">
            <input type="hidden" name="<?php echo $rows2["garageName"]; ?>" id="garageName" value="<?php echo $rows2["garageName"]; ?>">
            <td> <?php echo $rows2["garageName"]; ?> </td>
            <td> <?php echo $rows2["country"]; ?> </td>
            <td> <?php echo $rows2["insurance"]; ?> </td>
            <td> <?php echo $distance ?> </td>
            <td> <input type="radio" name="garageName" value="<?php echo $rows2["garageName"]; ?>"> </td>
          </tr>
        <?php } ?>
        <?php while ($rows3 = mysqli_fetch_assoc($results3)) { ?>
          <?php
          $lat2 = $rows3['lat'];
          $lng2 = $rows3['lng'];
          $distance = getDistance($lat, $lng, $lat2, $lng2);
          ?>
          <tr style="color:red;">
            <td> <?php echo $rows3["garageName"]; ?> </td>
            <td> <?php echo $rows3["country"]; ?> </td>
            <td> <?php echo $rows3["insurance"]; ?> </td>
            <td> <?php echo $distance ?> </td>
            <td> <input type="radio" name="garageName" value="<?php echo $rows3["garageName"]; ?>"> </td>
          </tr>
        <?php } ?>
    </tbody>
  </table><br>
  <div class="form-row">
  <div class="form-group col-md-5"></div>
    <div class="form-group col-md-1">
      <button type="submit" class="btn btn-primary" name="accept" onclick="return confirm('ยืนยันการแจ้งทีมช่างหรือไม่')">แจ้งทีมช่าง</button>
    </div>
    <div class="form-group col-md-1">
      <button type="submit" class="btn btn-danger" name="decline" onclick="return confirm('ยืนยันที่จะปฏิเสธงานหรือไม่')">ปฏิเสธงาน</button>
    </div>
    <div class="form-group col-md-5"></div>
  </div><br><br><br>
  </form>
</body>
</html>