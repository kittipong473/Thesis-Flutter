<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
error_reporting(0);
$country = null;
$ins = null;
$country = $_POST["Scountry"];
$ins = $_POST["Sins"];
if ($country != null) {
  $sql = "SELECT * FROM garage WHERE country LIKE '%$country%' ORDER BY country ASC";
  $results = mysqli_query($conn, $sql);
} else if ($garage != null) {
  $sql = "SELECT * FROM garage WHERE insurance LIKE '%$garage%' ORDER BY insurance ASC";
  $results = mysqli_query($conn, $sql);
} else {
  $sql = "SELECT * FROM garage";
$results = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Garage_data Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require('fragment/header.php');
    ?>
    <br>
    <form class="form-inline" method="POST">
        <div class="row col-md-12">
            <div class="form-group col-md-2.5" style="margin:auto">
                <input class="form-control" name="Scountry" type="search" placeholder="ชื่อจังหวัด..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </div>
            <div class="form-group col-md-2.5" style="margin:auto">
                <input class="form-control" name="Sins" type="search" placeholder="ชื่อบริษัทประกัน..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </div>
        </div>
    </form>

    <table class="table" style="margin-top:25px">
        <thead>
            <tr class="table-info">
                <th scope="col">รหัสอู่ซ่อมรถ</th>
                <th scope="col">ชื่ออู่ซ่อมรถ</th>
                <th scope="col">ที่ตั้งอู่ซ่อมรถ</th>
                <th scope="col">บริษัทประกันที่ผูก</th>
                <th scope="col">รายละเอียด</th>
                <th scope="col">สถานะอู่</th>
                <th scope="col">อัพเดทสถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rows = mysqli_fetch_assoc($results)) { ?>
                <tr>
                    <th scope="row"> <?php echo $rows["garageID"]; ?> </th>
                    <td> <?php echo $rows["garageName"]; ?> </td>
                    <td> <?php echo $rows["country"]; ?> </td>
                    <td> <?php echo $rows["insurance"]; ?> </td>
                    <td> <a href="detail_infor_garage.php?garageID=<?php echo $rows["garageID"]?>">รายละเอียดอู่ซ่อมรถ</a></td>
                    <?php if ($rows["status"] == "พร้อมทำงาน") { ?>
                        <td style="color:green;"> <?php echo $rows["status"]; ?> </td>
                        <td>
                            <a class="btn btn-outline-danger" href="process_status_garage.php?garageID=<?php echo $rows["garageID"]; ?>">ปิดการใช้งาน</a>
                        </td>
                    <?php } else if ($rows["status"] == "ไม่สะดวกรับงาน") { ?>
                        <td style="color:red;"> <?php echo $rows["status"]; ?> </td>
                        <td>
                            <a class="btn btn-outline-danger" href="process_status_garage.php?garageID=<?php echo $rows["garageID"]; ?>">ปิดการใช้งาน</a>
                        </td>
                    <?php } else if ($rows["status"] == "ปิดให้บริการ") { ?>
                        <td style="color:black;"> <?php echo $rows["status"]; ?> </td>
                        <td>
                            <a class="btn btn-outline-danger" href="process_status_garage.php?garageID=<?php echo $rows["garageID"]; ?>">ปิดการใช้งาน</a>
                        </td>
                    <?php } else if ($rows["status"] == "ปิดการใช้งาน") { ?>
                        <td style="color:lightgray;"> <?php echo $rows["status"]; ?> </td>
                        <td>
                            <a class="btn btn-outline-success" href="process_status_garage.php?garageID=<?php echo $rows["garageID"]; ?>">เปิดการใช้งาน</a>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>