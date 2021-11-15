<?php
include('include/auth.php');
require('include/connection.php');

echo '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
';

$superID = $_POST["superID"];
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];

if ($_POST['garageName'] != null || $_POST['garageName'] != "") {
    $garageName = $_POST['garageName'];
    $sqlCh = "SELECT * FROM garage WHERE garageName = '$garageName'";
    $resultCh = mysqli_query($conn, $sqlCh);
    $rowCh = mysqli_num_rows($resultCh);

    if ($rowCh == 1) {
        $sql = "UPDATE `supers` SET username = '$username', password='" . md5($password) . "', email = '$email', telephone = '$telephone', status='อยู่ในระบบ', garageName='$garageName' WHERE superID = '$superID'";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            echo '
                <script>
                    setTimeout(function() {
                        swal({
                            title: "Confirm Successfully",
                            text: "Welcome to ICar Service Application",
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
    } else {
        echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Confirm Failed",
                    text: "คุณไม่มีข้อมูล ชื่ออู่ซ่อมรถนี้ อยู่ในระบบ",
                    type: "error"
                }, function() {
                    window.location = "insert_infor_super.php";
                })
            });
        </script>
    ';
    }
} else {
    $sql = "UPDATE `supers` SET username = '$username', password='" . md5($password) . "', email = '$email', telephone = '$telephone', status='ยังไม่มีข้อมูลอู่' WHERE superID = '$superID'";
    $results = mysqli_query($conn, $sql);

    if ($results) {
        echo '
        <script>
            setTimeout(function() {
                swal({
                    title: "Confirm Successfully",
                    text: "ต่อไป: กรอกข้อมูล อู่ซ่อมรถของคุณ",
                    type: "success"
                }, function() {
                    window.location = "register_garage.php";
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
                }, function() {
                    window.location = "insert_infor_super.php";
                })
            });
        </script>
    ';
    }
}
