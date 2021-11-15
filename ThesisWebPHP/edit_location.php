<?php
include('include/auth.php');
require('include/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Location</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
</head>

<body style="background-color:lightgreen">
    <?php
    require('fragment/header.php');
    ?>
    <div class="container">
        <div class="login_area" style="height:320px;margin:left;">
            <br>
            <p> *กรุณาอนุญาตการเข้าถึงตำแหน่งก่อน* </p>
            <button id="location-button" style="width: 170px;">ระบุตำแหน่งปัจจุบัน</button>
            <br><br>
            <p id="show"></p>
            <button onclick="getLocation()" style="width: 150px;">บันทึก Location</button>

            <script>
                var x = document.getElementById("show");

                $('#location-button').click(function() {
                    //function showLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            console.log(position);
                        });
                    } else {
                        console.log("geolocation error");
                    }
                });

                function showPosition(position) {
                    x.innerHTML = "ละติจูด : " + position.coords.latitude +
                    "<br>ลองติจูด : " + position.coords.longitude +
                    "<br>อัลติจูด : " + position.coords.altitude +
                    "<br>ความแม่นยำ : " + position.coords.accuracy;
                    console.log(position);
                }
                
                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            $.ajax({
                                method: "POST",
                                url: "process_location.php",
                                data: {
                                    lat: lat,
                                    lng: lng
                                }
                            }).done(function(text) {
                                alert('Update Successfully');
                                header("location:infor_garage.php");
                            })
                        }, function() {
                            alert('เกิดข้อผิดพลาด2');
                        });
                    } else {
                        x.innerHTML = "Geolocation is not supported by this browser.";
                    }
                }
            </script>

        </div>
    </div>
</body>

</html>