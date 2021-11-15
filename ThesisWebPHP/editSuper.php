<?php
include('include/auth.php');
require('include/connection.php');

$superID = $_POST["superID"];
$username = $_POST["username"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];

$sql = "UPDATE `supers` SET username = '$username', email = '$email', telephone = '$telephone' WHERE superID = '$superID'";

$results = mysqli_query($conn,$sql);

$_SESSION['username'] = $username;

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
                window.location = "infor_super.php";
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
                text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                type: "error"
            })
        });
    </script>
';
}
