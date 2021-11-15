<?php
    include('include/auth.php');
    require('include/connection.php');

$garageName = $_SESSION['garageName'];
echo $garageName;
if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $sql5 = "UPDATE `garage` SET `lat`='".$_POST['lat']."',`lng`='".$_POST['lng']."' WHERE `garageName` = '$garageName'";
    $results5 = mysqli_query($conn, $sql5);

    echo '
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    ';

    if($results5){
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Update Successfully",
                        type: "success"
                    }, function() {
                        window.location = "";
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
} else {
    echo "error latlng";
}
