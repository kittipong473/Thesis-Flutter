<?php
include('include/auth.php');
require('include/connection.php');

$adminID = $_POST["adminID"];
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];

$sql = "UPDATE `admins` SET username = '$username', password='" . md5($password) . "', email = '$email', telephone = '$telephone', status='อยู่ในระบบ' WHERE adminID = '$adminID'";

$results = mysqli_query($conn,$sql);

$_SESSION['username'] = $username;

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
                    title: "Confirm Successfully",
                    text: "Welcome to ICar Service Application"
                    type: "success"
                }, function() {
                    window.location = "index.php";
                })
            });
        </script>
    '; 
} else {
    echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Confirm Failed",
                    text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    type: "error"
                })
            });
        </script>
    ';
}
?>
