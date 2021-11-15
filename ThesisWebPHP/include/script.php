<script src="js/sweetalert.min.js"></script>

<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') { ?>
    <script>
        setTimeout(function() {
            swal({
                title: "<?php echo $_SESSION['status'] ?>",
                icon: "<?php echo $_SESSION['status_icon'] ?>",
                button: "OK",
            }, function() {
                window.location = $_SESSION['location'];
            })
        }, 3000);
    </script>
<?php
    unset($_SESSION['status']);
}
?>