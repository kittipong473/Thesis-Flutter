<?php
include('include/auth.php');
require('include/connection.php');
?>

<?php
$garageID = $_GET["garageID"];

$sql = "SELECT * FROM garage WHERE garageID='$garageID'";
$results = mysqli_query($conn, $sql);

$rows = mysqli_fetch_assoc($results);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Garage_Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:purple">
    <?php
    require('fragment/header.php');
    ?>
    <?php
    $sqlIn = "SELECT * FROM insurance ORDER BY name ASC";
    $resultIn = mysqli_query($conn, $sqlIn);
    ?>
    <div class="container">
        <div class="login_area" style="height:1270px;margin:left;background-color:lightskyblue">
            <br>
            <h1>Garage Information</h1><br>
            <img src="<?php echo $_SESSION['URL'] ?>/project/ICS/<?php echo $rows['urlPicture'] ?>" alt="" width="300px" height="200px"><br><br><br>
            <form action="editGarage.php" method="POST" name="login">
                <div class="form-group">
                    <label for="garageName">Garage Name: </label>
                    <input type="text" name="garageName" value="<?php echo $rows['garageName'] ?>" autocomplete="off" style="width:200px;padding:10px;" readonly>
                </div><br>
                <div class="form-group">
                    <label for="country">Country: </label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <input type="text" name="country" value="<?php echo $rows['country'] ?>" autocomplete="off" style="width:200px;padding:10px;" readonly>
                </div><br>
                <div class="form-group">
                    <label for="country">Insurance: </label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <input type="text" name="insurance" value="<?php echo $rows['insurance'] ?>" autocomplete="off" style="width:200px;padding:10px;" readonly>
                </div><br>
                <div class="form-group">
                    <label for="description">Description: </label>
                    <textarea name="description" value="<?php echo $rows['description'] ?>" autocomplete="off" style="width:300px;padding:10px;" rows="5" readonly><?php echo $rows['description'] ?></textarea>
                </div><br><br>
                <div class=" row col-md-12">
                    <div class="form-group col-md-2.5" style="margin:auto">
                        <?php
                        $lat = $rows['lat'];
                        $lng = $rows['lng'];
                        ?>
                        <iframe width="520" height="400" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=th&amp;q=<?php echo $lat; ?>,<?php echo $lng; ?>&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.embed-map.net/'>.</a>
                        <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=234b0acce89c5e0d686aea67a16000bc0b628017'></script>
                    </div>
                </div><br>
            </form>
        </div>
    </div>
</body>
<?php
include('include/script.php');
?>

</html>