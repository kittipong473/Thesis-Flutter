<?php
include('include/auth.php');
require('include/connection.php');

$status = $_GET["status"];
$No = $_SESSION["No"];

$sql = "UPDATE `event` SET status = '$status' WHERE No = '$No'";

$results = mysqli_query($conn,$sql);

if($results){
    echo '
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    ';
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