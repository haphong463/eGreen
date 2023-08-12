<?php
session_start();
require_once('../db/dbhelper.php');
require_once '../vendor/autoload.php'; // Import thư viện firebase/php-jwt

use \Firebase\JWT\JWT;

if (isset($_POST['add'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $err = [];
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Tạo mã token
    function createToken($secretKey, $expirationTimeMinutes)
    {
        // Lấy thời gian hiện tại
        $currentTime = time();
        // Tính thời gian hết hạn
        $expirationTime = $currentTime + ($expirationTimeMinutes * 60);

        // Tạo payload (dữ liệu chứa trong token)
        $payload = array(
            'user_id' => '1234567890',  // Thông tin cần lưu trữ trong token
            'exp' => $expirationTime  // Thời gian hết hạn của token
        );

        // Tạo mã token với secret key
        $jwtBuilder = new JWT();
        $token = $jwtBuilder->encode($payload, $secretKey, 'HS256');

        return $token;
    }
    $secretKey = 'your_secret_key';
    $expirationTimeMinutes = 60; // Thời gian hết hạn token: 60 phút
    $token = createToken($secretKey, $expirationTimeMinutes);
    $sql = "INSERT INTO users (email,password,phone,role,token) VALUES ('$email','$pass','$phone','$role','$token')";
    execute($sql);
    header('location:admin.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Admin Dashboard Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>
        <br><br><br><br><br><br>
        <h1>Add Employee</h1>
        <div class="table-responsive">
            <div class="product-physical">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Email :</label>
                        <input id="name" class="form-control" type="text" name="email">
                    </div>
                    <div class="form-group">
                        <label for="name">Password :</label>
                        <input id="name" class="form-control" type="text" name="password">
                    </div>
                    <div class="form-group">
                        <label for="name">Phone :</label>
                        <input id="name" class="form-control" type="text" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="name">Role :</label>
                        <input id="name" class="form-control" type="number" name="role" value="2" readonly>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="add">add</button>
                </form>
            </div>
        </div>



        <script src="script.js"></script>
</body>

</html>