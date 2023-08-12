<?php
require_once('db/dbhelper.php');


if(isset($_SESSION['user'])){

    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
}
elseif (isset($_SESSION['user_token'])) {
    $user_token = $_SESSION['user_token'];
    $user = executeSingleResult("SELECT * FROM users WHERE token = '$user_token'");
    $user_id = $user['user_id'];

}



$current_page = $_SERVER['PHP_SELF'];

if ($current_page != '/user-login.php') {
    if (isset($_SESSION['user'])) {
        $user_id = $user['user_id'];


        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $check = executeSingleResult($sql);
        
        if ($check['token'] != '') {
            if ($_SESSION['token'] != $check['token']) {
              
                // Xóa phiên đăng nhập trước trên các thiết bị khác
                unset($_SESSION['user']); // Xóa hết các biến session
                unset($_SESSION['token']); // Xóa hết các biến session
                echo '<script>
                alert("Warning: Device Detected Logging In from Unrecognized Location !!!!")
                window.location.href = "login.php";
                </script>';
                $sql = "UPDATE users
                SET token = '', token_create_at ='' WHERE user_id = '$user_id'  " ;
                execute($sql);
            }
            if($check['status']==1){

                unset($_SESSION['user']); // Xóa hết các biến session
                unset($_SESSION['token']); // Xóa hết các biến session
                
                echo '<script>
                alert("You have been banned from accessing the website by the administrator.")
                window.location.href = "user-login.php";
                </script>';
                $sql = "UPDATE users
                SET token = '', token_create_at = null, lasttimeOnl = now() WHERE user_id = '$user_id'  " ;
                execute($sql);
            }
        }
    } 
    elseif(isset($_SESSION['user_token'])){
        // kiểm tra status;
                           $user_token = $_SESSION['user_token'];
                       $user = executeSingleResult("SELECT * FROM users WHERE token = '$user_token'");
                       $user_id = $user['user_id'];
                   if($user['status'] == 1){
                       unset($_SESSION['user_token']);
               
                       echo '<script>
                       alert("Log out !!!!")
                       window.location.href = "user-login.php";
                       </script>';

                       $sql = "UPDATE users
                       SET token_create_at = '' WHERE user_id = '$user_id'  " ;
                       execute($sql);
                   }
       }
}
if($current_page!='/index.php'){
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $user_id = $user['user_id'];
       $sql = "UPDATE users SET token_create_at= now() WHERE user_id = '$user_id'" ;
               execute($sql);
    }elseif(isset($_SESSION['user_token'])){
        $token = $_SESSION['user_token'];
        $sql = "SELECT * FROM users WHERE token = '$token'";
        $user = executeSingleResult($sql);
        $user_id = $user['user_id'];

        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $check = executeSingleResult($sql);
       $sql = "UPDATE users SET token_create_at = NOW() WHERE user_id = '$user_id'" ;
               execute($sql);
    }
  
    }


?>
<!-- navbar -->
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
                   
                <!-- dropdown -->
                <!-- Default dropend button -->

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Shop
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">mlem1</a></li>
                        <li><a class="dropdown-item" href="#">mlem1</a></li>
                        <li><a class="dropdown-item" href="shop.php">All</a></li>
                    </ul>
                </div>
                <!-- dropdown -->
                <div class="nav-item dropdown">
                <?php if(isset($user['email'])){ ?>
                    <a class="nav-link dropdown-toggle"  role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="uil uil-setting" style="color:white"></i>
                    <?php echo $user['email']; ?>
                    </a>
<?php if($user['Type']=='user'){ ?>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="user-changepassword.php">Change password</a></li>
                        <li><a class="dropdown-item" href="user.php">View Account</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                    <?php }else{?>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="user.php">View Account</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                    <?php } ?>
                    <?php } else { ?>
                        <a class="nav-link dropdown-toggle"  role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="uil uil-cog"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="user-login.php">Login</a></li>
                        <li><a class="dropdown-item" href="register.php">Resgister</a></li>
                    </ul>
                    <?php } ?>
                </div>
 

                
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">contact</a>
                    </li>
                    
                </ul>
            </div>
            
            <div class="icons">
                <i class='bx bx-user' style="width: 30px; color: aliceblue;"></i>
                <a href="lovelist.php"><i class='bx bx-heart' style="width: 30px; color: aliceblue;"></i></a>
                <a href="cart.php"><i class='bx bx-basket' style="width: 30px; color: aliceblue;"></i></a>
                <!-- <i class='bx bx-qr-scan' style="width: 30px; color: aliceblue;"></i> -->
            </div>
        </nav>
        <!-- navbar end -->
        