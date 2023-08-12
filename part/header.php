<?php
require_once('db/dbhelper.php');
// $user['username'] ='';

if (isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
} elseif (isset($_SESSION['user_token'])) {
    $user_token = $_SESSION['user_token'];
    $user = executeSingleResult("SELECT * FROM users WHERE token = '$user_token'");
    // var_dump($user);
    // die();
}



$current_page = $_SERVER['PHP_SELF'];

if ($current_page != '/user-login.php') {


    if (isset($_SESSION['user'])) {

        $user = $_SESSION['user'];
        $user_id = $user['user_id'];


        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $check = executeSingleResult($sql);

        if ($check['token'] != '') {

            if ($_SESSION['tokens'] != $check['token']) {

                // Xóa phiên đăng nhập trước trên các thiết bị khác
                unset($_SESSION['admin']); // Xóa hết các biến session
                unset($_SESSION['tokens']); // Xóa hết các biến session
                echo '<script>
                alert("Login detected at a different location! Please log in again.")
                window.location.href = "user-login.php";
                </script>';
            } else {
            }
            if ($check['status'] == 1) {

                unset($_SESSION['admin']); // Xóa hết các biến session
                unset($_SESSION['tokens']); // Xóa hết các biến session

                echo '<script>
                alert("You have been banned from accessing the website by the administrator.")
                window.location.href = "user-login.php";
                </script>';
                $sql = "UPDATE users
                SET token = '', token_create_at = null, lasttimeOnl = now() WHERE user_id = '$user_id'  ";
                execute($sql);
            }
        }
    } elseif (isset($_SESSION['user_token'])) {
        // kiểm tra status;
        $user_token = $_SESSION['user_token'];
        $user = executeSingleResult("SELECT * FROM users WHERE token = '$user_token'");
        $user_id = $user['user_id'];
        if ($user['status'] == 1) {
            unset($_SESSION['user_gmail']);
            echo '<script>
                       alert("Log out !!!!")
                       window.location.href = "user-login.php";
                       </script>';
            $sql = "UPDATE users
                       SET token_create_at ='' WHERE user_id = '$user_id'  ";
            execute($sql);
        }
    }
}
if ($current_page != '/index.php') {
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $user_id = $user['user_id'];
        $sql = "UPDATE users SET token_create_at= now() WHERE user_id = '$user_id'";
        execute($sql);
    }
}


?><!-- navbar -->
<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }
    a{
        text-decoration: none;
    }
    .nav-link {
        color: #fff !important;
        font-weight: bold;
        text-shadow: none;
        margin-left: 15px;
        text-transform: uppercase;
    }

    .nav-link:hover {
        background: unset;
    }
</style>
<nav class="navbar navbar-expand-md" id="navbar" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php" id="logo">
        TechWiz
    </a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span>
            <i class='bx bx-expand' style="width: 30px; color: aliceblue;"></i>
        </span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <!-- dropdown -->
            <!-- Default dropend button -->

            <div class="dropdown">
                <a href="shop.php">
                    <button class="btn btn-outline-success dropdown-toggle nav-link" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">
                        Shop
                    </button>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php
                    $categories = executeResult("SELECT * FROM categories");
                    foreach ($categories as $c) {
                        echo '
                            <li><a class="dropdown-item" href="shop.php?cat_id=' . $c['category_id'] . '">' . $c['name'] . '</a></li>
                        
                        
                        ';
                    }

                    ?>
                </ul>
            </div>

            <div class="dropdown">
                <a href="accessory.php">
                    <button class="btn btn-outline-success dropdown-toggle nav-link" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">
                        Accessory
                    </button>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php
                    require_once('db/dbhelper.php');
                    $categories = executeResult("SELECT * FROM categories_ac");
                    foreach ($categories as $c) {
                        echo '
                            <li><a class="dropdown-item" href="accessory.php?cat_id=' . $c['category_id'] . '">' . $c['name'] . '</a></li>
                        
                        
                        ';
                    }

                    ?>
                </ul>
            </div>

            <li class="nav-item">
                <a class="nav-link" href="contact.php">contact</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="Blog.php">Blog</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="aboutUs.php">About us</a>
            </li>

        </ul>
    </div>
    <div class="icons">

        <?php
        if (isset($_SESSION['user']) || isset($_SESSION['user_token'])) {
            echo '
        

        <a href="orders.php"><i class=\'bx bx-user\' style="width: 30px; color: aliceblue;"></i></a>
        <a href="lovelist.php"><i class=\'bx bx-heart\' style="width: 30px; color: aliceblue;"></i></a>
        <a href="cart.php"><i class=\'bx bx-basket\' style="width: 30px; color: aliceblue;"></i></a>
        <!-- <i class=\'bx bx-qr-scan\' style="width: 30px; color: aliceblue;"></i> -->
        
        ';
        } else {
            echo '
        
            <a class="nav-link" style="margin-right:20px;" href="user-login.php">login</a>
        
        1';
        }

        ?>
    </div>

</nav>
<!-- navbar end -->