<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
$sql = "SELECT * FROM categoryevent";
$results = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv=Content-Type content=”text/html; charset=utf-8″>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inform Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>

<body>
  <?php
  require('fragment/header.php');
  ?>

    <form action="process_inform_super.php" method="POST" style="margin-top:50px" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-3">
          <label for="date">วัน/เวลา ที่แจ้ง</label>
          <input type="datetime-local" class="form-control" name="date">
        </div>
        <div class="form-group col-md-4"></div>
        <div class="form-group col-md-3">
          <label for="categoryEvent">ประเภทเหตุการณ์</label>
          <select class="form-control" name="eventName">
            <option selected>-- เลือกอุบัติเหตุ --</option>
            <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
              <option value="<?php echo $rows["eventName"]; ?>"> <?php echo $rows["eventName"]; ?> </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-1"></div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-3">
          <label for="name">ชื่อ นามสกุล</label>
          <input type="text" class="form-control" name="name" autocomplete="off">
        </div>
        <div class="form-group col-md-4"></div>
        <div class="form-group col-md-3">
          <label for="tel">เบอร์โทรติดต่อ</label>
          <input type="tel" class="form-control" name="telephone" autocomplete="off">
        </div>
        <div class="form-group col-md-1"></div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-3">
          <label for="categoryCar">ประเภทรถยนต์</label>
          <input type="text" class="form-control" name="carType">
        </div>
        <div class="form-group col-md-4"></div>
        <div class="form-group col-md-3">
          <label for="insurance">บริษัทประกันที่ผูก</label>
          <input type="text" class="form-control" name="insurance">
        </div>
        <div class="form-group col-md-1"></div>
      </div><br>

      <div class="form-row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-3">
          <label for="urlPicture">เพิ่มรูปภาพ</label>
          <input type="file" class="form-control-file" name="urlPicture">
        </div>
        <div class="form-group col-md-4"></div>
        <div class="form-group col-md-3">
          <label for="gps">เพิ่มตำแหน่ง</label>
          <input type="file" class="form-control-file" name="gps">
        </div>
        <div class="form-group col-md-1"></div>
      </div><br><br><br>

      <div class="col-md-1" style="margin: 0 auto">
        <button type="submit" name="submit" class="btn btn-primary" style="align:center" onclick="return confirm('ยืนยันการแจ้งหรือไม่')">แจ้ง Admin</button>
      </div>
    </form>
</body>
<?php
  include('include/script.php');
?>
</html>