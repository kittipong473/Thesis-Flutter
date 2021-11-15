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
    <title>Location_Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:purple">
    <?php
    require('fragment/header.php');
    ?>

    <?php
    if (isset($_POST['lat']) && isset($_POST['lng'])) {
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $garageID = $row0['garageID'];
        $sql = "UPDATE `garage` SET lat = '$lat', lng = '$lng' WHERE garageID = '$garageID'";
        $results = mysqli_query($conn, $sql);

        echo '
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
';

        if ($results) {
            echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Edit Successfully",
                    type: "success"
                }, function() {
                    window.location = "edit_location2.php";
                })
            });
        </script>
    ';
        } else {
            echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Edit Failed",
                    type: "error"
                })
            });
        </script>
    ';
        }
    } else {
    ?>

    <div class="container">
        <div class="login_area" style="height:1150px;margin:left;background-color:lightskyblue">
            <br>
            <h1>Edit Location</h1><br>
            <h4>ตำแหน่งปัจจุบันอู่ซ่อมรถของคุณ</h4>
            <p>*กรุณาเปิดการเข้าถึง location ก่อนใช้งาน*</p>
            <div class="form-group col-md-2.5" style="margin:auto">
                <?php
                $lat = $row0['lat'];
                $lng = $row0['lng'];
                ?>
                <iframe width="520" height="400" id="gmap_canvas"
                    src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=th&amp;q=<?php echo $lat; ?>,<?php echo $lng; ?>&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.embed-map.net/'>.</a>
                <script type='text/javascript'
                    src='https://embedmaps.com/google-maps-authorization/script.js?id=234b0acce89c5e0d686aea67a16000bc0b628017'></script>
            </div>
            <br><br><br>
            <h4>ค้นหาพิกัด latitude longitude ของคุณจาก google map เมื่อต้องการแก้ไขตำแหน่งของอู่ซ่อมรถ</h4>
            <a target="_blank" class="btn btn-secondary btn-sm" href="https://www.google.com/maps/place/<?php echo $lat; ?>,<?php echo $lng; ?>">เปิด Google Map</a><br><br>
            <input type="text" placeholder="paste จาก google map" style="width:400px;padding:10px;"><br><br><br>
            <form method="POST">
                <div class="form-group">
                    <label for="lat">Latitude: </label>&nbsp&nbsp&nbsp&nbsp
                    <input type="text" name="lat" placeholder="พิกัด ทศนิยม 6 ตำแหน่ง" autocomplete="off" maxlength="9" style="width:400px;padding:10px;" required>
                </div>
                <div class="form-group">
                    <label for="lng">Longitude: </label>
                    <input type="text" name="lng" placeholder="พิกัด ทศนิยม 6 ตำแหน่ง" autocomplete="off" maxlength="10" style="width:400px;padding:10px;" required>
                </div><br><br>
                <button style="width: auto;" onclick="return confirm('ยืนยันการแก้ไขหรือไม่')">Edit Location</button><br><br>
            </form>
        </div>
    </div>
    <?php } ?>
</body>

</html>