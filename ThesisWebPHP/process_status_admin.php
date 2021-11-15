<?php
include('include/auth.php');
require('include/connection.php');

$adminID = $_GET["adminID"];

$sql = "SELECT status FROM admins WHERE adminID = '$adminID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    ';

if ($row['status'] == "อยู่ในระบบ") {
    $sql1 = "UPDATE `admins` SET status = 'ปิดการใช้งาน' WHERE adminID = '$adminID'";
    $result1 = mysqli_query($conn, $sql1);
    if($results1){
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Update Successfully",
                        type: "success"
                    }, function() {
                        window.location = "admin_list.php";
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
                    })
                });
            </script>
        ';
    }
} else if ($row['status'] == "ปิดการใช้งาน") {
    $sql1 = "UPDATE `admins` SET status = 'อยู่ในระบบ' WHERE adminID = '$adminID'";
    $result1 = mysqli_query($conn, $sql1);
    if($results1){
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Update Successfully",
                        type: "success"
                    }, function() {
                        window.location = "admin_list.php";
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
                    })
                });
            </script>
        ';
    }
}
