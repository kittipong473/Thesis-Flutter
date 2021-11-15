<?php
include('include/auth.php');
require('include/connection.php');

$garageID = $_POST["garageID"];
$garageName = $_POST["garageName"];
$country = $_POST["country"];
$insurance = $_POST["insurance"];
$description = $_POST["description"];

if (isset($_FILES['urlPicture'])) {
    $img_name = $_FILES['urlPicture']['name'];
    $img_size = $_FILES['urlPicture']['size'];
    $tmp_name = $_FILES['urlPicture']['tmp_name'];
    $error = $_FILES['urlPicture']['error'];

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("profile", true) . '.' . $img_ex_lc;
            $img_upload_path = 'ICS/' . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);
        } else {
            $em = "You can't upload this type";
            header("Location: infor_garage.php?error=$em");
        }
    } else {
        $em = "unknown error occurred";
        header("Location: infor_garage.php?error=$em");
    }

    $sql = "UPDATE `garage` SET garageName = '$garageName', country = '$country', insurance = '$insurance', description = '$description', urlPicture='$new_img_name' WHERE garageID = '$garageID'";
    $results = mysqli_query($conn,$sql);
    
} else {
    $sql = "UPDATE `garage` SET garageName = '$garageName', country = '$country', insurance = '$insurance', description = '$description' WHERE garageID = '$garageID'";
    $results = mysqli_query($conn,$sql);
}

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
                    title: "Edit Successfully",
                    type: "success"
                }, function() {
                    window.location = "infor_garage.php";
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
?>