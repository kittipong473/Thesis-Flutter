<?php
    include('include/auth.php');
    require('include/connection.php');

    $date = stripslashes($_REQUEST['date']);
    $date = mysqli_real_escape_string($conn, $date);
    $eventName = stripslashes($_REQUEST['eventName']);
    $eventName = mysqli_real_escape_string($conn, $eventName);
    $carType = stripslashes($_REQUEST['carType']);
    $carType = mysqli_real_escape_string($conn, $carType);
    $name = stripslashes($_REQUEST['name']);
    $name = mysqli_real_escape_string($conn, $name);
    $telephone = stripslashes($_REQUEST['telephone']);
    $telephone = mysqli_real_escape_string($conn, $telephone);
    $insurance = stripslashes($_REQUEST['insurance']);
    $insurance = mysqli_real_escape_string($conn, $insurance);

    if(isset($_FILES['urlPicture'])) {
        $img_name = $_FILES['urlPicture']['name'];
        $img_size = $_FILES['urlPicture']['size'];
        $tmp_name = $_FILES['urlPicture']['tmp_name'];
        $error = $_FILES['urlPicture']['error'];
    
        if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
    
                $allowed_exs = array("jpg", "jpeg", "png");
    
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("event",true).'.'.$img_ex_lc;
                    $img_upload_path = 'ICS/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    $em = "You can't upload this type";
                    header("Location: inform_super.php?error=$em");
                }
        } else {
            $em = "unknown error occurred";
            header("Location: inform_super.php?error=$em");
        }
    }

    $sql = "INSERT INTO `event`(`No`, `date`, `eventName`, `carType`, `name`, `telephone`, `insurance`, `urlPicture`, `lat`, `lng`, `garage`, `status`) VALUES (Null,'$date','$eventName','$carType','$name','$telephone','$insurance','$new_img_name',Null,Null,Null,'รอการยืนยัน')";

    $results = mysqli_query($conn, $sql);

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
                        title: "Inform Successfully",
                        type: "success"
                    }, function() {
                        window.location = "inform_super";
                    })
                });
            </script>
        '; 
    } else {
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Inform Failed",
                        type: "error"
                    })
                });
            </script>
        ';
    }
?>
