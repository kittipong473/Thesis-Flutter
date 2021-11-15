<?php
include('include/auth.php');
require('include/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv=Content-Type content=”text/html; charset=utf-8″>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Supervisor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:purple">
    <?php
    // if form submitted, insert values into database
    if (isset($_REQUEST['username'])) {
        $superID = stripslashes($_REQUEST['superID']);
        $superID = mysqli_real_escape_string($conn, $superID);
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "INSERT INTO supers (superID,username,password,status)
                    VALUES ('$superID','$username','" . md5($password) . "','รอการกรอกข้อมูล')";

        $result = mysqli_query($conn, $query);
        if ($result) {
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Register Successfully",
                        type: "success"
                    }, function() {
                        window.location = "super_list.php";
                    })
                });
            </script>
        ';
        } else {
        echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Register Failed",
                        text: "มีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                        type: "error"
                    })
                });
            </script>
        ';
        }
    } else {
    ?>
        <div class="container">
            <div class="login_area" style="height:510px;background-color:lightskyblue">
                <br><img src="image/mechanic.png" alt="" width="100px" height="100px">
                <h1>Insert Supervisor</h1><br>
                <form action="" method="post" name="addAdmin">
                    <input type="text" name="superID" placeholder="ID" style="width:100px;padding:10px;" maxlength="4" required><br><br>
                    <input type="text" name="username" placeholder="Username" style="width:200px;padding:10px;" autocomplete="off" maxlength="10" required><br><br>
                    <input type="password" name="password" placeholder="Password" style="width:200px;padding:10px;" autocomplete="off" maxlength="10" required><br><br><br>
                    <button>Confirm</button>
                </form><br>
                <a href="index.php" style="margin-right: 20px;"> Back </a>
            </div>
        </div>
    <?php } ?>

    <?php
    echo '
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
        ';
    ?>

</body>

</html>