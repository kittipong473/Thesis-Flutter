<?php
require('include/connection.php');
?>

<?php
session_start();
$check = $_SESSION['username'];
$query = "SELECT * FROM supers WHERE username = '$check'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$superID = $row['superID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Garage Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
</head>

<body style="background-color:purple">
    <?php
    require('fragment/header.php');
    ?>
    <?php
    // if form submitted, insert values into database
    if (isset($_REQUEST['garageName'])) {
        $garageName = stripslashes($_REQUEST['garageName']);
        $garageName = mysqli_real_escape_string($conn, $garageName);
        $country = stripslashes($_REQUEST['country']);
        $country = mysqli_real_escape_string($conn, $country);
        $insurance = stripslashes($_REQUEST['insurance']);
        $insurance = mysqli_real_escape_string($conn, $insurance);
        $description = stripslashes($_REQUEST['description']);
        $description = mysqli_real_escape_string($conn, $description);

        if (isset($_REQUEST['urlPicture'])) {
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
                    header("Location: register_garage.php?error=$em");
                }
            } else {
                $em = "unknown error occurred";
                header("Location: register_garage.php?error=$em");
            }
        } else {
            $new_img_name = "default.png";
        }

        $sql = "INSERT INTO `garage`(`garageID`, `garageName`, `country`, `insurance`, `description`, `urlPicture`, `status`)
         VALUES (Null,'$garageName','$country','$insurance','$description','$new_img_name','ปิดให้บริการ')";

        $results = mysqli_query($conn, $sql);
        if ($results) {

            $sql2 = "UPDATE `supers` SET garageName = '$garageName' , status = 'ยังไม่มีข้อมูลพิกัด' WHERE superID = '$superID'";
            mysqli_query($conn, $sql2);

            echo '
            <script>
                setTimeout(function() {
                    swal({
                        title: "Register Successfully",
                        text: "ต่อไป: กรอกข้อมูล พิกัดอู่ซ่อมรถของคุณ",
                        type: "success"
                    }, function() {
                        window.location = "register_location.php";
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
        <?php
        $sqlIn = "SELECT * FROM insurance ORDER BY name ASC";
        $resultIn = mysqli_query($conn, $sqlIn);
        ?>
        <div class="container">
            <div class="login_area" style="height:800px;background-color:lightskyblue">
                <br><img src="image/mechanic.png" alt="" width="100px" height="100px">
                <h1>Insert Garage</h1><br>
                <form action="" method="post" name="addGarage" enctype="multipart/form-data">
                    <input type="text" name="garageName" placeholder="garageName" autocomplete="off" style="width:300px;padding:10px;" required><br><br>
                    <input type="text" name="country" placeholder="Country" style="width:300px;padding:10px;" required><br><br>
                    <select name="insurance" class="form-control" style="width:300px;padding:10px;margin: 0 auto;" required>
                        <option value="" selected="selected">ไม่ผูกกับบริษัทประกัน</option>
                        <?php while ($rowIn = mysqli_fetch_assoc($resultIn)) { ?>
                            <option value="<?php echo $rowIn['name'] ?>"><?php echo $rowIn['name'] ?></option>
                        <?php } ?>
                    </select><br>
                    <textarea name="description" autocomplete="off" placeholder="คำอธิบายเกี่ยวกับอู่สังกัด" style="width:300px;padding:10px;" rows="3" required></textarea><br><br><br>
                    <label for="urlPicture">เพิ่มรูปเกี่ยวกับอู่ซ่อมรถ</label><br><br>
                    <div class="col-md-6" style="margin: 0 auto">
                        <input style="width:80%" type="file" name="urlPicture" class="form-control-file"><br><br>
                    </div>
                    <button onclick="return confirm('ยืนยันข้อมูลหรือไม่')">Confirm</button>
                </form><br>
                <a href="index.php" class="btn btn-secondary btn-sm"> Back </a>
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