<?php
    error_reporting(0);
?>
<style>
    .nav-item {
        color: black;
        font-size: 16px;
        border: none;
        cursor: pointer;
        margin-left: 50px;
    }

    .dropdown-toggle {
        background-color: lightskyblue;
        padding: 10px;
        border: none;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: lightskyblue
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropdown-toggle {
        background-color: #0080FF;
    }

    .nav-item:hover {
        background-color: #0080FF;
    }
</style>

<?php if ($_SESSION['role'] == "admin") { ?>

    <?php
    $sqlE = "SELECT * FROM event WHERE garage IS NULL AND `status`!='ปฏิเสธจาก Admin'";
    $resultE = mysqli_query($conn, $sqlE);
    $count = mysqli_num_rows($resultE);
    ?>

    <?php
    $check = $_SESSION['username'];
    $query = "SELECT * FROM admins WHERE username = '$check'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);
    ?>

    <?php if ($row['status'] == "รอการกรอกข้อมูล") { ?>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: lightskyblue;" aria-label="Toggle navigation">
            <h1>Administrator</h1>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" style="color:black;" href="insert_infor_admin.php">ยืนยัน/แก้ไขข้อมูล</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle user" aria-haspopup="true">ผู้ใช้งาน: <?php echo $_SESSION['username']; ?></button>
                            <div class="dropdown-content">
                                <a href="logout.php" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่')">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    <?php } else { ?>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: lightskyblue;" aria-label="Toggle navigation">
            <h1>Administrator</h1>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="event_admin.php">
                            <img src="image/noti.png" width="30" height="30" alt="เหตุการณ์" loading="lazy">
                            <i class="fas fa-envelope"></i> <span class="badge badge-danger" id="count"><?php echo $count; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:black;" href="status.php">สถานะการทำงาน</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" aria-haspopup="true">ข้อมูลต่างๆ</button>
                            <div class="dropdown-content">
                                <a href="garage_list.php">ข้อมูลอู่ซ่อมรถ</a>
                                <a href="customer_list.php">ข้อมูลลูกค้า</a>
                                <a href="super_list.php">ข้อมูล Supervisor</a>
                                <a href="event_list.php">ข้อมูลเหตุการณ์</a>
                                <?php if ($row['status'] == "หัวหน้าผู้ดูแล") { ?>
                                    <a href="admin_list.php">ข้อมูล Administrator</a>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" aria-haspopup="true">เพิ่ม Account Users</button>
                            <div class="dropdown-content">
                                <?php if ($row['status'] == "หัวหน้าผู้ดูแล") { ?>
                                    <a href="register_admin.php">Admin</a>
                                <?php } ?>
                                <a href="register_super.php">Supervisor</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle user" aria-haspopup="true">ผู้ใช้งาน: <?php echo $_SESSION['username']; ?></button>
                            <div class="dropdown-content">
                                <a href="infor_admin.php">ข้อมูลส่วนตัว</a>
                                <a href="logout.php" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่')">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    <?php } ?>
<?php } ?>

<?php if ($_SESSION['role'] == "super") { ?>
    <?php
    $check = $_SESSION['username'];
    $query = "SELECT * FROM supers WHERE username = '$check'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['superID'] = $row['superID'];

    if ($row['garageName'] != Null || $row['garageName'] != '') {
        $garageName = $row['garageName'];
        $query0 = "SELECT * FROM garage WHERE garageName = '$garageName'";
        $result0 = mysqli_query($conn, $query0);
        $row0 = mysqli_fetch_assoc($result0);
        $_SESSION['garageName'] = $garageName;
        $_SESSION['garageID'] = $row0['garageID'];

        $sqlE = "SELECT * FROM event WHERE status='รอรับงาน' AND garage ='$garageName'";
        $resultE = mysqli_query($conn, $sqlE);
        $count = mysqli_num_rows($resultE);
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: lightskyblue;" aria-label="Toggle navigation">
        <h1>Supervisor</h1>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <?php if ($row['status'] == "รอการกรอกข้อมูล") { ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color:black;" href="insert_infor_super.php">ยืนยัน/แก้ไขข้อมูล</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle user" aria-haspopup="true">ผู้ใช้งาน: <?php echo $_SESSION['username']; ?></button>
                            <div class="dropdown-content">
                                <a href="logout.php" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่')">Logout</a>
                            </div>
                        </div>
                    </li>
                <?php } else if ($row['status'] == "ยังไม่มีข้อมูลอู่") { ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color:black;" href="register_garage.php">เพิ่มข้อมูลอู่ซ่อมรถ</a>
                    <li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle user" aria-haspopup="true">ผู้ใช้งาน: <?php echo $_SESSION['username']; ?></button>
                            <div class="dropdown-content">
                                <a href="infor_super.php">ข้อมูลส่วนตัว</a>
                                <a href="logout.php" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่')">Logout</a>
                            </div>
                        </div>
                    </li>
                <?php } else if ($row['status'] == "ยังไม่มีข้อมูลพิกัด") { ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color:black;" href="register_location.php">เพิ่มตำแหน่งอู่ซ่อมรถ</a>
                    <li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle user" aria-haspopup="true">ผู้ใช้งาน: <?php echo $_SESSION['username']; ?></button>
                            <div class="dropdown-content">
                                <a href="infor_super.php">ข้อมูลส่วนตัว</a>
                                <a href="logout.php" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่')">Logout</a>
                            </div>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item active">
                        <a class="navbar-brand" href="event_super.php">
                            <img src="image/noti.png" width="30" height="30" alt="เหตุการณ์" loading="lazy">
                            <i class="fas fa-envelope"></i> <span class="badge badge-danger" id="count"><?php echo $count; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:black;" href="update_status_list.php">อัพเดทสถานะการทำงาน</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" aria-haspopup="true">ข้อมูลต่างๆ</button>
                            <div class="dropdown-content" aria-labelledby="navbarDropdown">
                                <a href="customer_list.php">ข้อมูลลูกค้า</a>
                                <a href="event_list.php">ข้อมูลเหตุการณ์</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" aria-haspopup="true">ข้อมูลอู่สังกัด: <?php echo $_SESSION['garageName'] ?> / สถานะ: <?php echo $row0['status'] ?></button>
                            <div class="dropdown-content" aria-labelledby="navbarDropdown">
                                <a href="infor_garage.php">ข้อมูลเกี่ยวกับอู่ซ่อมรถ</a>
                                <a href="edit_location2.php">ข้อมูลตำแหน่ง Location</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle user" aria-haspopup="true">ผู้ใช้งาน: <?php echo $_SESSION['username']; ?></button>
                            <div class="dropdown-content">
                                <a href="infor_super.php">ข้อมูลส่วนตัว</a>
                                <a href="logout.php" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่')">Logout</a>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
<?php } ?>