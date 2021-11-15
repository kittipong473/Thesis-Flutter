<!DOCTYPE html>
<html lang="en">
<?php error_reporting(0); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICar Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: lightskyblue;
            background-size: cover;
            background-position: center;
            margin: 0 auto;
            padding: 0;
            font-family: sans-serif;
        }

        .login_area {
            width: 600px;
            margin: 5% auto;
            padding: 50px 0;
            background: white;
            box-shadow: 0 0 10;
            text-align: center;
            transition: all 0.3s ease;
        }

        .login_area button {
            padding: 10px;
            width: 100px;
            background: rgb(31, 168, 192);
            text-transform: uppercase;
            cursor: pointer;
        }

        .login_area button:hover {
            background: rgb(88, 123, 240);
            color: black;
            border: 2px solid black;
        }

        .login_area a:hover {
            color: black;
        }

        .input-box {
            margin: 30px auto;
            width: 60%;
            padding: 10px;
            border: 1px solid #000;
            padding: 10 10px;
            font-size: 1rem;
        }

        .input-box input {
            width: 90%;
            border: none;
            outline: none;
            background: transparent;
            color: #000;
        }
    </style>
</head>

<body>
    <?php
    require('include/connection.php');
    session_start();

    if (isset($_POST['username'])) {
        // removes backslahes
        $username = stripslashes($_REQUEST['username']);
        //escape special characters in a string
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $role = stripslashes($_REQUEST['role']);
        $role = mysqli_real_escape_string($conn, $role);

        // Checking is user existing in the database or not
        if ($role == "admin") {
            $query = "SELECT * FROM admins WHERE username='$username' AND password='" . md5($password) . "'";
        } else if ($role == "super") {
            $query = "SELECT * FROM supers WHERE username='$username' AND password='" . md5($password) . "'";
        }
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);
        $rowC = mysqli_fetch_assoc($result);

        if ($rowC['status'] == "ปิดการใช้งาน") {
            echo '
                <script>
                    setTimeout(function() {
                        swal({
                            title: "Login Failed",
                            text: "Your account is unable to use",
                            type: "error"
                        }, function() {
                            window.location = "login.php";
                        })
                    });
                </script>
            ';
        } else if ($rows == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            echo '
                <script>
                    setTimeout(function() {
                        swal({
                            title: "Login Successfully",
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
                            title: "Login Failed",
                            text: "Incorrect Username or Password or Role selected",
                            type: "error"
                        }, function() {
                            window.location = "login.php";
                        })
                    });
                </script>
            ';
        }
    } else {

    ?>

        <div class="container">
            <div class="login_area">
                <br><img src="image/mechanic.png" alt="" width="100px" height="100px">
                <h1>ICar Service</h1><br><br>
                <form action="" method="POST" name="login">
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" autocomplete="off" maxlenght="10" required>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" maxlenght="10" required>
                    </div>
                    <input type="checkbox" style="text-align:center;" onchange="myFunction(this)"><span id="showhide">Show Password</span><br><br><br>

                    <script>
                        function myFunction(x) {
                            var checkbox = x.checked;
                            if (checkbox) {
                                document.getElementById("password").type = "text";
                                document.getElementById("showhide").textContent = "Hide Password";
                            } else {
                                document.getElementById("password").type = "password";
                                document.getElementById("showhide").textContent = "Show Password";
                            }
                        }
                    </script>

                    <select name="role" class="form-control" style="width:200px;padding:10px;" required>
                        <option value="" selected="selected">- Select Role -</option>
                        <option value="admin">Administrator</option>
                        <option value="super">Supervisor</option>
                    </select><br><br><br>
                    <button>SIGN IN</button>
                </form>
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