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
    $user_id = $infor['user_id'];
}
if (isset($_POST['change'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $sql = "UPDATE users SET fullname ='$fullname', address='$address',phone='$phone' WHERE user_id='$user_id' ";
    execute($sql);
    header("location:user.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

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

        <h1>Change Information</h1>
        <form action="" method="post">
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-box">
                        <input type="text" name="fullname" placeholder="fullname" value="<?php echo $infor['fullname'] ?>">
                        <i class='bx bxs-envelope'></i>
                    </div>
                </div>
            </div>
            <div class="input-box col-lg-6">
                <input type="text" name="address" placeholder="Address" value="<?php echo $infor['address'] ?>">
                <i class='bx bxs-phone'></i>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="input-box">
                        <input type="text" name="phone" placeholder="Phone" value="<?php echo $infor['phone'] ?>">
                        <i class='bx bxs-user'></i>
                    </div>
                </div>
            </div>
            <br>


            <button type="submit" class="btn" name="change">Change</button>

        </form>
    </div>
</body>

</html>