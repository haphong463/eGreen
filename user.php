<?php
session_start();
require_once('db/dbhelper.php');
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
    $sql = "SELECT * FROM users WHERE user_id='$user_id' and type='user'";
    $infor = executeSingleResult($sql);
} elseif (isset($_SESSION['user_token'])) {
    $user = $_SESSION['user_token'];
    $sql = "SELECT * FROM users WHERE token ='$user' and type='google'";
    $infor = executeSingleResult($sql);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>techWiz</title>
    <link rel="shortcut icon" type="image" href="img/meo.jpg">
    <!-- BStrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BStrap link -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/box.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->


</head>

<body>






    <?php
    include('part/header.php');
    ?>
    <!-- home Section -->
    <div class="home">

        <div class="header-row">
            <div class="header-row-inside">

                <h1 class="shopName">Your Info</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <!-- home Section End-->

    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="10000">
                            <img src="img/header/download.jpg" class="d-block w-100" style="height: 70vh;" alt="...">
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3 style="font-size: 100px;"><?php echo $infor['username']; ?></h3>
                <div class="rating">

                    <p class="text-left mr-4">
                    <p class="mr-2" style="color: #000;font-size:30px;">VIP <span style="color: #bbb;">1907 </span><span style="float: right;"><?php echo $infor['phone']; ?></span></p>
                    </p>

                </div>
                <p style="font-size: 40px;"><span><?php echo $infor['email']; ?></span></p>
                <p style="font-size: 40px;"><?php echo $infor['fullname']; ?></p>
                <p style="font-size: 40px;"><?php echo $infor['address']; ?></p>

                <p class="text-center" style="text-align: center;">
                    <a href="#" class="btn btn-outline-danger" style="width: 10%;float:right;"><i class='bx bxs-trash'></i></a>
                    <a href="userEdit.php" class="btn btn-outline-success" style="width: 89%;"><i class='bx bx-pencil'></i></a>
                </p>
            </div>




        </div>

    </div>




    <?php
    include('part/footer.php');
    ?>


    <a href="#" class="arrow">
        <i class='bx bx-up-arrow-alt'></i>
    </a>








    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>