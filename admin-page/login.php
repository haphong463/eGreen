<?php
session_start();
require_once('../db/dbhelper.php');
require_once '../vendor/autoload.php'; // Import thư viện firebase/php-jwt

use \Firebase\JWT\JWT;

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




if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $err = [];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $checkEmail = executeSingleResult($sql);


    if (empty($email)) {
        $err['email'] = 'Email is required';
    }
    if (empty($password)) {
        $err['password'] = 'password is required';
    }
    if (empty($checkEmail)) {
        $err['email'] = 'Email is not exist';
    } else {
        if (empty($password)) {
            $err['password'] = 'password is required';
        }
        $checkPass = password_verify($password, $checkEmail['password']);
        // echo $checkPass;
        // var_dump($checkEmail);
        if ($checkPass) {
            if($checkEmail["status"]!=1 && $checkEmail["role"]!=3){
                $admin_id = $checkEmail['user_id'];
                $secretKey = 'your_secret_key';
                $expirationTimeMinutes = 60; // Thời gian hết hạn token: 60 phút
                $token = createToken($secretKey, $expirationTimeMinutes);
                $_SESSION['tokens'] = $token;
                $sql = "UPDATE users SET token = '$token',token_create_at = NOW() WHERE user_id = '$admin_id'";
                execute($sql); 

            $_SESSION['admin'] = $checkEmail;
                header('location:index.php');
            }else{
                echo "<script>alert('you made a mistake with our website, you are banned from logging in for 1 day')</script>";
            }
        } else {
            $err['password'] = 'password is not correct';
        }
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>

    <!-- link Icon https://boxicons.com -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/login.css">
    <style>
        .has-error {
            color: red;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Login Admin</h1>
            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['email'])) ? $err['email'] : ''; ?></span>
                </div>
                <input class="input100" type="text" name="email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['password'])) ? $err['password'] : ''; ?></span>
                </div>
                <input class="input100" type="password" name="password" placeholder="Password" value="<?php echo isset($password) ? $password : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>
 
            <button type="submit" class="btn" name="login">Login</button>

           
        </form>
    </div>
</body>

</html>