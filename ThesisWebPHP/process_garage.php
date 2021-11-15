<?php
include('include/auth.php');
require('include/connection.php');

$status = $_POST["status"];
$garageName = $_GET['garageName'];

$sql = "UPDATE `garage` SET status = '$status' WHERE garageName = '$garageName'";

$results = mysqli_query($conn,$sql);

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
';

if($results){
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
                })
            });
        </script>
    ';
}
?>