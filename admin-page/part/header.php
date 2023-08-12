<?php
require_once('../db/dbhelper.php');
$current_page = $_SERVER['PHP_SELF'];

if ($current_page != '/login.php') {

    if (isset($_SESSION['admin'])) {

        $admin = $_SESSION['admin'];
        $admin_id = $admin['user_id'];


        $sql = "SELECT * FROM users WHERE user_id = '$admin_id'";
        $check = executeSingleResult($sql);
        if ($check['token'] != '') {

            if ($_SESSION['tokens'] != $check['token']) {

                // Xóa phiên đăng nhập trước trên các thiết bị khác
                unset($_SESSION['admin']); // Xóa hết các biến session
                unset($_SESSION['tokens']); // Xóa hết các biến session
                echo '<script>
                alert("Login detected at a different location! Please log in again.")
                window.location.href = "../login.php";
                </script>';
            } else {
            }
            if ($check['status'] == 1) {
                unset($_SESSION['admin']); // Xóa hết các biến session
                unset($_SESSION['tokens']); // Xóa hết các biến session

                echo '<script>
                alert("You have been banned from accessing the website by the administrator.")
                window.location.href = "../login.php";
                </script>';
            }
        }
    }
}
if ($current_page != '/admin.php') {
    if (isset($_SESSION['admin'])) {
        $admin = $_SESSION['admin'];
        $admin_id = $admin['user_id'];
        $sql = "UPDATE users SET token_create_at = NOW() WHERE user_id = '$admin_id'";
        execute($sql);
    }
}
?>


<!-- header -->
<div class="top">
    <i class="uil uil-bars slidebar-toggle"></i>
    <div class="search-box">
        <!-- <i class="uil uil-search"></i>
        <input type="text" placeholder="Search here..."> -->
    </div>
    <img src="image/logo.png" alt="">
</div>