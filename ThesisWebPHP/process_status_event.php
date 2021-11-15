<?php
include('include/auth.php');
require('include/connection.php');

$No = $_GET["No"];

$sql = "SELECT status FROM event WHERE No = $No";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    ';

if ($row['status'] == "รับงานแล้ว") {
    $sql1 = "UPDATE `event` SET status = 'กำลังเดินทาง' WHERE No = '$No'";
    $result1 = mysqli_query($conn, $sql1);
} else if ($row['status'] == "กำลังเดินทาง") {
    $sql1 = "UPDATE `event` SET status = 'กำลังทำงาน' WHERE No = '$No'";
    $result1 = mysqli_query($conn, $sql1);
} else if ($row['status'] == "กำลังทำงาน") {
    $sql1 = "UPDATE `event` SET status = 'เสร็จสิ้น' WHERE No = '$No'";
    $result1 = mysqli_query($conn, $sql1);

}
if($result1){
    echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Update Successfully",
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
                    title: "Update Failed",
                    text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    type: "error"
                }, function() {
                    window.location = "update_status_list.php";
                })
            });
        </script>
    ';
}
?>
