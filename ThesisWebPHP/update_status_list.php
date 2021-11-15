<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php

$garageName = $_SESSION['garageName'];

$sql = "SELECT * FROM event WHERE garage ='$garageName' AND status != 'รอรับงาน' AND status != 'เสร็จสิ้น'";
$results = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update_Status Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    require('fragment/header.php');
    ?><br>
    <form action="process_garage.php?garageName=<?php echo $garageName ?>" class="form-inline" method="POST">
        <div class="row col-md-12">
            <div class="form-group col-md-4" style="margin:auto">
                <?php if ($row0["status"] == "พร้อมทำงาน") { ?>
                    <label for="status" style="color:green;"> สถานะอู่ซ่อมรถของคุณ : <?php echo $row0["status"]; ?> &nbsp;&nbsp;&nbsp;</label>
                <?php } else if ($row0["status"] == "ไม่สะดวกรับงาน") { ?>
                    <label for="status" style="color:red;"> สถานะอู่ซ่อมรถของคุณ : <?php echo $row0["status"]; ?> &nbsp;&nbsp;&nbsp;</label>
                <?php } else if ($row0["status"] == "ปิดให้บริการ") { ?>
                    <label for="status" style="color:black;"> สถานะอู่ซ่อมรถของคุณ : <?php echo $row0["status"]; ?> &nbsp;&nbsp;&nbsp;</label>
                <?php } else if ($row0["status"] == "ปิดการใช้งาน") { ?>
                    <label for="status" style="color:blue;"> สถานะอู่ซ่อมรถของคุณ : ถูก<?php echo $row0["status"]; ?>โดย Admin</label>
                <?php } ?>
                <?php if($row0["status"] != "ปิดการใช้งาน") {?>
                    <select class="form-control" name="status">
                        <option selected>--เลือกสถานะ--</option>
                        <option value="พร้อมทำงาน" style="color:green;">พร้อมทำงาน</option>
                        <option value="ไม่สะดวกรับงาน" style="color:red;">ไม่สะดวกรับงาน</option>
                        <option value="ปิดให้บริการ" style="color:lightgray;">ปิดให้บริการ</option>
                    </select>
                    <button type="submit">ยืนยัน</button>
                <?php } ?>
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
                <th scope="col">ข้อมูลเพิ่มเติม</th>
                <th scope="col">สถานะ</th>
                <th scope="col">อัพเดทสถานะ</th>
                <th scope="col">ยกเลิกข้อมูล</th>
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
                    <td><a href="detail_update_status.php?No= <?php echo $rows["No"]; ?>">แสดงข้อมูลเพิ่มเติม</a></td>
                    <td class="btn btn-secondary btn-md"> <?php echo $rows["status"]; ?> </td>
                    <?php if ($rows["status"] == "รับงานแล้ว") { ?>
                    <td>
                        <a class="btn btn-outline-warning" href="process_status_event.php?No=<?php echo $rows["No"]; ?>" onclick="return confirm('ยืนยันการอัพเดทหรือไม่')">กำลังเดินทาง</a>
                    </td>
                    <?php } else if ($rows["status"] == "กำลังเดินทาง") { ?>
                    <td>
                        <a class="btn btn-outline-danger" href="process_status_event.php?No=<?php echo $rows["No"]; ?>" onclick="return confirm('ยืนยันการอัพเดทหรือไม่')">กำลังทำงาน</a>
                    </td>
                    <?php } else if ($rows["status"] == "กำลังทำงาน") { ?>
                    <td>
                        <a class="btn btn-outline-success" href="process_status_event.php?No=<?php echo $rows["No"]; ?>" onclick="return confirm('ยืนยันการอัพเดทหรือไม่')">เสร็จสิ้น</a>
                    </td> 
                    <?php } ?>
                    <td>
                        <input class="btn btn-primary" type="button" href="process_status_decline.php?No=<?php echo $rows["No"]; ?>" onclick="return confirm('ยืนยันการยกเลิกหรือไม่')" value="ยกเลิก event">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>