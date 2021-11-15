<?php
include('include/auth.php');
require('include/connection.php');
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:purple">
    <?php
    require('fragment/header.php');
    ?>
    <div class="container">
        <div class="login_area" style="height:650px;margin:left">
            <br><img src="image/mechanic.png" alt="" width="100px" height="100px">
            <h1>Confirm Information</h1><br>
            <form action="confirm_admin.php" method="POST">
                <input type="hidden" name="adminID" value="<?php echo $row['adminID'] ?>">
                <div class="form-group">
                    <label for="username">Username : </label>
                    <input type="text" name="username" value="<?php echo $row['username'] ?>" autocomplete="off" maxlenght="10" style="width:300px;padding:10px;" required><br><br>
                </div>
                <div class="form-group">
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password" autocomplete="off" maxlenght="10" style="width:240px;padding:10px;" required>
                    <input type="checkbox" onchange="myFunction(this)"><span id="showhide">Show</span><br><br>
                </div>
                <div class="form-group">
                    <label for="email">Email : </label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <input type="email" name="email" maxlenght="50" style="width:300px;padding:10px;" required><br><br>
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone : </label>
                    <input type="number" name="telephone" style="width:300px;padding:10px;" maxlength="10" required><br><br><br>
                </div>
                <button style="width: auto;" onclick="return confirm('ยืนยันข้อมูลหรือไม่')">Confirm Information</button>
            </form>
        </div>
    </div>

    <script>
        function myFunction(x) {
            var checkbox = x.checked;
            if (checkbox) {
                document.getElementById("password").type = "text";
                document.getElementById("showhide").textContent = "Hide";
            } else {
                document.getElementById("password").type = "password";
                document.getElementById("showhide").textContent = "Show";
            }
        }
    </script>

</body>

</html>