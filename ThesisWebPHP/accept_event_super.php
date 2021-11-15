<?php
include('include/auth.php');
require('include/connection.php');

$No = $_SESSION["No"];

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
';

if(isset($_POST['accept'])){
    $sql = "UPDATE `event` SET status = 'รับงานแล้ว' WHERE No = '$No'";
    $results = mysqli_query($conn,$sql);

    if($results){
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Accept Successfully",
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
                        title: "Accept Failed",
                        text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                        type: "error"
                    })
                });
            </script>
        ';
    }

} else if(isset($_POST['decline'])){
    $sql = "UPDATE `event` SET garageName = NULL, status = 'รอการยืนยัน' WHERE No = '$No'";
    $results = mysqli_query($conn,$sql);

    if($results){
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Decline Successfully",
                        type: "success"
                    }, function() {
                        window.location = "event_super.php";
                    })
                });
            </script>
        '; 
    } else {
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Decline Failed",
                        text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                        type: "error"
                    })
                });
            </script>
        ';
    }

}
?>