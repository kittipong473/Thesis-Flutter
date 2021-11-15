<?php
include('include/auth.php');
require('include/connection.php');

$No = $_GET["No"];

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    ';


$sql = "DELETE FROM `event` WHERE No = '$No'";
$results = mysqli_query($conn, $sql1);

if($results){
    echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Delete Successfully",
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
                    title: "Delete Failed",
                    text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    type: "success"
                }, function() {
                    window.location = "update_status_list.php";
                })
            });
        </script>
    ';
}
?>
