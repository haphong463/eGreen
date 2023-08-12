<?php
session_start();
// session_destroy();
// exit();
require_once('db/dbhelper.php');
require_once 'vendor/autoload.php'; // Import thư viện firebase/php-jwt
require_once 'config.php';

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
// google Login
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    // var_dump($token);
    // die();
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();


    $user_infor = [
        'email' => $google_account_info['email'],
        'full_name' => $google_account_info['name'],
        'verifiedEmail' => $google_account_info['verifiedEmail'],
        'token' => $google_account_info['id'],
    ];
    // print_r($user_infor);
    $sql = "SELECT * FROM users WHERE email ='{$user_infor['email']}' and Type='google'";
    $result = executeSingleResult($sql);
    if ($result) {
        $sql = "UPDATE users SET token_create_at = NOW() WHERE email = '{$user_infor['email']}'";
        execute($sql);
        $_SESSION['user_token'] = $user_infor['token'];
        // echo $_SESSION['user_token'];
        // exit;
        header('location:index.php');
    } else {
        $sql = "INSERT INTO users (email, fullname, Type, token,token_create_at,role) VALUES('{$user_infor['email']}', '{$user_infor['full_name']}', 'google','{$user_infor['token']}',now(),3)";
        // echo $sql;
        // exit();
        execute($sql);

        $_SESSION['user_token'] = $user_infor['token'];

        header('location: index.php');
    }
}
// 
$password = '';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $err = [];

    $sql = "SELECT * FROM users WHERE email='$email' and Type ='user'";
    $checkEmail = executeSingleResult($sql);
    // echo $checkEmail['status'];
    // die();
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;
   

    if (empty($email)) {
        $err['email'] = 'Email is required';
    }
    if (empty($password)) {
        $err['password'] = 'Password is required';
    }
    if (empty($checkEmail)) {
        $err['email'] = 'Email is not exist';
    } else {
        if ($checkEmail['status'] == 2) {
            $err['email'] = 'Email is not verified';
        } else {
            $checkPass = password_verify($password, $checkEmail['password']);

            if ($checkPass) {
                $admin_id = $checkEmail['user_id'];
                $secretKey = 'your_secret_key';
                $expirationTimeMinutes = 60; // Thời gian hết hạn token: 60 phút
                $token = createToken($secretKey, $expirationTimeMinutes);
                $sql = "UPDATE users SET token = '$token',token_create_at = NOW() WHERE user_id = '$admin_id'";
                execute($sql);

                $_SESSION['tokens'] = $token;
                $_SESSION['user'] = $checkEmail;

                if ($checkEmail['status'] != 1) {
                    // Người dùng đã xác thực qua email và không bị cấm truy cập
                    header('location:index.php');
                } else {
                    // Người dùng đã bị cấm truy cập
                    echo "<script>alert('you made a mistake with our website, you are banned from logging in for 1 day')</script>";
                }
            } else {
                $err['password'] = 'Password is not correct';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sigh in</title>

    <!-- link Icon https://boxicons.com -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/login.css">
    <style>
        .or-line {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .or-line::before,
        .or-line::after {
            content: "";
            flex-grow: 1;
            background-color: #000;
            height: 1px;
            margin: 0 10px;
        }
        .has-error {
            color: red;
        }
        .login-with-google-btn {
            width: 100%;
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 42px;
            border: none;
            cursor: pointer;
            border-radius: 9px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            color: #757575;
            font-size: 20px;
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 12px;
        }
.login-with-google-btn:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .login-with-google-btn:active {
            background-color: #eeeeee;
        }

        .login-with-google-btn:focus {
            outline: none;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Login</h1>
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
            <p class="text-center mt-2 or-line">
                            <span>or</span>
                        </p>
                        <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-outline-dark" href="<?php echo $client->createAuthUrl() ?>" role="button" style="text-transform:none">
                        <button type="button" class="login-with-google-btn" id="loginButton">Login with Google</button>                    </a>
                    
                </div>
            </div>
            <div class="register-link">
                <p>You don't have an account ? <a href="register.php">Register</a></p>
            </div>


        </form>
    </div>
</body>

</html>