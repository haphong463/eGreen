<?php
session_start();
require_once('db/dbhelper.php');
require_once 'vendor/autoload.php';


define("APPPATH", "phpMailer/");
include APPPATH . "PHPMailer.php";
include APPPATH . "Exception.php";
include APPPATH . "OAuth.php";
include APPPATH . "POP3.php";
include APPPATH . "SMTP.php";

use PHPMAILER\PHPMailer\PHPMailer;
use PHPMAILER\PHPMailer\Exception;
use PHPMAILER\PHPMailer\SMTP;

function generateVerificationCode($length = 6)
{
    $characters = '0123456789';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

$verificationCode = generateVerificationCode();
$_SESSION['verification'] = $verificationCode;





if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $err = [];



    if (empty($username)) {
        $err['username'] = 'username must not be empty';
    } else {
        if (!preg_match("/^[a-zA-Z0-9]{5,15}$/", $username)) {
            $err['username'] = 'username must be from 5 to 25 characters';
        }
    }
    if (empty($email)) {
        $err['email'] = 'Email must not be empty';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err['email'] = 'Invalid email';
        } else {
            // Kiểm tra email có tồn tại trong db chưa
            $sql1 = "SELECT * FROM users WHERE email='$email' AND Type = 'user'";
            $checkRegister = executeSingleResult($sql1);

            if ($checkRegister) {
                $err['email'] = 'This email is already in use';
            }
        }
    }

    if (empty($phone)) {
        $err['phone'] = 'phone must be not empty';
    } else {
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $err['phone'] = 'phone must not be 10 numbers and not have characters';
        }
    }
    if (empty($address)) {
        $err['address'] = 'address must be not empty';
    } else {
        if (!preg_match("/^[a-zA-Z0-9 ]{1,60}$/", $address)) {
            $err['address'] = 'Maximum length must not exceed 60 characters, including digits; minimum is 10 characters.';
        }
    }
    if (empty($fullname)) {
        $err['fullname'] = 'fullname must be not empty';
    } else {
        if (!preg_match("/^[a-zA-Z]{5,25}$/", $fullname)) {
            $err['fullname'] = 'fullname must be from 5 to 25 characters and not a number';
        }
    }
    if (empty($password)) {
        $err['password'] = 'password must be not empty';
    } else {
        if (!preg_match("/^[a-zA-Z0-9]{5,20}$/", $password)) {
            $err['password'] = 'password must be from 5-10 characters and numbers';
        }
    }
    if (empty($cpassword)) {
        $err['cpassword'] = 'cpassword must be not empty';
    } else {
        if ($cpassword != $password) {
            $err['cpassword'] = 'password and cpassword must be as same';
        }
    }



    // if (empty($birth)) {
    //     $err['birth'] = 'birth must be not empty';
    // } else {
    //     $birthday_date = new DateTime($birth);

    //     $current_date = new DateTime();
    //     $formatted_birthday = $birthday_date->format('m-d-Y');
    //     $minimum_age_date = $current_date->sub(new DateInterval('P16Y'));

    //     if ($birthday_date > $minimum_age_date) {
    //         $err['birth'] = 'You must be at least 16 years old to proceed!';
    //     }
    // }



    if (empty($err)) {
        $pass = password_hash($password, PASSWORD_DEFAULT);



        $sql = "INSERT INTO users(username,fullname,phone,address,email,status,password,Type,role) VALUES ('$username','$fullname','$phone','$address','$email',2,'$pass','user',3)";
        execute($sql);
        $_SESSION['email'] = $email;

        $receiver = $email;
        $subjects = "Your code to verify here:";
        $messages = '<a href="http://localhost/techwiz/verificationPage.php?email=' . $email . '">Click me to verify</a>';
        $senderEmail = 'davidphuc91@gmail.com';

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = 'davidphuc91@gmail.com';
        $mail->Password = 'xmqclbncliprazpp';
        $mail->setFrom($senderEmail);
        $mail->addReplyTo($senderEmail);
        $mail->addAddress($receiver);
        $mail->Subject = $subjects;
        $mail->msgHTML($messages);

        if (!$mail->send()) {
            $error = "Loi : " . $mail->ErrorInfo;
            echo '<p>' . $error . '<p/>';
        } else {
            echo "<script>alert('Your mail has been sent,please check your mail to verify');
            window.location.href = 'user-login.php';
                </script>";
        }
    }
 
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sigh up</title>

    <!-- link Icon https://boxicons.com -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/login.css">
    <style>
        .has-error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Register</h1>
            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['username'])) ? $err['username'] : ''; ?></span>
                </div>
                <input type="text" placeholder="Username" name="username" value="<?php echo isset($username) ? $username : ''; ?>">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['fullname'])) ? $err['fullname'] : ''; ?></span>
                </div>
                <input type="text" placeholder="Fullname" name="fullname" value="<?php echo isset($fullname) ? $fullname : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['email'])) ? $err['email'] : ''; ?></span>
                </div>
                <input type="text" placeholder="Email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['phone'])) ? $err['phone'] : ''; ?></span>
                </div>
                <input type="text" placeholder="Phone" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['address'])) ? $err['address'] : ''; ?></span>
                </div>
                <input type="text" placeholder="Address" name="address" value="<?php echo isset($address) ? $address : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['password'])) ? $err['password'] : ''; ?></span>
                </div>
                <input type="password" placeholder="New Password" name="password" value="<?php echo isset($password) ? $password : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="input-box">
                <div class="has-error">
                    <span><?php echo (isset($err['cpassword'])) ? $err['cpassword'] : ''; ?></span>
                </div>
                <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo isset($cpassword) ? $cpassword : ''; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <!-- <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forgot password</a>
            </div> -->
            <br><br>
            <button type="submit" class="btn" name="create">Create new account</button>

        </form>
    </div>
</body>

</html>