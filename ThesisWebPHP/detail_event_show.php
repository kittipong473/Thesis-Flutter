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

</head>

<body>
  <?php
  require('fragment/header.php');
  ?>
  <form action="accept_event_super.php" method="POST" style="margin-top:50px">
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
          <iframe width="520" height="400" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=th&amp;q=<?php echo $lat; ?>,<?php echo $lng; ?>&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.embed-map.net/'>.</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=234b0acce89c5e0d686aea67a16000bc0b628017'></script>
        </div>
      </div><br>
  </form>
</body>

</html>