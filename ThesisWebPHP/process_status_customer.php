<?php
include('include/auth.php');
require('include/connection.php');

$customerID = $_GET["customerID"];

$sql = "SELECT status FROM customers WHERE customerID = $customerID";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    ';

if ($row['status'] == "อยู่ในระบบ") {
    $sql1 = "UPDATE `customers` SET status = 'ปิดการใช้งาน' WHERE customerID = '$customerID'";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1) {
        echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Update Successfully",
                    type: "success"
                }, function() {
                    window.location = "customer_list.php";
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
    $sql1 = "UPDATE `customers` SET status = 'อยู่ในระบบ' WHERE customerID = '$customerID'";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1) {
        echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Update Successfully",
                    type: "success"
                }, function() {
                    window.location = "customer_list.php";
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
?>