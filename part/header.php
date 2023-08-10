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
                <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Shop
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php
                    require_once ('db/dbhelper.php');
                    $categories = executeResult("SELECT * FROM categories");
                    foreach ($categories as $c) {
                        echo '
                            <li><a class="dropdown-item" href="shop.php?cat_id=' . $c['category_id'] . '">' . $c['name'] . '</a></li>
                        
                        
                        ';
                    }

                    ?>
                </ul>
            </div>
            <!-- dropdown -->

            <?php
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                echo '
                        <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        ';
                //     $user_id = $user['user_id'];
                //     $sql1 = "SELECT COUNT(*) AS total FROM cart where user_id ='$user_id'";
                // $result = executeSingleResult($sql1);
                // $totalProducts = $result['total'];
                echo $user['username'];
                echo '
                        
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="new-pass.php">Change password</a></li>
                            <li><a class="dropdown-item" href="view-account.php">View Account</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                        
                        ';
            }



            ?>




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