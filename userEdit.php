<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sigh up</title>

    <!-- link Icon https://boxicons.com -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    
    <!-- BStrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BStrap link -->
</head>

<body>
<?php
    include('part/header.php');
    ?>
    <div class="wrapper">
        <form action="">
            <h1>Change Information</h1>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-box">
                        <input type="text" placeholder="Username">
                        <i class='bx bxs-user'></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-box">
                        <input type="email" placeholder="Email">
                        <i class='bx bxs-envelope'></i>
                    </div>
                </div>
            </div>




            <div class="input-box">
                <input type="text" placeholder="Address">
                <i class='bx bxs-phone'></i>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-box">
                        <input type="text" placeholder="Phone">
                        <i class='bx bxs-user'></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-box">
                        <input type="password" placeholder="Password">
                        <i class='bx bxs-envelope'></i>
                    </div>
                </div>
            </div>
            <br>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <!-- <a href="#">Automatic Password</a> -->
            </div>

            <button type="submit" class="btn">Change</button>

        </form>
    </div>
</body>

</html>