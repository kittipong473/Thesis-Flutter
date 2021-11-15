<?php
include('include/auth.php');
require('include/connection.php');
error_reporting(0);
?>

<?php
session_start();
$check = $_SESSION['username'];
$query = "SELECT * FROM supers WHERE username = '$check'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$superID = $row['superID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register_Location</title>
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

            $sql2 = "UPDATE `supers` SET status = 'อยู่ในระบบ' WHERE superID = '$superID'";
            mysqli_query($conn, $sql2);

            echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Register Successfully",
                    text: "Welcome to ICar Service Application",
                    type: "success"
                }, function() {
                    window.location = "update_status_list.php";
                })
            });
        </script>
    ';
        } else {
            echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Register Failed",
                    text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    type: "error"
                })
            });
        </script>
    ';
        }
    } else {
    ?>

    <div class="container">
        <div class="login_area" style="height:600px;margin:left;background-color:lightskyblue">
            <br>
            <h1>Register Location</h1><br>
            <h4>ค้นหาพิกัด latitude longitude ของคุณจาก google map เมื่อต้องการแก้ไขตำแหน่งของอู่ซ่อมรถ</h4>
            <a target="_blank" class="btn btn-secondary btn-sm" href="https://www.google.com/maps/place/<?php echo $row0['country'] ?>">เปิด Google Map</a><br><br>
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
                <button style="width: auto;" onclick="return confirm('ยืนยันการแก้ไขหรือไม่')">Confirm Location</button><br>
            </form><br>
            <a href="index.php" class="btn btn-secondary btn-sm"> Back </a>
        </div>
    </div>
    <?php } ?>
</body>

</html>