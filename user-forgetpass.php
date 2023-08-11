<?php
session_start();
include_once('db/dbhelper.php');
 // Import thư viện firebase/php-jwt
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;


define("APPPATH", "phpMailer/");
include APPPATH . "PHPMailer.php";
include APPPATH . "Exception.php";
include APPPATH . "OAuth.php";
include APPPATH . "POP3.php";
include APPPATH . "SMTP.php";

use PHPMAILER\PHPMailer\PHPMailer;
use PHPMAILER\PHPMailer\Exception;
use PHPMAILER\PHPMailer\SMTP;

$datedb = $user_id='';
$isActive = true; // Giá trị ban đầu của biến $isActive

$email = '';




// Tạo mã token
function createToken($secretKey, $expirationTimeMinutes) {
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





if(isset($_POST['forget'])){
$email = $_POST['email'];
$_SESSION['forgetagain'] = $email;
$err = [];

$sql = "SELECT * FROM users WHERE email = '$email'";
$checkEmail = executeSingleResult($sql);
$user_id = $checkEmail['user_id'];




// else{
//     echo "<script>
//     alert('email is correct');
//     </script>";
// }
if(empty($email)){
    $err['email'] = 'email is required';
}
else{
    if(empty($checkEmail)){
        $err['email'] = 'email not exist';
        }
        else{
//         $sql = "SELECT create_at FROM forget_pass WHERE user_id = '$user_id'";
// $checkcreate_at = executeSingleResult($sql);

//   date_default_timezone_set('Asia/Ho_Chi_Minh');
// $datedb = strtotime($checkcreate_at["create_at"]);
//         $date = time(); 
//    $time = ($date-$datedb)/60;
//    if(empty($checkcreate_at)||!empty($checkcreate_at)&&$time>60){
    
    $secretKey = 'your_secret_key';
        $expirationTimeMinutes = 60; // Thời gian hết hạn token: 60 phút
        $token = createToken($secretKey, $expirationTimeMinutes);
            $sql="INSERT INTO forget_pass (user_id,token,create_at,duration,isActive) VALUES('$user_id','$token',NOW(),'$expirationTimeMinutes','false')";
            execute($sql);
        $receiver = $_POST['email'];
        $subject = "Your code to resetpassword here:";
        $message = "http://localhost/techwiz/user-resetpass.php?token=$token&user_id=$user_id";
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
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        
        if (!$mail->send()) {
            $error = "Loi : " . $mail->ErrorInfo;
            echo '<p>' . $error . '<p/>';
        } else {
            echo "
            <script>alert('The code has been given to your mail');</script>
            <script>alert('Check your mail ! If you don't have a code,please SendLinkAgain');</script>
            ";
            $isActive=false;
            
        }

   }
       
        }

        
        }

        if(isset($_POST['forgetagain'])){
$email = $_SESSION['forgetagain'];

$sql = "SELECT * FROM users WHERE email = '$email'";
$checkEmail = executeSingleResult($sql);
$user_id = $checkEmail['user_id'];

            $secretKey = 'your_secret_key';
            $expirationTimeMinutes = 60; // Thời gian hết hạn token: 60 phút
            $token = createToken($secretKey, $expirationTimeMinutes);
                $sql="INSERT INTO forget_pass (user_id,token,create_at,duration,isActive) VALUES('$user_id','$token',NOW(),'$expirationTimeMinutes','false')";
                execute($sql);
            $receiver = $_POST['email'];
            $subject = "Your code to resetpassword here:";
            $message = "http://localhost/techwiz/user-resetpass.php?token=$token&user_id=$user_id";
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
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            
            if (!$mail->send()) {
                $error = "Loi : " . $mail->ErrorInfo;
                echo '<p>' . $error . '<p/>';
            } else {
                echo "
                <script>alert('The code has been given to your mail');</script>
                <script>alert('Check your mail ! If you don't have a code,please SendLinkAgain');</script>
                ";
                unset($_SESSION['forgetagain']);
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
        .has-error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Forget Password</h1>
            <div class="input-box">
            <?php if ($isActive) { ?>
                <div class="has-error">
                    <span><?php echo (isset($err['email'])) ? $err['email'] : ''; ?></span>
                </div>
                <input class="input100" type="text" name="email" placeholder="Email">
                <i class='bx bxs-user'></i>
                <button type="submit" class="btn" name="forget">Sendlink</button>
        <?php }else{ ?>
            <input class="input100" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" readonly>
                <i class='bx bxs-user'></i>
                <button type="submit" class="btn" name="forgetagain">SendlinkAgain</button>
            <?php } ?>
            </div>
            
            

            <!-- <div class="register-link">
                <p>You don't have an account ? <a href="register.php">Register</a></p>
            </div> -->
        </form>
    </div>
</body>

</html>