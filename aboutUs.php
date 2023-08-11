<?php
require_once('db/dbhelper.php');
$sql = 'select * from about where id=1';
$about1 = executeResult($sql);

$sql = 'select * from about where id=2';
$about2 = executeResult($sql);
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


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->


</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
    }

    html {
        box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
        box-sizing: inherit;
    }

    .column {
        float: left;
        width: 33.3%;
        margin-bottom: 16px;
        padding: 0 8px;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        margin: 8px;
    }

    .about-section {
        padding: 50px;
        text-align: center;
        background-color: #474e5d;
        color: white;
    }

    .container {
        padding: 0 16px;
    }

    .container::after,
    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .title {
        color: grey;
    }

    .button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
    }

    .button:hover {
        background-color: #555;
    }

    @media screen and (max-width: 650px) {
        .column {
            width: 100%;
            display: block;
        }
    }

    /* .zom {
        width: 80%;
        height: 600px;


    }

    .zom img {
        width: 100%;
        height: 100%;
        transition-duration: 0.5s;
    }

    .zom img:hover {
        transform: scale(1.2);
    } */
</style>

<body>






    <?php
    include('part/header.php');
    ?>
    <!-- home Section -->
    <div class="home">

        <div class="header-row">
            <div class="header-row-inside">

                <h1 class="shopName">About</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <!-- home Section End-->
    <!-- <p style="font-size:50px;text-align: center;transition:0.5s;width:100%;height: 100%;">▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀</p> -->
<br><br><br><br>
    <!-- <p style="font-size: 100px; text-align: center;"><strong>#luxury</strong></p>
    <br><br>
    <a href="#">
        <div style="width:100%;height: 700px;">
            <p style="font-size:50px;" class="zom">
                <img src="img/header/download.jpg" alt="">
            </p>
        </div>
    </a> -->
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <img src="img/MOUNTAINS.jpg" alt="Jane" style="width:100%;height:380px;">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="container">
                        <?php
                    if ($about1 != null) {
                        foreach ($about1 as $row1) {
                    ?>
                            <h1><?php echo $row1['content']; ?></h1>
                            <p class="title"><b><?php echo $row1['phone']; ?></b></p>
                            <p><?php echo $row1['discription']; ?></p>
                            <p><?php echo $row1['email']; ?></p>
                            <?php
                        }
                    } else {
                        ?>
                        <p style="color:red;">no records found</p>
                    <?php
                    }
                    ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                    <div class="container">
                    <?php
                    if ($about2 != null) {
                        foreach ($about2 as $row2) {
                    ?>
                            <h1><?php echo $row2['content']; ?></h1>
                            <p class="title"><b><?php echo $row2['phone']; ?></b></p>
                            <p><?php echo $row2['discription']; ?></p>
                            <p><?php echo $row2['email']; ?></p>
                            <?php
                        }
                    } else {
                        ?>
                        <p style="color:red;">no records found</p>
                    <?php
                    }
                    ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <img src="img/wallpaper.jpg" alt="Jane" style="width:100%;height:380px;">
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <!-- <p style="font-size:50px;text-align: center;transition:0.5s;width:100%;height: 100%;">▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄</p> -->


    <?php
    include('part/footer.php');
    ?>











    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>